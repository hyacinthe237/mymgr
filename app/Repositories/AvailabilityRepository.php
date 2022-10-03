<?php 

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Availability;

class AvailabilityRepository extends BaseRepository
{
    /**
     * Constructor 
     * 
     * @param Model $model
     */
    public function __construct(Availability $model)
    {
        $this->model = $model;
    }

    public function updateAvailabilities ($user, $dates) 
    {
        $user->availabilities()->delete();
        if (sizeof($dates) === 0) return false;

        $availabilities = [];

        foreach ($dates as $date) {
            $availabilities[] = ['user_id' => $user->id, 'date' => $date];
        }

        $user->availabilities()->createMany($availabilities);
        return $user->load('availabilities');
    }



    public function getUserAvailabilities ($code)
    {
        $user = User::whereCode($code)->firstOrFail();
        return Availability::where('user_id', $user->id)->get();
    }
}