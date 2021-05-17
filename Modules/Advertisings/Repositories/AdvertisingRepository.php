<?php

namespace Modules\Advertisings\Repositories;

use Modules\Advertisings\Entities\Advertising;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class AdvertisingRepository
 * @package Modules\Platform\User\Repositories
 */
class AdvertisingRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Advertising::class;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return Advertising
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
     * @return Advertising
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }
}