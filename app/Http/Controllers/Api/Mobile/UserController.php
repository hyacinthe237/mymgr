<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Repositories\Booking as BookingRepo;
use Illuminate\Support\Facades\Validator;
use App\Repositories\User as UserRepo;
use App\Repositories\RatingRepository;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChefResource;
use App\Utilities\StripeService;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Verify user pin 
     * 
     * @param Requet 
     * @param String $pin
     * @return Json
     */
    public function verifyPin (Request $request, $pin)
    {
        try 
        {
            $user = $request->user();
            $user = User::find($user->id);

            if ($pin != $user->pin) {
                return response()->json('Code did not match', self::HTTP_BADREQUEST);
            }

            // $user->email_verified_at = Carbon::today();
            $user->pin = '';
            $user->save();

            return response()->json($user);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Update a user 
     */
    public function updateMe (Request $request, UserRepo $userRepo)
    {
        try 
        {
            $user = $request->user();

            $rules = [
                'date_of_birth'     => 'required',
                'username'          => 'required',
                'firstname'         => 'required',
                'lastname'          => 'required',
                'mobile'            => 'required',
                'email'             => 'required|email|unique:users,email,' . $user->id,
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails())
                return response()->json($validator->errors(), self::HTTP_BADREQUEST);
            
            $user = $userRepo->update($user, $request);

            return response()->json($user);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Upload profile picture to user profile 
     * 
     * @return Json 
     */
    public function updateProfile (Request $request, UserRepo $userRepo)
    {
        try 
        {
            $user = $request->user();
            $user = $userRepo->uploadProfilePicture($user, $request->image);
            return response()->json($user);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Get users of type chefs
     * 
     * @return Json 
     */
    public function getChefs (Request $request, UserRepo $userRepo)
    {
        try 
        {
            $chefs = $userRepo->filterChefs($request);
            return response()->json($chefs);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Get a chef user 
     * 
     * @return Collection App\Models\Dish
     */
    public function getChef ($code)
    {
        try 
        {
            $user = User::whereCode($code)->firstOrFail();  
            return response()->json(new ChefResource($user));
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Get a chef dishes  
     * 
     * @return Collection App\Models\Dish
     */
    public function getChefDishes ($code)
    {
        try 
        {
            $user = User::whereCode($code)->firstOrFail();       
            return response()->json($user->dishes);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }


    /**
     * Update user card 
     * 
     * @return Json 
     */
    public function updateCard (Request $request, StripeService $stripe)
    {
        try 
        {
            $user = $request->user();
            
            $expiry = explode('/', $request->expiry);
            $cardParams = $request->only(['card_number', 'card_cvc']);
            $cardParams['stripeCustomerToken'] = $user->stripe_customer_token;
            $cardParams['card_exp_month'] = $expiry[0];
            $cardParams['card_exp_year']  = $expiry[1];

            $card = $stripe->createCard($user, $cardParams);
            return response()->json($card);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }

    /**
     * Rate users base on booking
     */
    public function rate (
        Request $request, UserRepo $userRepo, 
        RatingRepository $ratingRepo,
        BookingRepo $bookingRepo
    )
    {
        try 
        {
            $user  = $request->user();
            $rater = $userRepo->findByCode($request->rater);       
            
            if ($user->code !== $rater->code) 
                return response()->json('You are not allowed to rate this user', self::HTTP_FORBIDDEN);

            $booking  = $bookingRepo->findBookingByCode($request->booking);
            $existing = $ratingRepo->findExisting($rater, $booking);

            if ($existing)
                return response()->json('You have already rated this booking', self::HTTP_FORBIDDEN);
            
            $stars  = $request->stars;
            $ratee  = $userRepo->findByCode($request->ratee); 
            $rating = $ratingRepo->rateUser($rater, $ratee, $booking, $stars);
            $ratingRepo->addUpRating($ratee, $stars);

            return response()->json($rating);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage(), self::HTTP_ERROR);
        }
    }
}
