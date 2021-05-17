<?php

namespace Modules\Jobs\Entities;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JobStatus
 * @property int $id
 * @package Modules\Jobs\Entities
 */
class JobStatus extends Model
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
