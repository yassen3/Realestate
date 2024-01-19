<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class AgentController extends Controller
{
    public function AgentDashboard()
    {
        return view('Agent.index');
    }

    public function AgentLogin(){

        return view('Agent.agent_login');

    } //End Method

    public function AgentRegister(request $request){

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'agent',
            'status' => 'inactive',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::AGENT);

    } //End Method

    public function AgentLogout(request $request){

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Agent Loged Out Successfully',
            'alert-type' => 'info'
        );

        return redirect('agent/login')->with($notification);
       }

       public function AgentProfile(){
        $id = Auth::user()->id;
        $profileData= User::find($id);
        return view('Agent.agent_profile_view',compact('profileData'));
       }

       public function AgentProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo')->encode('webp');
            @unlink(public_path('upload/agent_images/'.$data->photo));
            $filename = date('YmdHi').$file.'.webp';
            $file->move(public_path('upload/agent_images'),$filename);
            $data->photo = $filename;

        }

        $data->save();

        $notification = array(
            'message'=>'Agent Profile Updated Successfully',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notification);
       }

       public function AgentChangePassword(){
        $id = Auth::user()->id;
        $profileData= User::find($id);
        return view('Agent.agent_change_password',compact('profileData'));
       }

       public function AgentUpdatePassword(Request $request){

        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'

        ]);

        /// Match The Old Password

        if (!Hash::check($request->old_password, auth::user()->password)) {

           $notification = array(
            'message' => 'Old Password Does not Match!',
            'alert-type' => 'error'
        );

        return back()->with($notification);
        }

        /// Update The New Password

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)

        ]);

         $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);

     }// End Method
}