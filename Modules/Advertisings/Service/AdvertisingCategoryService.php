<?php

namespace Modules\Advertisings\Service;

use Illuminate\Support\Str;
use Modules\Advertisings\Entities\AdvertisingCategory;
use Modules\Advertisings\Repositories\AdvertisingCategoryRepository;

class AdvertisingCategoryService
{
    protected $repository;

    public function __construct(AdvertisingCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     * @return \Modules\Advertisings\Entities\Advertising
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createCategory($data)
    {
        if ($data['type'] == 'parent') {
            $data['parent_id'] = 0;
        } else {
            /** @var AdvertisingCategory $cateParent */
            $cateParent = $this->repository->find($data['parent_id']);

            if ($cateParent->advertisings->isNotEmpty()) {
                throw new \Exception("can't choose this category parent because it has products");
            }
        }

        $data['slug'] = Str::slug($data['name']);

        $category = $this->repository->create($data);

        return $category;

    }
}
