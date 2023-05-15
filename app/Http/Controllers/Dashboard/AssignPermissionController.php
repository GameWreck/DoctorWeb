<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;


class AssignPermissionController extends Controller
{
   public function __construct()
   {
       $this->middleware(['role:super|admin']);
   }

   public function assignPermissionIndex(): \Inertia\Response
   {
      return Inertia::render('assignpermission/assignpermission_index',[
         'roles'=>Role::whereNotIn('name',['super'])->get(),
         'permissions'=>Permission::all(),
      ]);
   }

   public function assignPermissionAssign(Request $request) : void
   {
      $request->validate([
         'permission' => ['required', Rule::notIn(['Select'])]
       ]);
      $role=Role::findOrFail($request->role);
      sleep(1);
      $role->givePermissionTo($request->permission);
   }

   public function revokePermission(Request $request){

      $request->validate([
         'permission' => ['required', Rule::notIn(['Select'])]
       ]);
      $role=Role::findOrFail($request->role);
      sleep(1);
      $role->revokePermissionTo($request->permission);
   }

   public function allPermissionsAssigned(int $id): \Inertia\Response
   {
      $role=Role::findOrFail($id);
      return Inertia::render('assignpermission/allpermissions_assigned',[
          'assignedPermissions'=>$role->permissions,
          'role'=>$role
      ]);
   }

   public function revokeFromAllPermissions(Request $request) : void
   {
      $role=Role::findorFail($request->role);
      $permission=Permission::findorFail($request->permission);
      $role->revokePermissionTo($permission->name);
   }


}
