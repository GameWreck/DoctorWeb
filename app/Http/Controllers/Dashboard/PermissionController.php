<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super|admin']);
    }

    public function permissionIndex(): \Inertia\Response
    {
       return Inertia::render('permissions/permission_index',[
              'permissions'=>Permission::all()
       ]);
    }

    public function permissionStore(Request $request) : void
    {
        $request->validate([
            'name' => 'required|min:3|max:20|unique:permissions',
        ]);
        sleep(1);
        Permission::create([
            'name' => $request->name
        ]);
    }

    public function permissionUpdate(Request $request) : void
    {
        $request->validate([
            'name' => ['required','min:3','max:20',Rule::unique('permissions')->ignore($request->id)],
        ]);
        $permission=Permission::findorFail($request->id);
        sleep(1);
        $permission->forceFill([
            'name'=>$request->name
        ])->save();
    }

    public function permissionDestroy(int $id) : void
    {
        $permission=Permission::findORfail($id);
        sleep(1);
        $permission->delete();
    }

}
