<?php

namespace Modules\Jobs\Entities;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobIntent
 * @property int $id
 * @package Modules\Jobs\Entities
 */
class JobIntent extends Model
{
    const SEARCH = 1;
    const RECRUITMENT = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','name'];
}
