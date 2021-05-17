<?php

namespace Modules\Customers\Service;


use Illuminate\Support\Facades\Notification;
use Modules\Customers\Entities\Student;
use Modules\Customers\Entities\StudentActivation;
use Modules\Customers\Notifications\RegisterStudentNotification;

/**
 * Class ActivationService
 * @package Modules\Customers\Service
 */
class ActivationService
{
    protected $resendAfter = 24; // Sẽ gửi lại mã xác thực sau 24h nếu thực hiện sendActivationMail()
    protected $studentActivation;

    public function __construct(StudentActivation $studentActivation)
    {
        $this->studentActivation = $studentActivation;
    }

    /**
     * @param Student $student
     */
    public function sendActivationMail($student)
    {
        if ($student->active == 1 || !$this->shouldSend($student)) return;

        $token = $this->studentActivation->createActivation($student);

        $student->activation_link = route('student.activate', $token);

        $student->save();

        Notification::send($student, new RegisterStudentNotification($student));
    }

    /**
     * @param $token
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function activateUser($token)
    {
        $activation = $this->studentActivation->getActivationByToken($token);

        if ($activation === null) return null;

        $user = Student::query()->find($activation->student_id);

        $user->active = 1;
        $user->save();

        $this->studentActivation->deleteActivation($token);

        return $user;
    }

    private function shouldSend($student)
    {
        /** @var StudentActivation $activation */
        $activation = $this->studentActivation->getActivation($student);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }
}
