<?php

namespace Modules\Areas\Entities;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Area
 * @property int $id
 * @property string $name
 * @property string $code
 * @package Modules\Areas\Entities
 */
class Area extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'code'];
}
