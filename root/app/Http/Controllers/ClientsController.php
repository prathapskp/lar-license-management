<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Auth, Session, Response, DB,Datatables;
use Hash;
use App\User;
use App\ExternalLibraries\xmlapi;
class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clients.list');
    }

    public function ajax_data() {
       $rows = DB::table('users')
            ->select(DB::raw('id, first_name, last_name, email, subdomain, created_at, IF(status="1", "<span class=\"label label-success\">Active</span>", "<span class=\"label label-danger\">Inactive</span>") as status'))
            ->where('added_by','=', Session::get('user_id'))
            ->whereNull('deleted_at');
            

        return Datatables::of($rows)
            ->add_column('action', '<a href="'.url('clients/edit').'/{{ $id }}">Edit</a>&nbsp;<a href="'.url('clients/delete').'/{{ $id }}">Delete</a>')
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array('email' => 'required|email|unique:users',        
        'password'  => 'required|alphaNum|min:6',
        'first_name'=> 'required',
        'last_name' => 'required',
        'mobile_no' => 'required',
        'subdomain' =>  'required|alphaNum|min:3|unique:users'
         );
        
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)            
            ->withInput(Input::except('password'));                      
        } 
        else {
            $insert_data = array('first_name' => Input::get('first_name'), 'last_name' => Input::get('last_name'), 'email' => Input::get('email'), 'subdomain' => Input::get('subdomain'), 'status' => 1, 'password' => Hash::make(Input::get('password')), 'user_role' => '2', 'added_by' => Session::get('user_id'));
            $user = User::create($insert_data);
        }
        $this->create_subdomain(Input::get('subdomain'), 'genacle', 'Fantastic@5', 'genacle.com');
        Session::flash('flash_message', 'Client record has been added successfully!');
        return Redirect::to('/clients');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
         return view('clients.edit',compact('user'));        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $input = $request->all();// get all the post values

         $user = User::findOrFail($id);   // check and exit if user not present

        $rules = array('email' => 'required|email|unique:users,email,'.$request->id,        
        'first_name'=> 'required',
        'last_name' => 'required',
        'mobile_no' => 'required',
        'subdomain' => 'required|alphaNum|min:3|unique:users,subdomain,'.$request->id,  
        );        
        //create rules
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)            
            ->withInput(Input::except('password'));                      
        } 
        // validate all the required fields
        if(!empty($request->password)) {
            if(strlen($request->password) < 6) {
                 return redirect()->back()->with('error', 'Password Must be atleast 6 characters length');
            }
            if($request->password != $request->confirm_password) {
                return redirect()->back()->with('error', 'Password should match with confirm password');
            }
            // on validation success
            $input['password'] = Hash::make($request->password);
        }
        // validate password and confirm password
        // on validation success        
        $input['status'] = ($request->status) ? 1 : 0;
        $user->fill($input)->save();
        Session::flash('flash_message', 'Client record has been successfully updated!');
        return Redirect::to('/clients');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = User::findOrFail($id);
        $model->delete();
        Session::flash('flash_message', 'Client has been successfully deleted!');
        return redirect()->back();
    }

    /** client dashboard view */
    public function dashboard()
    {
        return view('test');
    }

    /** get client assigned vehicles. */
    public function assigned_vehicles() {
        return view('clients.client_vehicles');
        /*$user_id = Session::get('user_id');
        $vehicles = User::find($user_id)->vehicles->toArray();
        print_r($vehicles);*/
    }
    /** get assigned vehicle datatable data */
    public function ajax_vehicle_data() {
        $user_id = Session::get('user_id');
          $rows = DB::table('vehicles')
            ->select(DB::raw('id, plate_number, registration_number, owner_name, owner_email, owner_phone, created_at'))
            ->where('client_id', '=', $user_id)
            ->whereNull('deleted_at');
            

        return Datatables::of($rows)
         ->add_column('action', '<a href="'.url('vehicle/renewal_request').'/{{ $id }}">Request a Renewal</a>')
            ->make(true);
    }
   
    /**
     * Display login page to the client user.
     *
     * @return Response
     */
    public function client_login() {
        return view('clients.login');
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function do_client_login() {
        
        // validate the info, create rules for the inputs
        $rules = array('email' => 'required|email',
        
        // make sure the email is an actual email
        'password' => 'required|alphaNum|min:6'
        
        // password can only be alphanumeric and has to be greater than 3 characters
        );
        
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('/client/login')->withErrors($validator)
            
            // send back all errors to the login form
            ->withInput(Input::except('password'));
            
            // send back the input (not the password) so that we can repopulate the form
            
            
        } 
        else {
            $remember = Input::get('remember');
            
            // create our user data for the authentication
            $userdata = array('email' => Input::get('email'), 'password' => Input::get('password'), 'user_role' => 2);
            
            // attempt to do the login
            if (Auth::attempt($userdata, $remember)) {
                $user_data = Auth::user();
                Session::put('user_id', $user_data->id);
                Session::put('name', $user_data->name);
                Session::put('email_address', $user_data->email_address);
                Session::put('role', $user_data->user_role);
                if($user_data->user_role == 1)
                    return Redirect::to('/');
                elseif($user_data->user_role == 2)
                    return Redirect::to('http://'.$user_data->subdomain.'.genacle.com/client/dashboard');
                    //return Redirect::to('/client/dashboard');
                //redirect based on roles.
            } 
            else {
                
                // validation not successful, send back to form
                //    return Redirect::to('login');
                return redirect()->back()->with('error', 'Invalid credentials!');
            }
        }
    }
    /** create subdomian for the clients */
    function create_subdomain($subDomain,$cPanelUser,$cPanelPass,$rootDomain) {     
    $domain = $rootDomain;
    $subdomain = $subDomain; 
    $username = $cPanelUser;
    $password = $cPanelPass;
    $targetFolder = 'public_html/eazypaper'; 
    
    $xmlapi = new xmlapi($domain );
    $xmlapi->set_port('2083');
    $xmlapi->password_auth($username, $password);
    $xmlapi->set_debug(0); // or you can use 1
    $xmlapi->set_output('xml'); // you can use 'json'
    $args = array($subdomain, $domain , 0, 0, $targetFolder);
    $res = $xmlapi->api1_query($username, 'SubDomain', 'addsubdomain', $args);       
    }
}
