<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Auth, Session, Response, DB,Datatables;
use App\LicenseType;
class LicenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('license_types.list');
    }
    public function ajax_data() {
       $rows = DB::table('license_types')
            ->select(DB::raw('id, type, created_at'))
            ->whereNull('deleted_at');
            

        return Datatables::of($rows)
            ->add_column('action', '<a href="'.url('license-type/edit').'/{{ $id }}">Edit</a>&nbsp;<a href="'.url('license-type/delete').'/{{ $id }}">Delete</a>')
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('license_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array('type' => 'required|unique:license_types');
        
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);          
        } 
                  
            LicenseType::create($request->all());
            Session::flash('flash_message', 'License type has been successfully added!');
             return Redirect::to('/license-types');
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
        $type = LicenseType::findOrFail($id);
        return view('license_types.update',compact('type'));
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
     $type = LicenseType::findOrFail($id);   // check and exit if user not present

        $rules = array('type' => 'required|unique:license_types,type,'.$request->id);  
         $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);                      
        } 
        // validate all the required fields
        $type->fill($request->all())->save();
        Session::flash('flash_message', 'License type has been successfully updated!');
        return Redirect::to('/license-types');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = LicenseType::findOrFail($id);
        $model->delete();
        Session::flash('flash_message', 'License type has been successfully deleted!');
        return redirect()->back();
    }
}
