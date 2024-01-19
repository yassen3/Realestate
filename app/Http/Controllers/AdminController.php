<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
   public function AdminDashboard()
   {
    return view('Admin.index');
   }

   public function AdminLogout(request $request){

    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    $notification = array(
        'message' => 'Admin Loged Out Successfully',
        'alert-type' => 'info'
    );

    return redirect('admin/login')->with($notification);
   }

   public function AdminLogin(){
    return view('admin.admin_login');
   }

   public function AdminProfile(){
    $id = Auth::user()->id;
    $profileData= User::find($id);
    return view('admin.admin_profile_view',compact('profileData'));
   }

   public function AdminProfileStore(Request $request){
    $id = Auth::user()->id;
    $data = User::find($id);
    $data->username = $request->username;
    $data->name = $request->name;
    $data->email = $request->email;
    $data->phone = $request->phone;
    $data->address = $request->address;

    if($request->file('photo')){
        $file = $request->file('photo');
        @unlink(public_path('upload/admin_images/'.$data->photo));
        $filename = date('YmdHi').$file.'.webp';
        $file->move(public_path('upload/admin_images'),$filename);
        $data->photo = $filename;

    }

    $data->save();

    $notification = array(
        'message'=>'Admin Profile Updated Successfully',
        'alert-type'=>'success'
    );
    return redirect()->back()->with($notification);
   }

   public function AdminChangePassword(){
    $id = Auth::user()->id;
    $profileData= User::find($id);
    return view('admin.admin_change_password',compact('profileData'));
   }

   public function AdminUpdatePassword(Request $request){

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

 // Agent User All Method
 public function AllAgent(){
    $allagent = User::where('role','agent')->get();
    return view('backend.agentuser.all_agent',compact('allagent'));
 }

 public function AddAgent(){

    return view('backend.agentuser.add_agent');
 }

 public function StoreAgent(request $request){

    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required',
        'password' => 'required',
    ]);

    User::insert([
        'name'=>$request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'address'=>$request->address,
        'password'=>Hash::make($request->password),
        'role'=>'agent',
        'status'=>'active'
    ]);

    $notification = array(
        'message' => 'Agent Created Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('all.agent')->with($notification);
 }

 public function EditAgent($id){

    $allagent = User::findorfail($id);
    return view('backend.agentuser.edit_agent',compact('allagent'));

 }

 public function UpdateAgent(request $request){

    // $request->validate([
    //     'name' => 'required',
    //     'email' => 'required|email',
    //     'phone' => 'required',
    //     'address' => 'required',

    // ]);
    $agent_id = $request->id;
    User::findorfail($agent_id)->update([
        'name'=>$request->name,
        'email'=>$request->email,
        'phone'=>$request->phone,
        'address'=>$request->address,

    ]);
    $notification = array(
        'message' => 'Agent Updated Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('all.agent')->with($notification);
 }

 public function DeleteAgent($id){
    User::findorfail($id)->delete();

    $notification = array(
        'message' => 'Agent Deleted Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('all.agent')->with($notification);
 }

 public function changeStatus(request $request){
    $user = User::findorfail($request->user_id);
    $user->status = $request->status;
    $user->save();

    return response()->json(['success'=>'Status Changes Successfully']);
 }

 public function AllAdmin(){

    $alladmin = User::where('role','admin')->get();
    return view('backend.pages.admin.all_admin',compact('alladmin'));

  }// End Method

  public function AddAdmin(){

    $roles = Role::all();
    return view('backend.pages.admin.add_admin',compact('roles'));

  }// End Method


  public function StoreAdmin(Request $request){

    $user = new User();
    $user->username = $request->username;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->address = $request->address;
    $user->password =  Hash::make($request->password);
    $user->role = 'admin';
    $user->status = 'active';
    $user->save();

    if ($request->roles) {
        $user->assignRole($request->roles);
    }

    $notification = array(
            'message' => 'New Admin User Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);

  }// End Method

  public function EditAdmin($id){

    $user = User::findOrFail($id);
    $roles = Role::all();
    return view('backend.pages.admin.edit_admin',compact('user','roles'));

  }// End Method

   public function UpdateAdmin(Request $request,$id){

    $user = User::findOrFail($id);
    $user->username = $request->username;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->address = $request->address;
    $user->role = 'admin';
    $user->status = 'active';
    $user->save();

    $user->roles()->detach();
    if ($request->roles) {
        $user->assignRole($request->roles);
    }

    $notification = array(
            'message' => 'New Admin User Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.admin')->with($notification);

  }// End Method

  public function DeleteAdmin($id){

    $user = User::findOrFail($id);
    if (!is_null($user)) {
        $user->delete();
    }

    $notification = array(
            'message' => 'New Admin User Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

  }// End Method

}