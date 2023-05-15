<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use App\Http\Requests\Dashboard\StoreUserRequest;
use App\Http\Requests\Dashboard\PutUserRequest;
use Inertia\Inertia;

class AppUserController extends Controller
{
    public function __construct()
   {
       $this->middleware(['role:super|admin']);
   }

   public function appUsersIndex(): \Inertia\Response
   {
     return Inertia::render('appuser/appuser_index',[
        'users' => User::whereNotIn('user_type',['super'])->get()->map(function ($user) {
            return [
               'id' => $user->id,
               'name' => $user->name,
               'email' => $user->email,
               'created_at'=>$user->created_at,
               'updated_at'=>$user->updated_at
            ];
         }),
        'roles'=>Role::whereNotIn('name',['super'])->get()->map(function ($role) {
            return [
               'id' => $role->id,
               'name' => $role->name
            ];
         }),
     ]);
   }

   public function appUserCreateForm(): \Inertia\Response
   {
      return Inertia::render('appuser/appuser_store_form');
   }

   public function appUserStore(StoreUserRequest $request): \Illuminate\Http\RedirectResponse
   {
      $user=User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password'=>Hash::make( $request->input('password') ),
        'user_type'=>'admin'
      ]);
      return to_route('dashboard.appusers');
   }

   public function appUserEditForm(int $id): \Inertia\Response
   {
      return Inertia::render('appuser/appuser_edit_form',[
         'user'=>User::findorFail($id)
      ]);
   }

   public function appUserUpdate(PutUserRequest $request): \Illuminate\Http\RedirectResponse
   {
      $user=User::findOrFail($request->id);
      if(!empty($request->input('password'))){
         $user->forceFill([
            'name' => $request->input('name'),
            'email' =>$request->input('email'),
            'password'=>Hash::make( $request->input('password')),
            'user_type'=>'admin'
          ])->save();
      }
      else{
         $user->forceFill([
            'name' => $request->input('name'),
            'email' =>$request->input('email'),
            'user_type'=>'admin'
          ])->save();
      }
      sleep(1);
      return to_route('dashboard.appusers');
   }


   public function assignRoleToAppUser(Request $request) :void
   {
      $request->validate([
      'role' => ['required', Rule::notIn(['Select'])]
      ]);
      $user=User::findOrFail($request->user);
      sleep(1);
      $user->assignRole($request->input('role'));
   }


   public function appUserRevoke(Request $request) :void
   {
      $request->validate([
         'role' => ['required', Rule::notIn(['Select'])]
      ]);
      $user=User::findorFail($request->user);
      sleep(1);
      $user->removeRole($request->role);
   }

   public function appUserDestroy(int $id) :void
   {
     $user=User::findorFail($id);
     $user->delete();
   }

}
