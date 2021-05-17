<?php

namespace Modules\Customers\Entities;

use App\Helpers\RandomStringHelper;
use Carbon\Carbon;
use Facade\FlareClient\Stacktrace\Stacktrace;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentActivation
 * @property int $id
 * @property int $student_id
 * @property string $activation_code
 * @package Modules\Customers\Entities
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class StudentActivation extends Model
{
    protected $fillable = ['student_id', 'activation_code'];

    protected $dates = ['created_at', 'updated_at'];

    protected function getToken()
    {
        return hash_hmac('sha256', RandomStringHelper::generateRandomString(), config('app.key'));
    }

    public function createActivation($student)
    {
        $activation = $this->getActivation($student);

        if (!$activation) {
            return $this->createToken($student);
        }

        return $this->regenerateToken($student);
    }

    /**
     * @param Student $student
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public function getActivation($student)
    {
        return self::query()->where('student_id', $student->id)->first();
    }

    /**
     * @param Student $student
     * @return string
     */
    private function createToken($student)
    {
        $token = $this->getToken();
        self::query()->create([
            'student_id' => $student->id,
            'activation_code' => $token,
        ]);
        return $token;
    }

    /**
     * @param Student $student
     * @return string
     */
    private function regenerateToken($student)
    {
        $token = $this->getToken();
        self::query()->where('student_id', $student->id)->update([
            'activation_code' => $token
        ]);
        return $token;
    }

    /**
     * @param $token
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public function getActivationByToken($token)
    {
        return self::query()->where('activation_code', $token)->first();
    }

    /**
     * @param $token
     */
    public function deleteActivation($token)
    {
        self::query()->where('activation_code', $token)->delete();
    }
}
