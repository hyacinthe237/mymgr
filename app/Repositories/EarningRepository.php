<?php 

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Earning;


class EarningRepository extends BaseRepository
{
    const COMMISSION_RATE = 0.15; //15%

    
    /**
     * Constructor 
     * 
     * @param Model $model
     */
    public function __construct(Earning $model)
    {
        $this->model = $model;
    }


    /**
     * Create new earning
     */
    public function createEarning ($booking)
    {
        $commission = $booking->amount * self::COMMISSION_RATE;
        $amount = $booking->amount - $commission;

        return Earning::create([
            'user_id' => $booking->chef->id,
            'booking_id' => $booking->id,
            'amount' => $amount,
            'status' => 'pending'
        ]);
    }


    public function getUserEarnings ($userId)
    {
        return Earning::with('booking')
            ->where('user_id', $userId)
            ->paginate(20);
    }



     /**
     * Filter 
     * 
     * @return Collection 
     */
    public function filter (array $params) 
    {
        $paginate = \Arr::get($params, 'paginate', 10);

        return Earning::with('user', 'booking', 'clearedBy')
            ->when(isset($params['keywords']), function ($q) use ($params) {
                return $q->whereHas('booking', function ($query) use ($params) {
                    return $query->where('number', 'like', '%' . $params['keywords'] . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($paginate);
    }
}