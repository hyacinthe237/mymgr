<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::whereName('customer')->first();
        $chefRole = Role::whereName('chef')->first();

        $userRole->documents()->saveMany([
            new Document(['name' => 'Driver Licence']),
            new Document(['name' => 'Police Check']),
        ]);

        $chefRole->documents()->saveMany([
            new Document(['name' => 'Driver Licence']),
            new Document(['name' => 'Police Check']),
            new Document(['name' => 'Cookery Certficate']),
        ]);


        $john = User::find(2);
        $john->documents()->attach(1, ['status' => 'pending', 'link' => 'https://www.google.com.au' ]);
        $john->documents()->attach(2, ['status' => 'pending', 'link' => 'https://www.google.com.au' ]);

        $jane = User::find(3);
        $jane->documents()->attach(3, ['status' => 'pending', 'link' => 'https://www.google.com.au' ]);
        $jane->documents()->attach(4, ['status' => 'pending', 'link' => 'https://www.google.com.au' ]);
        $jane->documents()->attach(5, ['status' => 'pending', 'link' => 'https://www.google.com.au' ]);
    }
}
