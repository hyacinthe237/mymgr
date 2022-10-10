<?php
namespace App\Repositories\Contracts;

/**
 * Interface CriteriaInterface
 * @author Ulrich Ntella <ulrichsoft2002@gmail.com>
 */
interface CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param  Model $model
     * @param Array $fieldsSearchable
     *
     * @return mixed
     */
    public function apply($model,  $fieldsSearchable);
}
