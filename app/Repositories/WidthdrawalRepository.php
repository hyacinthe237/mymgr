<?php 

namespace App\Repositories;

use App\Models\Withdrawal;


class WidthdrawalRepository extends BaseRepository
{
    
    /**
     * Constructor 
     * 
     * @param Model $model
     */
    public function __construct(Withdrawal $model)
    {
        $this->model = $model;
    }


    public function getUserWithdrawals ($userId)
    {
        return Withdrawal::where('user_id', $userId)
            ->orderBy('id', 'desc')
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

        return Withdrawal::with('user', 'clearedBy')
            ->when(isset($params['keywords']), function ($q) use ($params) {
                return $q->whereHas('user', function ($query) use ($params) {
                    return $query->where('firstname', 'like', '%' . $params['keywords'] . '%')
                        ->orWhere('lastname', 'like', '%' . $params['keywords'] . '%');
                });
            })
            ->when(isset($params['status']), function ($q) use ($params) {
                return $q->where('status', '=', $params['status']);
            })
            ->orderBy('id', 'desc')
            ->paginate($paginate);
    }


    /**
     * Create withdrawal entry
     * 
     * @param int $userId
     * @param double $amount 
     * 
     * @return Withdrawal
     */
    public function createWithdrawal ($userId, $amount)
    {
        return Withdrawal::create([
            'user_id' => $userId,
            'amount' => $amount,
            'status' => 'pending'
        ]);
    }


    /**
     * Get model 
     * 
     * @param string $code 
     * 
     * @return Withdrawal
     */
    public function getModel (string $code)
    {
        return Withdrawal::with('user', 'clearedBy')
            ->where('code', $code)
            ->first();
    }


    /**
     * Update withdrawal 
     * 
     * @param Withdrawal $model
     * @param string $status 
     * 
     * @return Withdrawal
     */
    public function updateWithdrawal (Withdrawal $model, string $status)
    {
        $model->status = $status;
        $model->save();

        return $model;
    }


    public function countPendingWithdrawals () 
    {
        return Withdrawal::where('status', 'pending')->count();
    }
}