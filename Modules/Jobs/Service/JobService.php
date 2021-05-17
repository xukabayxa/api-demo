<?php

namespace Modules\Jobs\Service;

use App\Helpers\UploadImageHelper;
use Modules\Advertisings\Entities\Advertising;
use Modules\Advertisings\Helpers\AdvertisingCategoryHelper;
use Modules\Comments\Entities\Comment;
use Modules\Customers\Entities\Student;
use Modules\Jobs\Entities\Job;
use Modules\Jobs\Helpers\JobCategoryHelper;
use Modules\Jobs\Repositories\JobRepository;

class JobService
{
    protected $repository;

    public function __construct(JobRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     * @param $student
     * @param $schoolIds
     * @param $files
     * @return Job
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function createJob($data, $student, $schoolIds, $files)
    {
        $data['creatable_id'] = $student->id;
        $data['creatable_type'] = Student::class;

        if (JobCategoryHelper::isHasCategoryChildren($data['job_category_id'])) {
            throw new \Exception("can't choose this category because this category has children category");
        }

        /** @var Job $job */
        $job = $this->repository->create($data);

        $job->schools()->sync($schoolIds);

        if (!empty($files)) {
            foreach ($files as $file) {
                UploadImageHelper::uploadImage($file, $job, 'Jobs');
            }
        }

        return $job;
    }

    /**
     * @param $job
     * @param $data
     * @param $schoolIds
     * @param $file_ids
     * @param $files
     * @return Job
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateJob($job, $data, $schoolIds, $file_ids, $files)
    {
        if (JobCategoryHelper::isHasCategoryChildren($data['job_category_id'])) {
            throw new \Exception("can't choose this category because this category has children category");
        }

        $job = $this->repository->update($data, $job->id);

        $job->schools()->sync($schoolIds);

        if (!empty($file_ids)) {
            UploadImageHelper::updateImage($job, $file_ids);
        }

        if (!empty($files)) {

            foreach ($files as $file) {
                UploadImageHelper::uploadImage($file, $job, 'Jobs');
            }

        }
        return $job;
    }

    /**
     * @param Job $job
     * @param $commentId
     * @param $data
     * @return mixed
     */
    public function feedbackComment($job, $commentId, $data)
    {
        /** @var Comment $comment */
        $comment = $job->comments()->find($commentId);

        if ($comment->parent_id == 0) {
            $data['parent_id'] = $comment->id;
        } else {
            $commentParent = $job->comments()->find($comment->parent_id);

            if ($commentParent->parent_id == 0) {
                $data['parent_id'] = $commentId;
            } else {
                $data['parent_id'] = $comment->parent_id;
            }

//            $data['parent_id'] = $commentParent->id;
        }

        $job->comments()->create($data);

        return $job;
    }
}
