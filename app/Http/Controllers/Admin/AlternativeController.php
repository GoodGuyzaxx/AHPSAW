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
    protected $fields = array('students.*');
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        // 1. Ambil ID semua siswa yang sudah menjadi alternatif
        $usedStudentIds = Alternative::pluck('student_id')->all();

        // 2. Opsi untuk dropdown jumlah entri per halaman
        $perPageOptions = [5, 10, 15, 20, 25];
        $perPage = $request->query('perPage', $perPageOptions[1]); // Default 10 entri

        // 3. Memulai Query Builder untuk menampilkan data alternatif (yaitu siswa yang terdaftar)
        $query = Student::whereIn('id', $usedStudentIds)
            ->with('alternatives') // Eager load relasi alternatives
            ->orderBy('name', 'ASC'); // Urutkan berdasarkan nama

        // 4. Menerapkan filter pencarian jika ada
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            // Pencarian hanya berdasarkan nama siswa, karena tidak ada lagi join ke kelas
            $query->where('name', 'like', $searchTerm);
        }

        // 5. Lakukan paginasi pada query yang sudah lengkap
        $alternatives = $query->paginate($perPage)->withQueryString();

        // 6. Ambil daftar siswa yang BELUM menjadi alternatif (untuk modal tambah)
        $studentsList = Student::whereNotIn('id', $usedStudentIds)
            ->orderBy('name', 'ASC')
            ->get();

        // 7. Ambil semua kriteria untuk ditampilkan di header tabel
        $criterias = Criteria::with('criteriaSubs')->get();

        // 8. Mengirim semua data yang diperlukan ke view
        return view('pages.admin.alternatif.data', [
            'title'           => 'Data Alternatif',
            'alternatives'    => $alternatives,
            'criterias'       => $criterias,
            'student_list'    => $studentsList,
            'perPageOptions'  => $perPageOptions,
            'perPage'         => $perPage
        ]);
    }
//    public function index(Request $request)
//    {
//        // akses get
//        if (auth()->user()->level === 'ADMIN' || auth()->user()->level === 'USER') {
//            $alternatives = Alternative::with('user')->get();
//        }
//
//        // get student_id dari alternative
//        $usedIds    = Alternative::select('student_id')->distinct()->get();
//        $usedIdsFix = [];
//
//        foreach ($usedIds as $usedId) {
//            array_push($usedIdsFix, $usedId->student_id);
//        }
//
//        // menampilkan data alternatif
//        $alternatives = Student::join('kelas', 'kelas.id', '=', 'students.kelas_id')
//            ->whereIn('students.id', $usedIdsFix)
//            ->orderBy('students.kelas_id')
//            ->orderBy('students.name')
//            ->with('alternatives');
//
//        // dd(request('search'));
//        // filter search
//        if (request('search')) {
//            $alternatives = Student::join('kelas', 'kelas.id', '=', 'students.kelas_id')
//                ->where('students.name', 'LIKE', '%' . request('search') . '%')
//                ->orWhere('kelas.kelas_name', 'LIKE', '%' . request('search') . '%')
//                ->whereIn('students.id', $usedIdsFix)
//                ->with('alternatives');
//        }
//
//        // @dd($alternatives);
//
//        // student list tambah
//        $studentsList = Student::join('kelas', 'kelas.id', '=', 'students.kelas_id')
//            ->whereNotIn('students.id', $usedIdsFix)
//            ->orderBy('kelas.id')
//            ->orderBy('students.name', 'ASC')
//            ->get('students.*')
//            ->groupBy('kelas.kelas_name');
//
//        // Get value halaman yang dipilih dari dropdown
//        $page = $request->query('page', 1);
//
//        // Tetapkan opsi dropdown halaman yang diinginkan
//        $perPageOptions = [5, 10, 15, 20, 25];
//
//        // Get value halaman yang dipilih menggunaakan the query parameters
//        $perPage = $request->query('perPage', $perPageOptions[1]);
//
//        // Paginasi hasil dengan halaman dan dropdown yang dipilih
//        $alternatives = $alternatives->paginate($perPage, $this->fields, 'page', $page);
//
//        // Ambil semua kriteria
//        $criterias = Criteria::with('criteriaSubs')->get();
//
//        return view('pages.admin.alternatif.data', [
//            'title'           => 'Data Alternatif',
//            'alternatives'    => $alternatives,
//            'criterias'       => $criterias,
//            'student_list'    => $studentsList,
//            'perPageOptions'  => $perPageOptions,
//            'perPage'         => $perPage
//        ]);
//    }

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
        // 1. Ambil data yang sudah divalidasi oleh AlternativeStoreRequest
        $validated = $request->validated();

        // 2. Ambil student_id langsung, karena tidak ada lagi kelas_id yang digabung
        $studentId = $validated['student_id'];

        // 3. [PENTING] Cek apakah mahasiswa ini sudah terdaftar sebagai alternatif
        if (Alternative::where('student_id', $studentId)->exists()) {
            return redirect()->back()
                ->withErrors(['student_id' => 'Mahasiswa ini sudah terdaftar sebagai alternatif. Silakan edit data yang ada.'])
                ->withInput();
        }

        // 4. Verifikasi ulang bahwa jumlah kriteria cocok (pengaman tambahan)
        if (count($validated['criteria_id']) !== count($validated['criteria_subs'])) {
            return redirect()->back()->withErrors(['general' => 'Semua kriteria harus diisi dengan lengkap.'])->withInput();
        }

        // 5. Gunakan transaksi database untuk memastikan semua data berhasil disimpan
        DB::beginTransaction();

        try {
            // 6. Loop melalui setiap kriteria yang dikirim dari form
            foreach ($validated['criteria_id'] as $key => $criteriaId) {
                // Ambil nilai subkriteria (format: "id|value")
                $criteriaSubValue = $validated['criteria_subs'][$key];

                // Pisahkan untuk mendapatkan id subkriteria dan nilainya
                list($criteriaSubId, $alternativeValue) = explode('|', $criteriaSubValue);

                // 7. Siapkan data untuk disimpan, tanpa 'kelas_id'
                $data = [
                    'student_id'      => $studentId,
                    'criteria_id'     => $criteriaId,
                    'criteria_sub_id' => $criteriaSubId,
                    'alternative_value' => $alternativeValue,
                ];

                // Buat record baru di tabel Alternative
                Alternative::create($data);
            }

            // Jika semua berhasil, simpan perubahan secara permanen
            DB::commit();

            return redirect('/dashboard/alternatif')
                ->with('success', 'Alternatif baru telah berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Jika terjadi error di tengah jalan, batalkan semua query
            DB::rollBack();

            // (Opsional) Catat error untuk debugging
            \Log::error('Gagal menyimpan alternatif: ' . $e->getMessage());

            // Kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()
                ->withErrors(['general' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'])
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
