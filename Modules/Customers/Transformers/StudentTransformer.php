<?php

namespace Modules\Customers\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Areas\Transformers\AreaTransformer;
use Modules\Customers\Entities\Student;
use Modules\Files\Transformers\FileTransformer;
use Modules\Schools\Entities\School;
use Modules\Schools\Transformers\SchoolTransformer;

class StudentTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [];
    protected $defaultIncludes = ['area', 'school', 'file'];

    public function transform(Student $student)
    {
        return [
            'id' => $student->id,
            'email' => $student->email,
            'address' => $student->address,
            'phone' => $student->phone,
            'student_type_id' => $student->student_type_id,
            'area_id' => $student->area_id,
            'school_other_name' => $student->school_other_name,
            'is_user' => 'student',
            'created_at' => $student->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $student->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param Student $student
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeArea(Student $student)
    {
        $area = $student->area;
        return $area ? $this->item($area, new AreaTransformer()) : $this->primitive(null);
    }

    /**
     * @param Student $student
     * @return \League\Fractal\Resource\Item|\League\Fractal\Resource\Primitive
     */
    public function includeSchool(Student $student)
    {
        $school = $student->school;
        return $school ? $this->item($school, new SchoolTransformer()) : $this->primitive(null);
    }

    /**
     * @param Student $student
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\Primitive
     */
    public function includeFile(Student $student)
    {
        $files = $student->files;
        return $files ? $this->collection($files, new FileTransformer()) : $this->primitive(null);
    }
}
