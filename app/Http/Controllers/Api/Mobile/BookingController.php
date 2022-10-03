<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Resources\BookingResourceCollection;
use App\Http\Resources\BookingResource;
use App\Http\Controllers\Controller;
use App\Events\BookingCompleted;
use App\Events\BookingCreated;
use App\Repositories\Booking;
use App\Repositories\EarningRepository;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dish;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Save a new booking 
     * 
     * @return Json 
     */
    public function store (Request $request, Booking $bookingRepo)
    {
        try 
        {
            $chef = User::where('code', $request->chef)->firstOrFail();

            $isAvailable = $bookingRepo->isChefAvailable($chef, $request->datetime, $request->duration);

            if (!$isAvailable) 
                return response()->json('Chef not available at the selected date & time', self::HTTP_FORBIDDEN);
            
            $user = $request->user();
            $request->merge(['chef_id' => $chef->id]);
            
            $booking = $bookingRepo->store($request, $user->id);
            $booking = $bookingRepo->attachDishes($booking, $request);
            event(new BookingCreated($booking));
            
            return response()->json($booking);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    public function index (Request $request, Booking $bookingRepo)
    {
        try 
        {
            $user = $request->user();
            $bookings = $bookingRepo->getUserBookings($request, $user->id);
            $collection = new BookingResourceCollection($bookings);

            return response()->json($collection);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     * Get a single booking 
     * 
     * @return Json 
     */
    public function getBooking (Booking $bookingRepo, $code) 
    {
        try 
        {
            $booking = $bookingRepo->findBookingByCode($code);
            $formatted = new BookingResource($booking);
            return response()->json($formatted);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Update a single booking 
     * 
     * @return Json 
     */
    public function updateBooking (Booking $bookingRepo, $code)
    {
        try 
        {
            $booking = $bookingRepo->findBookingByCode($code);
            $booking->status = request()->status;
            $booking->save();

            // Notify 

            $formatted = new BookingResource($booking);
            return response()->json($formatted);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    /**
     * Finish a booking 
     * @param App\Repositories\Booking $bookingRepo
     * @param string $code 
     * 
     * @return Json 
     */
    public function finishBooking (Booking $bookingRepo, EarningRepository $earningRepository, $code)
    {
        try 
        {
            $booking = $bookingRepo->findBookingByCode($code);

            $isFuture = Carbon::createFromFormat('Y-m-d H:i:s', $booking->start_time, 'Australia/Sydney')
                ->isFuture();

            if ($isFuture) {
                return response()->json(
                    'You cannot finish a booking before the starting time',
                    self::HTTP_FORBIDDEN
                );
            }

            if ($booking->status !== 'approved') {
                return response()->json(
                    'This booking has not been previously approved',
                    self::HTTP_FORBIDDEN
                );
            }

            $booking->status = 'completed';
            $booking->save();

            $earningRepository->createEarning($booking);
            event(new BookingCompleted($booking));
            
            $formatted = new BookingResource($booking);
            return response()->json($formatted);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }



    public function getChefBookings (Booking $bookingRepo, Request $request, string $code)
    {
        try 
        {
            $chef = User::where('code', $code)->firstOrFail();
            $request->merge(['usertype' => 'chef']);

            $bookings = $bookingRepo->getUserBookings($request, $chef->id);
            $collection = new BookingResourceCollection($bookings);

            return response()->json($collection);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
