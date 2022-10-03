<?php

use Carbon\Carbon;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class CuisineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $items = [
            [
                'name'  => 'Australian Cuisine',
                'created_at'    => $now,
                'updated_at'    => $now,
                'code'  => 'e74e6b8b-7bb7-4ed8-9834-e7c92a57e3b8',
                'cover' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/Fish_and_chips_blackpool.jpg/1200px-Fish_and_chips_blackpool.jpg'
            ],
            [
                'name'  => 'Cameroonian Cuisine',
                'created_at'    => $now,
                'updated_at'    => $now,
                'code'  => '06474c1f-edc8-4661-ba03-2fbf8585c046',
                'cover' => 'https://www.africanbites.com/wp-content/uploads/2012/11/IMG_5428.jpg'
            ],
            [
                'name'  => 'Chinese Cuisine',
                'created_at'    => $now,
                'updated_at'    => $now,
                'code'  => 'c956f7ec-0597-4187-83c3-66324dd96e10',
                'cover' => 'https://images.immediate.co.uk/production/volatile/sites/30/2020/08/singapore-noodles_with_prawns-f8f4113.jpg'
            ],
            [
                'name'  => 'Indian Cuisine',
                'created_at'    => $now,
                'updated_at'    => $now,
                'code'  => '72460f87-1f44-4349-8b07-b256b65f3187',
                'cover' => 'https://media3.s-nbcnews.com/i/newscms/2019_39/3027176/190926-chicken-tikka-masala-se-405p_663a402a82bc1464dfc1838472644431.jpg'
            ],
            [
                'name'  => 'Italian Cuisine',
                'created_at'    => $now,
                'updated_at'    => $now,
                'code'  => '2fde2b87-2c07-46d2-927d-0f6c23aa12fc',
                'cover' => 'http://i1.wp.com/www.eatthis.com/wp-content/uploads/2019/09/spaghetti-meatballs.jpg'
            ]
        ];

        DB::table('cuisines')->insert($items);

        $chefs = User::where('role_id', 2)->get();
        $arr = [[1,2,3], [1,3], [2], [1], [1,2], [4,3], [4,1], [4,2], [2,3], [2,3,4], [5,4], [5,1,3], [5,2]];

        foreach ($chefs as $item) {
            $index = array_rand($arr);
            $item->cuisines()->sync($arr[$index]);
        }


        DB::table('dishes')->insert(
            [
                [
                    'serves' => 6,
                    'user_id' => 2,
                    'duration' => 60,
                    'price' => 150.00,
                    'cuisine_id' => 2,
                    'name'  => 'Ndolè',
                    'created_at' => $now,
                    'updated_at' => $now,
                    'ingredients' => 'oil,salt,pepper,Sugar',
                    'code' => '29d44f90-9172-11eb-b2ca-0ff9b7556834'
                ],

                [
                    'serves' => 4,
                    'user_id' => 2,
                    'price' => 80.00,
                    'duration' => 130,
                    'cuisine_id' => 2,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'name'  => 'Kouakoukou',
                    'ingredients' => 'macabo,oil,pepper,salt,dry fish,maggi cube',
                    'code' => '9734da10-94a7-11eb-89c0-6724ad2835e3'
                ]
            ]
        );
    }
}
