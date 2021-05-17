<?php

namespace Modules\Customers\Repositories;

use Modules\Customers\Entities\Student;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CustomerRepository
 * @package Modules\Platform\User\Repositories
 */
class StudentRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Student::class;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return Student
     */
    public function create(array $attributes)
    {
        return parent::create($attributes);
    }

    /**
     * Update a entity in repository by id
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     * @param       $id
     *
     * @return Student
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }
}
