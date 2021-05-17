<?php

namespace Modules\Motels\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MotelSchool
 * @property int $id
 * @property int $motel_id
 * @property int $school_id
 * @package Modules\Motels\Entities
 *
 */
class MotelSchool extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'motel_id', 'school_id'];

    protected $dates = ['created_at', 'updated_at'];
}
