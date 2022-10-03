<?php 

namespace App\Repositories;

use App\Models\User;
use App\Models\Rating;

class RatingRepository extends BaseRepository
{
    /**
     * Constructor 
     * 
     * @param Model $model
     */
    public function __construct(Rating $model)
    {
        $this->model = $model;
    }


    public function findExisting ($rater, $booking)
    {
        return Rating::where('rater_id', $rater->id)
            ->where('booking_id', $booking->id)
            ->first();
    }


    public function rateUser ($rater, $ratee, $booking, $stars)
    {
        return Rating::create([
            'booking_id' => $booking->id,
            'rater_id'   => $rater->id,
            'ratee_id'   => $ratee->id,
            'stars'      => $stars
        ]);
    }


    public function addUpRating ($ratee, $stars)
    {
        $ratee->ratings = $ratee->ratings + $stars;
        $ratee->ratings_count = $ratee->ratings_count + 1;
        $ratee->save();

        return $ratee;
    }
}