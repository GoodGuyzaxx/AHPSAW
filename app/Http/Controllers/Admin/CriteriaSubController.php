<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CriteriaSubRequest;
use App\Http\Requests\Admin\CriteriaSubUpdateRequest;
use App\Models\Criteria;
use App\Models\CriteriaSub;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class CriteriaSubController extends Controller
{
    // pagination
    protected $limit = 10;
    protected $fields = array('criteria_subs.*');
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // mengurutkan
        $criteria_subs = CriteriaSub::orderby('criteria_id')
            ->orderby('name_sub');


        if (request('search')) {
            $criteria_subs->join('criterias', 'criterias.id', '=', 'criteria_subs.criteria_id')
                ->where('criteria_subs.name_sub', 'LIKE', '%' . request('search') . '%')
                ->orWhere('criteria_subs.value', 'LIKE', '%' . request('search') . '%')
                ->orWhere('criterias.name', 'LIKE', '%' . request('search') . '%')
                ->get();
        }

        // Get value halaman yang dipilih dari dropdown
        $page = $request->query('page', 1);

        // Tetapkan opsi dropdown halaman yang diinginkan
        $perPageOptions = [5, 10, 15, 20, 25];

        // Get value halaman yang dipilih menggunaakan the query parameters
        $perPage = $request->query('perPage', $perPageOptions[1]);

        // Paginasi hasil dengan halaman dan dropdown yang dipilih
        $criteria_subs = $criteria_subs->paginate($perPage, $this->fields, 'page', $page);

        return view('pages.admin.subkriteria.data', [
            'title'           => 'Data Sub Kriteria',
            'criteria_subs'        => $criteria_subs,
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
        $criterias = Criteria::all();

        return view('pages.admin.subkriteria.create', [
            'title'     => 'Tambah Sub Kriteria',
            'criterias'   => $criterias,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CriteriaSubRequest $request)
    {
        $validatedData = $request->validated();

        // dd($validatedData);
        CriteriaSub::create($validatedData);

        return redirect('/dashboard/subkriteria')
            ->with('success', 'Sub kriteria telah ditambahkan!');
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
        $criteria_sub = CriteriaSub::FindOrFail($id);
        $criterias = Criteria::all();

        return view('pages.admin.subkriteria.edit', [
            'title' => "Edit data $criteria_sub->name_sub",
            'criteria_sub' => $criteria_sub,
            'criterias' => $criterias
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CriteriaSubUpdateRequest $request, $id)
    {
        $data = $request->validated();

        $item = CriteriaSub::findOrFail($id);
        $item->update($data);

        return redirect('/dashboard/subkriteria')
            ->with('success', 'Sub kriteria yang dipilih telah diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $criteria_sub = CriteriaSub::findOrFail($id);
        $criteria_sub->delete();

        return redirect('/dashboard/subkriteria')
            ->with('success', 'Sub kriteria yang dipilih telah dihapus!');
    }
}
