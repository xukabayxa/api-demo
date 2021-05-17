<?php

namespace Modules\Motels\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MotelIntent
 * @property int $id
 * @package Modules\Motels\Entities
 *
 * @property string $name
 */
class MotelIntent extends Model
{
    const SEARCH = 1;
    const TRANSFER = 2;
    const PAIRING = 3;
    const SALE = 4;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];

    protected $dates = ['created_at', 'updated_at'];
}
