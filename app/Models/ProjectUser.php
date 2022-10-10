<?php

namespace App\Models;

use App\Utilities\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectUser extends Model
{
    use SoftDeletes, Uuids;

    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'project_users';

   /**
   * primary key
   */
   protected $primaryKey = "id";

   /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
   protected $dates = ['deleted_at'];

   /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = ['id'];
}
