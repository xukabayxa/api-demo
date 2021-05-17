<?php

namespace Modules\Friends\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Friends
 * @property int $id
 * @package Modules\Friends\Entities
 */
class Friends extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'friendable_type', 'friendable_id', 'userable_id', 'userable', 'status_id'];

    protected $table = ['created_at', 'updated_at'];
}
