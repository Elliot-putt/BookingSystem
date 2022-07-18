<?php

namespace App\Jobs;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RoleBoot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //created default roles
        $global_admin = Role::updateOrCreate([
            'id' => 1
        ], [
            'name' => 'global_admin',
            'significance' => '5',
        ]);
        $guest = Role::updateOrCreate([
            'id' => 2
        ], [
            'name' => 'guest',
            'significance' => '1',
        ]);
        $user = Role::updateOrCreate([
            'id' => 2
        ], [
            'name' => 'user',
            'significance' => '2',
        ]);
        $staff = Role::updateOrCreate([
            'id' => 3
        ], [
            'name' => 'staff',
            'significance' => '3',
        ]);
        $manager = Role::updateOrCreate([
            'id' => 4
        ], [
            'name' => 'manager',
            'significance' => '4',
        ]);

        // global team start
        Permission::updateOrCreate([
            'role_id' => $global_admin->id,
            'model' => 'Booking'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $global_admin->id,
            'model' => 'Category'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $global_admin->id,
            'model' => 'Company'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $global_admin->id,
            'model' => 'CompanyService'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $global_admin->id,
            'model' => 'CompanyUser'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $global_admin->id,
            'model' => 'Log'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $global_admin->id,
            'model' => 'Permission'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $global_admin->id,
            'model' => 'Role'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $global_admin->id,
            'model' => 'Service'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $global_admin->id,
            'model' => 'Setting'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $global_admin->id,
            'model' => 'User'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        // global team end
        // manager team start
        Permission::updateOrCreate([
            'role_id' => $manager->id,
            'model' => 'Booking'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $manager->id,
            'model' => 'Category'
        ], [
            "Create" =>0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $manager->id,
            'model' => 'Company'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $manager->id,
            'model' => 'CompanyService'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $manager->id,
            'model' => 'CompanyUser'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $manager->id,
            'model' => 'Log'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $manager->id,
            'model' => 'Permission'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $manager->id,
            'model' => 'Role'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $manager->id,
            'model' => 'Service'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 1,
            "archive" => 1,
        ]);
        Permission::updateOrCreate([
            'role_id' => $manager->id,
            'model' => 'Setting'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $manager->id,
            'model' => 'user'
        ], [
            "Create" => 1,
            "update" => 0,
            "view" => 1,
            "delete" => 0,
            "archive" => 0,
        ]);
        // manager team end
        // guest  start
        Permission::updateOrCreate([
            'role_id' => $guest->id,
            'model' => 'Booking'
        ], [
            "Create" => 1,
            "update" => 0,
            "view" => 1,
            "delete" => 1,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $guest->id,
            'model' => 'Category'
        ], [
            "Create" =>0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $guest->id,
            'model' => 'Company'
        ], [
            "Create" => 1,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $guest->id,
            'model' => 'CompanyService'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $guest->id,
            'model' => 'CompanyUser'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $guest->id,
            'model' => 'Log'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $guest->id,
            'model' => 'Permission'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $guest->id,
            'model' => 'Role'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $guest->id,
            'model' => 'Service'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 1,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $guest->id,
            'model' => 'Setting'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $guest->id,
            'model' => 'user'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        // guest  end
        // staff  start
        Permission::updateOrCreate([
            'role_id' => $staff->id,
            'model' => 'Booking'
        ], [
            "Create" => 1,
            "update" => 0,
            "view" => 1,
            "delete" => 1,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $staff->id,
            'model' => 'Category'
        ], [
            "Create" =>0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $staff->id,
            'model' => 'Company'
        ], [
            "Create" => 1,
            "update" => 0,
            "view" => 1,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $staff->id,
            'model' => 'CompanyService'
        ], [
            "Create" => 1,
            "update" => 0,
            "view" => 1,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $staff->id,
            'model' => 'CompanyUser'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $staff->id,
            'model' => 'Log'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $staff->id,
            'model' => 'Permission'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $staff->id,
            'model' => 'Role'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $staff->id,
            'model' => 'Service'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $staff->id,
            'model' => 'Setting'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $staff->id,
            'model' => 'user'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        // staff  end
        // user  start
        Permission::updateOrCreate([
            'role_id' => $user->id,
            'model' => 'Booking'
        ], [
            "Create" => 1,
            "update" => 0,
            "view" => 1,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $user->id,
            'model' => 'Category'
        ], [
            "Create" =>0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $user->id,
            'model' => 'Company'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 1,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $user->id,
            'model' => 'CompanyService'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $user->id,
            'model' => 'CompanyUser'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $user->id,
            'model' => 'Log'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $user->id,
            'model' => 'Permission'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $user->id,
            'model' => 'Role'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $user->id,
            'model' => 'Service'
        ], [
            "Create" => 1,
            "update" => 1,
            "view" => 1,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $user->id,
            'model' => 'Setting'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        Permission::updateOrCreate([
            'role_id' => $user->id,
            'model' => 'user'
        ], [
            "Create" => 0,
            "update" => 0,
            "view" => 0,
            "delete" => 0,
            "archive" => 0,
        ]);
        // user  end
    }
}
