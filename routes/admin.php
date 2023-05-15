<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\AssignPermissionController;
use App\Http\Controllers\Dashboard\AppUserController;
use App\Http\Controllers\Dashboard\ProductController;

Route::middleware(['auth', 'verified'])->group(function () {

        Route::group(['middleware' => ['role:super|admin']], function () {

            Route::prefix('dashboard')->group(function () {

                Route::get('/home',[HomeController::class,'index'])->name('dashboard.home');
                //Roles
                Route::get('/roles',[RoleController::class,'roleIndex'])->name('dashboard.roles');
                Route::post('/roles/store',[RoleController::class,'roleStore'])->name('dashboard.roles.store');
                Route::put('/roles/update',[RoleController::class,'roleUpdate'])->name('dashboard.roles.update');
                Route::delete('/roles/destroy/{id}',[RoleController::class,'roleDestroy'])->name('dashboard.roles.destroy');
                //Permission
                Route::get('/permissions',[PermissionController::class,'permissionIndex'])->name('dashboard.permissions');
                Route::post('/permissions/store',[PermissionController::class,'permissionStore'])->name('dashboard.permissions.store');
                Route::put('/permissions/update',[PermissionController::class,'permissionUpdate'])->name('dashboard.permissions.update');
                Route::delete('/permissions/delete/{id}',[PermissionController::class,'permissionDestroy'])->name('dashboard.permissions.destroy');
                //Assign Permission
                Route::get('/assignpermission',[AssignPermissionController::class,'assignPermissionIndex'])->name('dashboard.assignpermission');
                Route::get('/assignpermission/detail/{id}',[AssignPermissionController::class,'allPermissionsAssigned'])->name('dashboard.assignpermission.detail');
                Route::post('/assignpermission/assign',[AssignPermissionController::class,'assignPermissionAssign'])->name('dashboard.assignpermission.assign');
                Route::delete('/revokepermission/revoke',[AssignPermissionController::class,'revokePermission'])->name('dashboard.assignpermission.revoke');
                Route::delete('/assignpermission/rollback/{role}/{permission}',[AssignPermissionController::class,'revokeFromAllPermissions'])->name('dashboard.assignpermission.rollback');
                //App User
                Route::get('/appusers',[AppUserController::class,'appUsersIndex'])->name('dashboard.appusers');
                Route::get('/appusers/create/form',[AppUserController::class,'appUserCreateForm'])->name('dashboard.appusers.createform');
                Route::get('/appusers/edit/form/{id}',[AppUserController::class,'appUserEditForm'])->name('dashboard.appusers.editform');
                Route::post('/appusers/form/store',[AppUserController::class,'appUserStore'])->name('dashboard.appusers.store');
                Route::post('/appusers/role/assign',[AppUserController::class,'assignRoleToAppUser'])->name('dashboard.appusers.asignrole');
                Route::put('/appusers/form/update',[AppUserController::class,'appUserUpdate'])->name('dashboard.appusers.update');
                Route::delete('/appusers/role/revoke',[AppUserController::class,'appUserRevoke'])->name('dashboard.appusers.revokerole');
                Route::delete('/appusers/{id}',[AppUserController::class,'appUserDestroy'])->name('dashboard.appusers.destroy');
                //Products
                Route::get('/products',[ProductController::class,'productIndex'])->name('dashboard.products');
                Route::get('/products/create',[ProductController::class,'productCreateShow'])->name('dashboard.products.create');
                Route::post('/products/store',[ProductController::class,'productStore'])->name('dashboard.products.store');
                Route::get('/products/edit/{id}',[ProductController::class,'productEditShow'])->name('dashboard.product.edit');
                Route::put('/products/update',[ProductController::class,'productUpdate'])->name('dashboard.product.update');



            });


        });
});

