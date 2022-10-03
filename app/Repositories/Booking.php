<?php

namespace App\Repositories;
use Illuminate\Http\Request;

use Arr;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Dish;
use App\Models\Booking as BookingModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Booking extends BaseRepository
{
    /**
     * Constructor 
     * 
     * @param Model $model
     */
    public function __construct(BookingModel $model)
    {
        $this->model = $model;
    }

    /**
     * Find client bookings 
     * 
     * @param int $clientId
     * @param Request $request 
     * @return Collection 
     */
    public function getUserBookings (Request $request, int $userId)
    {
        $field = $request->usertype === 'chef' ? 'chef_id' : 'client_id';

        return BookingModel::with('client', 'chef', 'dishes', 'comments')
            ->where($field, $userId)
            ->when($request->has('start_date'), function ($q) use ($request) {
                return $q->where('bookings.start_time', '>=', Carbon::parse($request->start_date));
            })
            ->when($request->has('end_date'), function ($q) use ($request) {
                return $q->where('bookings.start_time', '<', Carbon::parse($request->end_date));
            })
            ->orderBy('start_time', 'asc')
            ->paginate(50);
    }

    /**
     * Chef is the chef is available for a specific time 
     * 
     * @return boolean 
     */
    public function isChefAvailable (User $user, string $datetime, int $duration) : bool
    {
        $start = Carbon::parse($datetime)->subMinutes(30)->format('Y-m-d H:i');
        $end = Carbon::parse($datetime)->addMinutes($duration + 30)->format('Y-m-d H:i');

        $bookings = BookingModel::where('chef_id', $user->id)
            ->whereDate('end_time', '>=', $start)
            ->whereDate('start_time', '<', $end)
            ->get();

        return sizeof($bookings) === 0;
    }


    /**
     * Create a new user
     *
     * @param  Request $request [description]
     * @return User
     */
    public function store (Request $request, int $userId) : BookingModel
    {
        $endTime = Carbon::parse($request->datetime)->addMinutes($request->duration);
        $number = $this->makeBookingNumber();

        return BookingModel::create([
            'start_time'    => $request->datetime,
            'client_id'     => $userId,
            'end_time'      => $endTime->format('Y-m-d H:i'),
            'chef_id'       => $request->chef_id,
            'number'        => $number,
            'amount'        => (float) $request->price,
            'status'        => 'pending',
            'notes'         => $request->notes,
        ]);
    }


    /**
     * Attach dish 
     * 
     * @return BookingModel 
     */
    public function attachDishes (BookingModel $booking, Request $request) : BookingModel
    {
        foreach ($request->dishes as $dish) {
            $original = Dish::where('code', $dish['code'])->first();

            $booking->dishes()->attach($original->id, [
                'price' => $dish['price'],
                'serves' => $dish['serves'],
                'duration' => $dish['duration']
            ]);
        }

        return $booking;
    }


    /**
     * Update a user 
     * 
     * @param User $user 
     * @param Request $request
     * @return User
     */
    public function update (BookingModel $booking, Request $request) : BookingModel
    { 
        $endTime = Carbon::parse($request->datetime)->addMinutes($request->duration);

        $booking->status        = $request->status;
        $booking->start_time    = $request->start_time;
        $booking->end_time      = $endTime;

        $booking->save();
        return $booking;
    }

    /**
     * Get single booking 
     * 
     * @param uuid $code 
     * @return BookingModel $booking
     */
    public function findBookingByCode ($code)
    {
        return BookingModel::whereCode($code)->first();
    }


    public function countPendingBookings () 
    {
        $today = Carbon::today()->format('Y-m-d H:i');
        return BookingModel::whereIn('status', ['pending', 'approved'])
            ->whereDate('end_time', '>=', $today)
            ->count();
    }


    /**
     * Filter users 
     * 
     * @return Collection 
     */
    public function filter (array $params) 
    {
        $paginate = Arr::get($params, 'paginate', 10);

        return BookingModel::with('client', 'chef', 'dish')
            ->when(isset($params['status']), function ($q) use ($params) {
                return $q->where('status', '=', $params['status']);
            })
            ->when(isset($params['keywords']), function ($q) use ($params) {
                return $q->where( function ($query) use ($params) {
                    return $query->where('number', 'like', '%' . $params['keywords'] . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($paginate);
    }


    /**
     * Make booking number 
     */
    private function makeBookingNumber () 
    {
        $number = 1000101;
        $latest = BookingModel::orderBy('id', 'desc')
            ->first();

        if ($latest)
            return $latest->number += rand(1, 9);
        return $number;
    }
}
