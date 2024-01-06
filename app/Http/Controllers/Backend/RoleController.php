<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    // Permission All Routes
    public function AllPermission(){
        $permission = Permission::all();
        return view('backend.pages.permission.all_permission',compact('permission'));
    }

    public function AddPermission(){

        return view('backend.pages.permission.add_permission');
    }

    public function StorePermission(request $request){

        $permission = Permission ::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);
        $notification = array(
            'message' => 'Permission Created Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.permission',compact('permission'))->with($notification);

    }

    public function EditPermission($id){
        $permission = Permission::findorfail($id);
        return view('backend.pages.permission.edit_permission',compact('permission'));
    }

    public function UpdatePermission(request $request){

        $per_id = $request->id;
        Permission::findorfail($per_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);
        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);
    }

    public function DeletePermission($id){
        permission::findorfail($id)->delete();

        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert' => 'success'
        );
        return redirect()->route('all.permission')->with($notification);
    }

    public function ImportPermission(){

        return view('backend.pages.permission.import_permission');
    }

    public function Export(){

        return Excel::download(new PermissionExport, 'permission.xlsx');
    }

    public function Import(request $request){
        Excel::import(new PermissionImport, $request->file('import_file'));
        $notification = array(
            'message' => 'Permission Imported Successfully',
            'alert' => 'success'
        );
        return redirect()->back()->with($notification);
    }
     // End Permission All Routes



    //  Roles All Routes  ////

    public function AllRole(){

        $roles = Role::all();
        return view('backend.pages.role.all_role',compact('roles'));
    }

    public function AddRole(){

        return view('backend.pages.role.add_role');
     }

     public function StoreRole(request $request){

        $role = Role ::create([
        'name' => $request->name,

        ]);
        $notification = array(
            'message' => 'Role Created Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.role',compact('role'))->with($notification);
     }

     public function EditRole($id){
        $roles = Role::find($id);
        return view('backend.pages.role.edit_role',compact('roles'));
     }

     public function UpdateRole(request $request){
        $role_id = $request->id;
        Role::findorfail($role_id)->update([
            'name' => $request->name,

        ]);
        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert' => 'success'
        );
        return redirect()->route('all.role')->with($notification);
     }

     public function DeleteRole($id){
        Role::findorfail($id)->delete();
        $notification = array(
            'message' => 'Role Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.role')->with($notification);
     }

     public function AddRolesPermission(){

        $role = Role::all();
        $permission = Permission::all();
        $permission_group = User::getpermissionGroup();
        return view('backend.pages.rolesetup.add_roles_permission',compact('role','permission','permission_group'));
     }

     public function RolePermissionStore(Request $request){

        $data = array();
        $permissions = $request->permission;

        foreach($permissions as $key => $item){
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);

        } // end foreach

        $notification = array(
            'message' => 'Role Permission Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles.permission')->with($notification);

    }// End Method

    public function AllRolesPermission(){
        $roles = Role::all();
        return view('backend.pages.rolesetup.all_roles_permission',compact('roles'));

    }

    public function AdminEditRoles($id){

        $role = Role::findorfail($id);
        $permission = Permission::all();
        $permission_groups = User::getpermissionGroup();
        return view('backend.pages.rolesetup.edit_roles_permission',compact('role','permission','permission_groups'));
    }

    public function AdminRolesUpdate(Request $request, $id){

        $role = Role::findOrFail($id);
        $permissions = $request->permission;

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        $notification = array(
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.roles.permission')->with($notification);

    }// End Method

    public function AdminDeleteRoles($id){

        $role = Role::findOrFail($id);
        if (!is_null($role)) {
            $role->delete();
        }

        $notification = array(
            'message' => 'Role Permission Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }// End Method
}
