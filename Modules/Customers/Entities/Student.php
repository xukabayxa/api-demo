<?php

namespace Modules\Customers\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Modules\Advertisings\Entities\Traits\HasAdvertisingTrait;
use Modules\Areas\Entities\Traits\HasAreaTrait;
use Modules\Files\Entities\Traits\HasFileTrait;
use Modules\Motels\Entities\Traits\HasMotelTrait;
use Modules\Schools\Entities\Traits\HasSchoolTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Student
 * @package Modules\Customers\Entities
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $address
 * @property int $student_type_id
 * @property int $active
 * @property string $activation_link
 * @property int $area_id
 * @property int $school_id
 * @property string $school_other_name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * Relations
 * @property-read StudentType $studentType
 */
class Student extends Authenticatable implements JWTSubject
{
    use  Notifiable, HasAreaTrait, HasSchoolTrait, HasFileTrait, HasMotelTrait, HasAdvertisingTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'phone', 'address', 'student_type_id', 'area_id', 'school_id', 'school_other_name', 'active', 'activation_link'];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|StudentType
     */
    public function studentType()
    {
        return $this->belongsTo(StudentType::class, 'student_type_id');
    }

    /**
     * @param $email
     * @return bool
     */
    public static function isActive($email)
    {
        $studentActive = self::query()->where('email', $email)->value('active');

        if ($studentActive == 1) {
            return true;
        }

        return false;
    }
}
