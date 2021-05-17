<?php

namespace Modules\Motels\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MotelStatus
 * @property int $id
 * @package Modules\Motels\Entities
 *
 * @property string $name
 */
class MotelStatus extends Model
{
    const OPEN = 1;
    const CLOSE = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];

    protected $dates = ['created_at', 'updated_at'];
}
