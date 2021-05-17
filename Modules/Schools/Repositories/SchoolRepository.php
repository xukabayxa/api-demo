<?php

namespace Modules\Schools\Repositories;

use Modules\Schools\Entities\School;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class SchoolRepository
 * @package Modules\Platform\User\Repositories
 */
class SchoolRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return School::class;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return School
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
     * @return School
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }
}