<?php

namespace Modules\Customers\Service;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Customers\Entities\Student;
use Modules\Customers\Helpers\CustomerHelper;
use Modules\Customers\Repositories\CustomerRepository;
use Modules\Customers\Repositories\StudentRepository;
use Modules\Users\Entities\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class CustomerService
 * @package Modules\Customers\Service
 */
class StudentService
{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * @param $data
     * @param null $file
     * @return Student
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createStudent($data, $file = null)
    {
        /** @var Student $student */
        $student = $this->studentRepository->create($data);

        if (!empty($file)) {
            CustomerHelper::uploadAvatar($file, $student, 'customers');
        }

        return $student;
    }

    /**
     * @param $data
     * @param $student
     * @param null $file_ids
     * @param null $file
     * @return Student
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateStudent($data, $student, $file_ids = null, $file = null)
    {
        $student = $this->studentRepository->update($data, $student->id);

        if (!empty($file_ids)) {
            CustomerHelper::updateAvatar($student, $file_ids);
        }

        if (!empty($file)) {
            CustomerHelper::uploadAvatar($file, $student, 'customers');
        }

        return $student;
    }


}
