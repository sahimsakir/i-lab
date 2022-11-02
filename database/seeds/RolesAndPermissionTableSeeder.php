<?php

use App\Permission;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RolesAndPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        foreach (Role::availableRoles() as $availableRole) {
            $role = Role::firstOrCreate(['name' => $availableRole]);
            $this->command->info('Role: ' . $role->name . ' created successfully on ' . Carbon::now()->format('F j, Y, g:i:s A'));
        }

        $permissionTemplate = ['Add', 'Edit', 'View', 'Delete', 'Draft', 'Publish'];

        foreach (Permission::availablePermissions() as $index => $permission) {
            foreach ($permissionTemplate as $item) {
                $perm = Permission::firstOrCreate(['name' => $item . ' ' . $permission]);
                $this->command->info('Permission: ' . $perm->name . ' created successfully on ' . Carbon::now()->format('F j, Y, g:i:s A'));
                $perm->assignRole('super_administrator');
            }
        }

        $additionalPermissions = ['Access Admin Panel', 'Access File Manger', 'Access Statistics', 'Export Statistics'];

        foreach ($additionalPermissions as $additionalPermission) {
            $perms = Permission::firstOrCreate(['name' => $additionalPermission]);
            $this->command->info('Additional Permission: ' . $perms->name . ' created successfully on ' . Carbon::now()->format('F j, Y, g:i:s A'));
            $perms->assignRole('super_administrator');
        }

        /*$addUser1 = User::firstOrCreate([
            'is_active' => true, 'staff_id' => 'NVS-4949', 'first_name' => 'Md. Sazzad Hossain', 'last_name' => 'Sharkar', 'email' => 'nirjhor@nvisio.net',
            'cell_number' => '+8801777884949', 'designation' => 'Software Engineer', 'team' => 'Dhaka Region', 'password' => 'we@nvisio',
        ]);

        $this->command->info('New user: ' . $addUser1->first_name . ' with unique ID #' . $addUser1->uuid . ' was created successfully.');

        $addUser1->assignRole('super_administrator');
        $this->command->info($addUser1->first_name . ' has assigned role: ' . $addUser1->getRoleNames());
*/

$addUser1 = User::firstOrCreate([
    'is_active' => true, 'staff_id' => 'NVS-4949', 'first_name' => 'Md. Sazzad Hossain', 'last_name' => 'Sharkar', 'email' => 'sh@sharkar.net',
    'cell_number' => '+8801777884949', 'designation' => 'Software Engineer', 'team' => 'Dhaka Region', 'password' => '92T6!c6x',
]);

$this->command->info('New user: '.$addUser1->first_name.' with unique ID #'.$addUser1->uuid.' was created successfully.');

$addUser1->assignRole('super_administrator');
$this->command->info($addUser1->first_name.' has assigned role: '.$addUser1->getRoleNames());


        $addUser10 = User::firstOrCreate([
            'is_active' => true, 'staff_id' => 'NVS-002', 'first_name' => 'Md. Sharif', 'last_name' => 'Mohiuddin', 'email' => 'sharif@nvisio.net',
            'cell_number' => '+8801737884949', 'designation' => 'Software Engineer', 'team' => 'Dhaka Region', 'password' => 'we@nvisio',
        ]);

        $this->command->info('New user: ' . $addUser10->first_name . ' with unique ID #' . $addUser10->uuid . ' was created successfully.');

        $addUser10->assignRole('super_administrator');
        $this->command->info($addUser10->first_name . ' has assigned role: ' . $addUser10->getRoleNames());




        $addUser2 = User::firstOrCreate([
            'is_active' => true, 'staff_id' => 'NVS-0001', 'first_name' => 'Md. Riaz Hossain', 'last_name' => 'Fahad', 'email' => 'fahad@nvisio.net',
            'cell_number' => '+8801521448961', 'designation' => 'Software Developer', 'team' => 'Dhaka Region', 'password' => 'password', 'two_factor_auth_token' => '123456', 'two_factor_auth_expiry' => Carbon::now()->addDay(),

        ]);

        $this->command->info('New user: ' . $addUser2->first_name . ' with unique ID #' . $addUser2->uuid . ' was created successfully.');

        $addUser2->assignRole('super_administrator');
        $this->command->info($addUser2->first_name . ' has assigned role: ' . $addUser2->getRoleNames());




        $addUser3 = User::firstOrCreate([
            'is_active' => true, 'staff_id' => 'NVS-0007', 'first_name' => 'Md. Sazzad Hossain', 'last_name' => 'Nirjhor', 'email' => 'nirjhor@nvisio.net',
            'cell_number' => '+8801685262326', 'designation' => 'Programmer', 'team' => 'Dhaka Region', 'password' => 'we@nvisio', 'two_factor_auth_token' => '123456', 'two_factor_auth_expiry' => Carbon::now()->addDay(),

        ]);
        $this->command->info('New user: ' . $addUser3->first_name . ' with unique ID #' . $addUser3->uuid . ' was created successfully.');
        $addUser3->assignRole('super_administrator');
		$this->command->info($addUser3->first_name . ' has assigned role: ' . $addUser3->getRoleNames());




		// BAT User
		$addUser4 = User::firstOrCreate([
            'is_active' => true, 'staff_id' => 'NVS-0008', 'first_name' => 'Tasnima haque', 'last_name' => 'Orin', 'email' => 'tasnima_haque_orin@bat.com',
            'cell_number' => '+8801777777777', 'designation' => 'Change Here', 'team' => 'Dhaka Region', 'password' => 'we@bat', 'two_factor_auth_token' => '123456', 'two_factor_auth_expiry' => Carbon::now()->addDay(),

        ]);
        $this->command->info('New user: ' . $addUser4->first_name . ' with unique ID #' . $addUser4->uuid . ' was created successfully.');
        $addUser4->assignRole('super_administrator');
		$this->command->info($addUser4->first_name . ' has assigned role: ' . $addUser4->getRoleNames());

		$addUser5 = User::firstOrCreate([
            'is_active' => true, 'staff_id' => 'NVS-0009', 'first_name' => 'Mahamuda', 'last_name' => 'Sultana', 'email' => 'mahamuda_sultana@bat.com',
            'cell_number' => '+8801777777777', 'designation' => 'Change Here', 'team' => 'Dhaka Region', 'password' => 'we@bat', 'two_factor_auth_token' => '123456', 'two_factor_auth_expiry' => Carbon::now()->addDay(),

        ]);
        $this->command->info('New user: ' . $addUser5->first_name . ' with unique ID #' . $addUser5->uuid . ' was created successfully.');
        $addUser5->assignRole('super_administrator');
		$this->command->info($addUser5->first_name . ' has assigned role: ' . $addUser5->getRoleNames());

		$addUser6 = User::firstOrCreate([
            'is_active' => true, 'staff_id' => 'NVS-0010', 'first_name' => 'Abhishek', 'last_name' => 'Paul', 'email' => 'Abhishek_Paul@bat.com',
            'cell_number' => '+8801777777777', 'designation' => 'Change Here', 'team' => 'Dhaka Region', 'password' => 'we@bat', 'two_factor_auth_token' => '123456', 'two_factor_auth_expiry' => Carbon::now()->addDay(),

        ]);
        $this->command->info('New user: ' . $addUser6->first_name . ' with unique ID #' . $addUser6->uuid . ' was created successfully.');
        $addUser6->assignRole('super_administrator');
        $this->command->info($addUser6->first_name . ' has assigned role: ' . $addUser6->getRoleNames());


    }
}
