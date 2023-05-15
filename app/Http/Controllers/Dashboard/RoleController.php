<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:super|admin']);
    }

    public function roleIndex(): \Inertia\Response
    {
       return Inertia::render('roles/role_index',[
              'roles'=>Role::whereNotIn('name',['super'])->get()
       ]);
    }


    public function roleStore(Request $request) :void
    {
        $request->validate([
            'name' => 'required|min:3|max:20|unique:roles',
        ]);
        sleep(1);
        Role::create([
            'name' => $request->name
        ]);
    }

    public function roleUpdate(Request $request) :void
    {
        $request->validate([
            'name' => ['required','min:3','max:20',Rule::unique('roles')->ignore($request->id)],
        ]);
        $role=Role::findorFail($request->id);
        sleep(1);
        $role->forceFill([
            'name'=>$request->name
        ])->save();
    }

    public function roleDestroy(int $id) :void
    {
        $role=Role::findORfail($id);
        $role->delete();
    }

}
