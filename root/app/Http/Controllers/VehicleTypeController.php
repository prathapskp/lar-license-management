<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Auth, Session, Response, DB,Datatables;
use App\VehicleType;
use App\LicenseType;
use App\LicenseTypeVehicleType;
class VehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vehicle_types.list');
    }
     public function ajax_data() {
       $rows = DB::table('vehicle_types')
            ->select(DB::raw('id, type, created_at'))
            ->whereNull('deleted_at');
            

        return Datatables::of($rows)
            ->add_column('action', '<a href="'.url('vehicle-type/edit').'/{{ $id }}">Edit</a>&nbsp;<a href="'.url('vehicle-type/delete').'/{{ $id }}">Delete</a>')
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $license_types = LicenseType::all();
         $options = array();
         if(!empty($license_types)) {
            foreach ($license_types as $license_type) {
                $options[$license_type->id] = $license_type->type;
            }
         }         
        return view('vehicle_types.create',compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $rules = array('type' => 'required|unique:vehicle_types');
        
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);          
        } 
        $license_types = $request->license_type_id; 
        if(empty($license_types[0])) {
            return redirect()->back()->with('error', 'Atleast select one license type');
        }
            $model = new VehicleType;
            $model->type = $request->type;
            $model->save();
           // echo $model->id;exit;
             foreach ($license_types as $license_type) {
                $model1 = new LicenseTypeVehicleType;           
                $model1->license_type_id = $license_type;
                $model1->vehicle_type_id = $model->id;
                $model1->save();
            }
            Session::flash('flash_message', 'Vehicle type has been successfully added!');
             return Redirect::to('/vehicle-types');
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
        $license_type_arr = array();
       $license_types = VehicleType::find($id)->license_types->toArray();
        if(!empty($license_types)) {
            foreach ($license_types as $license_type) {
                $license_type_arr[] =  $license_type['id'];
            }
        }
        $type = VehicleType::find($id); 
         $options = array();
         $license_types = LicenseType::all();
         if(!empty($license_types)) {
            foreach ($license_types as $license_type) {
                $options[$license_type->id] = $license_type->type;
            }
         }
        return view('vehicle_types.update',compact('type', 'options', 'license_type_arr'));
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
        $type = VehicleType::findOrFail($id);   // check and exit if user not present

        $rules = array('type' => 'required|unique:vehicle_types,type,'.$request->id);  
         $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);                      
        } 
        $license_types_arr = $request->license_type_id; 
        if(empty($license_types_arr[0])) {
            return redirect()->back()->with('error', 'Atleast select one license type');
        }
        $vehicle_type_id = $request->id;        
        // validate all the required fields
        $type->fill($request->all())->save();

        DB::delete("DELETE FROM license_type_vehicle_type WHERE license_type_id NOT IN  ( '" . implode($license_types_arr, "', '") . "' ) AND vehicle_type_id = $vehicle_type_id"); 
        $values_arr = array();
       if(!empty($license_types_arr))
            foreach ($license_types_arr as $license_type_id) {
                $values_arr[] = "($license_type_id, $vehicle_type_id)";
            }
        DB::insert("INSERT IGNORE INTO license_type_vehicle_type (license_type_id,vehicle_type_id) VALUES ".implode(", ", $values_arr));
        Session::flash('flash_message', 'Vehicle type has been successfully updated!');
        return Redirect::to('/vehicle-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = VehicleType::findOrFail($id);
        $model->delete();
        Session::flash('flash_message', 'Vehicle type has been successfully deleted!');
        return redirect()->back();
    }
}
