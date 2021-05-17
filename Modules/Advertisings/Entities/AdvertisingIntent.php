<?php

namespace Modules\Advertisings\Entities;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdvertisingIntent
 * @property int $id
 * @package Modules\Advertisings\Entities
 */
class AdvertisingIntent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','name'];
}
