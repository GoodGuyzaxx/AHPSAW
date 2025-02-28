<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AlternativesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AlternativeStoreRequest;
use App\Http\Requests\Admin\AlternativeUpdateRequest;
use App\Imports\AlternativesImport;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;


class AlternativeController extends Controller
{
    // pagination
    protected $limit = 10;
    protected $fields = array('students.*', 'kelas.id as kelasId');
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // akses get
        if (auth()->user()->level === 'ADMIN' || auth()->user()->level === 'USER') {
            $alternatives = Alternative::with('user')->get();
        }

        // get student_id dari alternative
        $usedIds    = Alternative::select('student_id')->distinct()->get();
        $usedIdsFix = [];

        foreach ($usedIds as $usedId) {
            array_push($usedIdsFix, $usedId->student_id);
        }

        // menampilkan data alternatif
        $alternatives = Student::join('kelas', 'kelas.id', '=', 'students.kelas_id')
            ->whereIn('students.id', $usedIdsFix)
            ->orderBy('students.kelas_id')
            ->orderBy('students.name')
            ->with('alternatives');

        // dd(request('search'));
        // filter search
        if (request('search')) {
            $alternatives = Student::join('kelas', 'kelas.id', '=', 'students.kelas_id')
                ->where('students.name', 'LIKE', '%' . request('search') . '%')
                ->orWhere('kelas.kelas_name', 'LIKE', '%' . request('search') . '%')
                ->whereIn('students.id', $usedIdsFix)
                ->with('alternatives');
        }

        // @dd($alternatives);

        // student list tambah
        $studentsList = Student::join('kelas', 'kelas.id', '=', 'students.kelas_id')
            ->whereNotIn('students.id', $usedIdsFix)
            ->orderBy('kelas.id')
            ->orderBy('students.name', 'ASC')
            ->get(['students.*', 'kelas.id as kelasId'])
            ->groupBy('kelas.kelas_name');

        // Get value halaman yang dipilih dari dropdown
        $page = $request->query('page', 1);

        // Tetapkan opsi dropdown halaman yang diinginkan
        $perPageOptions = [5, 10, 15, 20, 25];

        // Get value halaman yang dipilih menggunaakan the query parameters
        $perPage = $request->query('perPage', $perPageOptions[1]);

        // Paginasi hasil dengan halaman dan dropdown yang dipilih
        $alternatives = $alternatives->paginate($perPage, $this->fields, 'page', $page);

        // Ambil semua kriteria
        $criterias = Criteria::with('criteriaSubs')->get();

        return view('pages.admin.alternatif.data', [
            'title'           => 'Data Alternatif',
            'alternatives'    => $alternatives,
            'criterias'       => $criterias,
            'student_list'    => $studentsList,
            'perPageOptions'  => $perPageOptions,
            'perPage'         => $perPage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(AlternativeStoreRequest $request)
    {
        // Validasi input
        $validated = $request->validated();

        // Pisahkan student_id dan kelas_id
        $pisah = explode(" ", $validated['student_id']);
        if (count($pisah) !== 2) {
            return redirect()->back()->withErrors(['student_id' => 'Invalid student ID format'])->withInput();
        }
        $studentId = $pisah[0];
        $kelasId = $pisah[1];

        // Verifikasi bahwa jumlah criteria_id sama dengan jumlah criteria_subs
        if (count($validated['criteria_id']) !== count($validated['criteria_subs'])) {
            return redirect()->back()->withErrors(['general' => 'semua kriteria harus di isi'])->withInput();
        }

        DB::beginTransaction();

        try {
            foreach ($validated['criteria_id'] as $key => $criteriaId) {
                $criteriaSub = $validated['criteria_subs'][$key];
                list($criteriaSubId, $alternativeValue) = explode('|', $criteriaSub);

                $data = [
                    'student_id' => $studentId,
                    'criteria_sub_id' => $criteriaSubId,
                    'criteria_id' => $criteriaId,
                    'kelas_id' => $kelasId,
                    'alternative_value' => $alternativeValue,
                ];

                Alternative::create($data);
            }

            DB::commit();

            return redirect('/dashboard/alternatif')
                ->with('success', 'Alternatif Baru telah ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['general' => 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage()])
                ->withInput();
        }
    }

//    public function store(AlternativeStoreRequest $request)
//    {
//        // Pisahkan student_id dan kelas_id
//        $pisah = explode(" ", $request->student_id);
//        $studentId = $pisah[0];
//        $kelasId = $pisah[1];
//
//        // Validasi input
//        $validated = $request->validated();
//
//        // Ambil data dari form
//        $criteriaIds = $validated['criteria_id'];
//        $criteriaSubs = $validated['criteria_subs']; // array berisi nilai "criteria_sub_id|alternative_value"
//
//        foreach ($criteriaSubs as $key => $criteriaSub) {
//            // Pisahkan criteria_sub_id dan alternative_value
//            list($criteriaSubId, $alternativeValue) = explode('|', $criteriaSub);
//
//            // Buat data untuk disimpan
//            $data = [
//                'student_id' => $studentId,
//                'criteria_sub_id' => $criteriaSubId,
//                'criteria_id' => $criteriaIds[$key],
//                'kelas_id' => $kelasId,
//                'alternative_value' => $alternativeValue,
//            ];
//
//            // Simpan data ke database
//            Alternative::create($data);
//        }
//
//        return redirect('/dashboard/alternatif')
//            ->with('success', 'Alternatif Baru telah ditambahkan!');
//    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Alternative $alternatif)
    {
        // cek apakah ada kriteria baru yang belum diisi oleh pengguna
        $selectedCriteria = Alternative::where('student_id', $alternatif->student_id)->pluck('criteria_id');
        $newCriterias     = Criteria::whereNotIn('id', $selectedCriteria)->get();

        $alternatives      = Student::where('id', $alternatif->student_id)
            ->with('alternatives', 'alternatives.criteria')->first();

        // dd($alternatives);
        return view('pages.admin.alternatif.edit', [
            'title'        => "Edit Nilai $alternatives->name",
            'alternatives'  => $alternatives,
            'newCriterias' => $newCriterias
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(AlternativeUpdateRequest $request, Alternative $alternatif)
    {
        $validated = $request->validated();

        // Tambahkan nilai alternatif baru jika ada kriteria baru
        if ($request->has('new_student_id')) {
            // Pisahkan student_id dan kelas_id
            $pisah = explode(" ", $request->new_student_id);


            if (isset($validated['new_criteria_id']) && is_array($validated['new_criteria_id'])) {
                foreach ($validated['new_criteria_id'] as $key => $newCriteriaId) {
                    if (isset($validated['new_alternative_value'][$key])) {
                        $criteriaSub = explode('|', $validated['new_alternative_value'][$key]);
                        $data = [
                            'student_id'        => $pisah[0],
                            'kelas_id'          => $validated['new_kelas_id'],
                            'criteria_id'       => $newCriteriaId,
                            'criteria_sub_id'   => $criteriaSub[0],
                            'alternative_value' => $criteriaSub[1],
                        ];

                        $alternatif->create($data);
                    }
                }
            }
        }

        // Perbarui nilai alternatif yang ada
        if (isset($validated['criteria_id']) && is_array($validated['criteria_id'])) {
            foreach ($validated['criteria_id'] as $key => $criteriaId) {
                if (isset($validated['alternative_value'][$key]) && isset($validated['alternative_id'][$key])) {
                    $criteriaSub = explode('|', $validated['alternative_value'][$key]);
                    $data = [
                        'criteria_id'       => $criteriaId,
                        'criteria_sub_id'   => $criteriaSub[0],
                        'alternative_value' => $criteriaSub[1],
                    ];

                    Alternative::where('id', $validated['alternative_id'][$key])
                        ->update($data);
                }
            }
        }

        return redirect('/dashboard/alternatif')
            ->with('success', 'Alternatif yang dipilih telah diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alternative $alternatif)
    {
        Alternative::where('student_id', $alternatif->student_id)
            ->delete();

        return redirect('/dashboard/alternatif')
            ->with('success', 'Alternatif yang dipilih telah dihapus!');
    }
}
