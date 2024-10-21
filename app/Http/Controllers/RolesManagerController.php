<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesManagerController extends Controller
{
    public function index()
    {
        // create a new role
        // $role = Role::create(['name' => 'administrator']);

        // create a new permission 
        // $permission = Permission::create(['name' => 'do-all']);

        // assign a role to a user
        // $user = User::first();
        // $user->assignRole('administrator');

        // give a permission to a role
        // $role = Role::findByName('administrator');
        // $role->givePermissionTo('do-all');
    }
}
