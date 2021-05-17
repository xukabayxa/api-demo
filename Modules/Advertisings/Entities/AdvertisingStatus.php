<?php

namespace Modules\Advertisings\Entities;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdvertisingStatus
 * @property int $id
 * @package Modules\Advertisings\Entities
 */
class AdvertisingStatus extends Model
{
    const OPEN = 1;
    const CLOSE = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','name'];
}
