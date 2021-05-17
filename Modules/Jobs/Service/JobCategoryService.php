<?php

namespace Modules\Jobs\Service;

use Illuminate\Support\Str;
use Modules\Jobs\Entities\JobCategory;
use Modules\Jobs\Repositories\JobCategoryRepository;

class JobCategoryService
{
    protected $repository;

    public function __construct(JobCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     * @return \Modules\Jobs\Entities\Job
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createCategory($data)
    {
        if ($data['type'] == 'parent') {
            $data['parent_id'] = 0;
        } else {
            /** @var JobCategory $cateParent */
            $cateParent = $this->repository->find($data['parent_id']);

            if ($cateParent->jobs->isNotEmpty()) {
                throw new \Exception("can't choose this category parent because it has products");
            }
        }

        $data['slug'] = Str::slug($data['name']);

        $category = $this->repository->create($data);

        return $category;

    }
}
