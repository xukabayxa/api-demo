<?php

namespace Modules\Schools\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class School
 * @property int $id
 * @package Modules\Schools\Entities
 *
 * @property string $name
 */
class SchoolType extends Model
{
    const HIGH_SCHOOL = 1;
    const UNIVERSITY = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];
}
