<?php

namespace App\Http\Controllers\Usermanagement;

use App\Http\Controllers\Controller;
use App\Models\Affiliation;
use Illuminate\Http\Request;
use DataTables;
class AffiliationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data= Affiliation::all();
       
         return view('pages.user-management.affiliation.dtlist');
        // return "Affiliation Contrller Index to show"  .$data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return "Affiliation Create Method";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data= new Affiliation();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->save();
        return redirect()->back()->with('success','New Company Added Successfully');
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
        return "Affiliation Show Method";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return "Affiliation Edit Method";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return "Affiliation Update Method";
        $affiliation = Affiliation::find($id);
           $affiliation->name = $request->name;
           $affiliation->email = $request->email;
            $affiliation->phone = $request->phone;
            $affiliation->address = $request->address;

        $affiliation->save();
        return redirect()->back()->with('success','Affiliation Updated Successfully');
        // return response()->json(['message' => 'Affiliation Updated Successfully','redirect'=>route('user-management.affiliation.list.index')],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return "Affiliation Destroy Method";
    }

    public function datatableapi(Request $request){
        $model = Affiliation::get();

     if (isset($request->role_filter) && $request->role_filter != '') {
     $model = Affiliation::where('name',  $request->role_filter)->get();
    }
    return DataTables::of($model)
      ->setRowId(function ($row) {
        return $row->id;
      })
      ->addColumn('checkbox', function ($data) {
        return ' <div class="form-check form-check-sm form-check-custom form-check-solid">
        <input class="form-check-input" type="checkbox" value="' . $data->id . '" />
        </div>';
      })
      // ->addColumn('function', function ($data) {
      //         return $data->name;
      // })
      // ->addColumn('created',  function ($row) {
      //   return $row->created_at->format('d M, Y H:i:s');
      // })
      
      ->editColumn('action', function ($row) {

          return view('pages.user-management.affiliation.action', ['model' => $row]);
      })
      ->rawColumns(['checkbox', 'action','status'])
      ->make(true);
    } 

    public function bulkdelete(Request $request){
    if (isset($request->list) && $request->list != '') {
      $list = explode(',', $request->list);
      Affiliation::whereIn('id', $list)->delete();
    }
  }


}
