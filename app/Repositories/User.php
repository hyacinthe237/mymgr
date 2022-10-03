<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\User as UserModel;
use App\Models\Role as RoleModel;
use App\Models\Newsletter;
use Illuminate\Support\Arr;

class User
{
    const ROLE_ADMIN  = 1;
    const ROLE_CHEF   = 2;
    const ROLE_CLIENT = 3;

    /**
     * Create a new user
     *
     * @param  Request $request [description]
     * @return User
     */
    public function store ($request)
    {
        $cardDigists = strlen($request->card_number) > 4 
            ? substr($request->card_number, -4) : '';

        return UserModel::create([
            'username'         => $request->username,
            'firstname'        => $request->firstname,
            'lastname'         => $request->lastname,
            'mobile'           => $request->mobile,
            'email'            => $request->email,
            'country_id'       => $request->country_id,
            'role_id'          => $request->role_id,
            'middle_name'      => $request->middle_name,
            'address'          => $request->address,
            'suburb'           => $request->suburb,
            'state'            => $request->state,
            'sex'              => $request->sex,
            'postcode'         => $request->postcode,
            'card_last_digits' => $cardDigists,
            'card_expiry'      => $request->card_expiry,
            'date_of_birth'    => $request->date_of_birth,
            'chef_type'        => $request->chef_type,
            'bank_bsb'         => $request->bank_bsb,
            'bank_name'        => $request->bank_name,
            'bank_account_holder' => $request->bank_account_holder,
            'bank_account_number' => $request->bank_account_number,
            'vaccination_status' => $request->vaccination_status,
            'status'           => 'pending',
            'password'         => bcrypt($request->password),
            'api_token'        => $this->makeApiToken(),
            'pin'              => rand(111111, 999999)
        ]);
    }


    /**
     * Update a user 
     * 
     * @param User $user 
     * @param Request $request
     * @return User
     */
    public function update (UserModel $user, $request)
    { 
        $user->vaccination_status = $request->vaccination_status;
        $user->date_of_birth = $request->date_of_birth;
        $user->middle_name   = $request->middle_name;
        $user->country_id    = $request->country_id;
        $user->firstname     = $request->firstname;
        $user->chef_type     = $request->chef_type;
        $user->username      = $request->username;
        $user->lastname      = $request->lastname;
        $user->postcode      = $request->postcode;
        $user->address       = $request->address;
        $user->role_id       = $request->role_id;
        $user->mobile        = $request->mobile;
        $user->suburb        = $request->suburb;
        $user->status        = $request->status;
        $user->email         = $request->email;
        $user->state         = $request->state;
        $user->json          = $request->json;
        $user->sex           = $request->sex;
        $user->pin           = $request->pin;

        $user->bank_bsb            = $request->bank_bsb;
        $user->bank_name           = $request->bank_name;
        $user->bank_account_holder = $request->bank_account_holder;
        $user->bank_account_number = $request->bank_account_number;

        $user->save();

        return $user;
    }


    /**
     * [makeApiToken description]
     * @return [type] [description]
     */
    private function makeApiToken()
    {
        $token = \Str::random(128);

        if (UserModel::where('api_token', $token)->first()) {
            $this->makeApiToken();
        }
        
        return $token;
    }
   

    /**
     * Upload base64 Image to user profile
     *
     * @param  UserModel $user
     * @param  String    $base64String
     * @return
     */
    public function uploadProfilePicture (UserModel $user, $base64String)
    {
        if ($base64String) {
            $image_parts = explode(";base64,", $base64String);
            $decoded = base64_decode($image_parts[1]);

            $time = time();
            $fileName  = $user->username . '_' . $time . '.jpg';
            $thumbName = $user->username . '_' . $time . '_thumbnail' . '.jpg';

            $img = Image::make($decoded);

            // Max file width 500px
            $data = (string) $img->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 90);

            \Storage::put('yummooh/' . $fileName, $data, 'public');

            // Thumbnail max with 150px
            $data = (string) $img->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->crop(150, 150)
            ->encode('jpg', 90);

            \Storage::put('yummooh/' . $thumbName, $data, 'public');


            $user->profile = 'yummooh/' . $fileName;
            $user->thumbnail = 'yummooh/' . $thumbName;
            $user->save();
        }

        return $user;
    }


    /**
     * Filter chefs form search 
     * 
     * @return Collection 
     */
    public function filterChefs (Request $request)
    {
        $paginate = 10;

        return UserModel::isActive()->isChef()
            ->when($request->sex, function ($q) use ($request) {
                return $q->where('sex', '=', $request->sex);
            })
            ->when($request->state, function ($q) use ($request) {
                return $q->where('state', '=', $request->state);
            })
            ->orderBy('ratings', 'desc')
            ->paginate($paginate);
    }


    public function findByCode ($code)
    {
        return UserModel::whereCode($code)->first();
    }

    /**
     * Filter users 
     * 
     * @return Collection 
     */
    public function filterUsers (array $params) 
    {
        $paginate = Arr::get($params, 'paginate', 10);

        return UserModel::when(isset($params['status']), function ($q) use ($params) {
                return $q->where('status', '=', $params['status']);
            })
            ->when(isset($params['keywords']), function ($q) use ($params) {
                return $q->where( function ($query) use ($params) {
                    return $query->where('username', 'like', '%' . $params['keywords'] . '%')
                        ->orWhere('email', 'like', '%' . $params['keywords'] . '%')
                        ->orWhere('lastname', 'like', '%' . $params['keywords'] . '%')
                        ->orWhere('firstname', 'like', '%' . $params['keywords'] . '%');
                });
            })
            ->when(isset($params['role']), function ($q) use ($params) {
                return $q->where('role_id', '=', $params['role']);
            })
            ->when(isset($params['sex']), function ($q) use ($params) {
                return $q->where('sex', '=', $params['sex']);
            })
            ->when(isset($params['state']), function ($q) use ($params) {
                return $q->where('state', '=', $params['state']);
            })
            ->orderBy('firstname')
            ->paginate($paginate);
    }



    public function getAdmins ()
    {
        return UserModel::where('role_id', self::ROLE_ADMIN)
            ->orderBy('firstname')
            ->get();
    }



    /**
     * Get newsletter list 
     * 
     * @return Collection 
     */
    public function getNewsletter (array $params)
    {
        $paginate = Arr::get($params, 'paginate', 10);

        return Newsletter::when(isset($params['keywords']), function ($q) use ($params) {
            return $q->where( function ($query) use ($params) {
                return $query->where('name', 'like', '%' . $params['keywords'] . '%')
                    ->orWhere('email', 'like', '%' . $params['keywords'] . '%');
            });
        })->paginate($paginate);
    }



    public function countPendingUsers () 
    {
        return UserModel::where('status', 'pending')->count();
    }
}
