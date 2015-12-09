<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Auth, Session, Response;

use Illuminate\Http\Request;
use Hash;

use App\User;

class UserController extends Controller
{
    
    /**
     * Display login page to the admin user.
     *
     * @return Response
     */
    public function login() {
        return view('login');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function do_login() {
        
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
            return Redirect::to('/login')->withErrors($validator)
            
            // send back all errors to the login form
            ->withInput(Input::except('password'));
            
            // send back the input (not the password) so that we can repopulate the form
            
            
        } 
        else {
            $remember = Input::get('remember');
            
            // create our user data for the authentication
            $userdata = array('email' => Input::get('email'), 'password' => Input::get('password'), 'user_role' => 1);
            
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
     
    public function do_logout() {
        Auth::logout();
         // log the user out of our application
        return Redirect::to('login');
         // redirect the user to the login screen
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     *@return Response
     */
    public function edit(Request $request, $id = null) {
        $this->middleware('auth');
         
        if ($request->segment(1) === 'api') {
             // app
            try {
                $statusCode = 200;
                $response = array();
                
                $response['profile'] = User::findOrFail($id);
            }
            catch(Exception $e) {
                $statusCode = 400;
            }
            finally {
                return Response::json($response, $statusCode);
            }
        } 
        else {
             // web
            $id = Session::get('user_id');
            $user = User::findOrFail($id);
            return view('user.profile',compact('user'));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request) {
            $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_no' => 'required'
        ]);
        if(!empty($request->password)) {
            if(strlen($request->password) < 6) {
                 return redirect()->back()->with('error', 'Password Must be atleast 6 characters length');
            }
            if($request->password != $request->confirm_password) {
                return redirect()->back()->with('error', 'Password should match with confirm password');
            }
        }
        $user = User::findOrFail($id);       

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile_no = $request->mobile_no;
        if(!empty($request->password))
            $user->password = Hash::make($request->password);
        $user->save();
        Session::flash('flash_message', 'Profile has successfully updated!');
        return redirect()->back();
    }

}
