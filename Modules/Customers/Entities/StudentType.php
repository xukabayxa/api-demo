<?php

namespace Modules\Customers\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentType
 * @property int $id
 * @property string $name
 * @package Modules\Customers\Entities
 */
class StudentType extends Model
{
    const STUDENT_HIGHSCHOOL = 1;
    const STUDENT_UNI = 1;

    protected $fillable = ['id', 'name'];

    protected $dates = ['created_at', 'updated_at'];
}
