<?php

namespace Modules\Motels\Repositories;

use Modules\Motels\Entities\Motel;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class MotelRepository
 * @package Modules\Platform\User\Repositories
 */
class MotelRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Motel::class;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return Motel
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
     * @return Motel
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }
}