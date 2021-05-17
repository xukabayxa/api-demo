<?php

namespace Modules\Friends\Repositories;

use Modules\Friends\Entities\Friends;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class FriendsRepository
 * @package Modules\Platform\User\Repositories
 */
class FriendsRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Friends::class;
    }

    /**
     * Save a new entity in repository
     *
     * @throws ValidatorException
     *
     * @param array $attributes
     *
     * @return Friends
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
     * @return Friends
     */
    public function update(array $attributes, $id)
    {
        return parent::update($attributes, $id);
    }
}