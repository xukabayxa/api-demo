<?php

namespace Modules\Advertisings\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdvertisingSchool
 * @property int $id
 * @package Modules\Advertisings\Entities
 *
 * @property int $advertising_id
 * @property int $school_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AdvertisingSchool extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'advertising_id', 'school_id'];

    protected $dates = ['created_at', 'updated_at'];
}
