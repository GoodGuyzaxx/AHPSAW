<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentRequest;
use App\Http\Requests\Admin\StudentUpdateRequest;
use App\Imports\StudentsImport;
use App\Models\Kelas;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class StudentController extends Controller
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
        // Opsi untuk dropdown jumlah entri per halaman
        $perPageOptions = [5, 10, 15, 20, 25];
        $perPage = $request->query('perPage', $perPageOptions[1]); // Default 10 entri

        // Memulai Query Builder, bukan mengambil semua data
        $query = Student::query();

        // Menerapkan filter pencarian jika ada input 'search'
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';
            // Mencari berdasarkan nama ATAU npm
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                    ->orWhere('npm', 'like', $searchTerm);
            });
        }

        // Mengurutkan data, misalnya dari yang terbaru
        $query->latest(); // Ini adalah singkatan dari orderBy('created_at', 'DESC')

        // Sekarang, lakukan paginasi pada query yang sudah difilter dan diurutkan
        // withQueryString() penting agar filter tetap ada saat berpindah halaman
        $students = $query->paginate($perPage)->withQueryString();

        // Mengirim data ke view
        return view('pages.admin.student.data', [
            'title'           => 'Data Mahasiswa',
            'students'        => $students,
            'perPageOptions'  => $perPageOptions,
            'perPage'         => $perPage
        ]);
    }
//    public function index(Request $request)
//    {
//        // mengurutkan
//        $students = Student::all();
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
//        $students = $students->paginate($perPage, $this->fields, 'page', $page);
//
//        return view('pages.admin.student.data', [
//            'title'           => 'Data Mahasiswa',
//            'students'        => $students,
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
        $kelases = Kelas::all();

        return view('pages.admin.student.create', [
            'title'     => 'Tambah Data Siswa',
            'kelases'   => $kelases,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        $validatedData = $request->validated();

        // dd($validatedData);
        Student::create($validatedData);

        return redirect('/dashboard/student')
            ->with('success', 'Siswa baru telah ditambahkan!');
    }

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
    public function edit($id)
    {
        $student = Student::FindOrFail($id);
        $kelases = Kelas::all();

        return view('pages.admin.student.edit', [
            'title' => "Edit data $student->name",
            'student' => $student,
            'kelases' => $kelases
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentUpdateRequest $request, Student $student)
    {
        $validatedData = $request->validated();

        Student::where('id', $student->id)->update($validatedData);

        return redirect('/dashboard/student')
            ->with('success', 'Siswa yang dipilih telah diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        Student::destroy($student->id);

        return redirect('/dashboard/student')
            ->with('success', 'Siswa yang dipilih telah dihapus!');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file')->store('temp');

        try {
            $import = new StudentsImport;
            $import->import($file);
            if ('kelas_name' === null) {
                dd($import->errors());
            } else {
                return redirect('/dashboard/student')->with('success', 'Berkas Siswa Berhasil Diimpor!');
            }
            dd($import);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function export()
    {
        return Excel::download(new StudentsExport(), 'Data Siswa.xlsx');
    }
}
