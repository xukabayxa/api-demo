<?php

namespace Modules\Customers\Http\Controllers\Api\Student;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\Customers\Entities\Student;
use Modules\Customers\Http\Requests\CustomerCreateApiRequest;
use Modules\Customers\Http\Requests\CustomerUpdateApiRequest;
use Modules\Customers\Http\Requests\StudentCreateApiRequest;
use Modules\Customers\Http\Requests\StudentUpdateApiRequest;
use Modules\Customers\Http\Requests\StudentUpdatePasswordRequest;
use Modules\Customers\Repositories\CustomerRepository;
use Modules\Customers\Repositories\StudentRepository;
use Modules\Customers\Service\StudentService;
use Modules\Customers\Transformers\StudentTransformer;


/**
 * Class CustomersController
 * @property CustomerRepository $repository
 * @package Modules\Customers\Http\Controllers\Api
 */
class StudentsController extends BaseApiController
{

    protected $studentService;

    /**
     * StudentsController constructor.
     * @param StudentRepository $repository
     * @param StudentService $studentService
     */
    public function __construct(StudentRepository $repository, StudentService $studentService)
    {
        $this->studentService = $studentService;
        parent::__construct($repository);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $data = $this->repository->paginate(intval($request->get('per_page')));
        return $this->responseSuccess($this->transform($data, StudentTransformer::class, $request));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request)
    {
        $student = auth('student')->user();

        return $this->responseSuccess($this->transform($student, StudentTransformer::class, $request));
    }


    /**
     * @param StudentCreateApiRequest $request
     * @return JsonResponse
     */
    public function store(StudentCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only(['name', 'email', 'password', 'phone', 'address', 'customer_type_id', 'area_id', 'school_id']);

            $data['password'] = Hash::make($data['password']);

            $file = $request->file('file');

            $customer = $this->studentService->createStudent($data, $file);

            $token = auth('customer')->tokenById($customer->id);

            $response = [
                'token' => $token,
                'customer' => $this->transform($customer, StudentTransformer::class, $request)
            ];

            DB::commit();
            return $this->responseSuccess($response);
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param $identifier
     * @param CustomerUpdateApiRequest $request
     * @return JsonResponse
     */
    public function update($identifier, StudentUpdateApiRequest $request)
    {
        /** @var Student $student */
        $student = $this->repository->find($identifier);

        $data = $request->only(['name', 'phone', 'address', 'customer_type_id', 'area_id', 'school_id', 'school_other_name']);

        $file_ids = $request->input('file_ids');

        $file = $request->file('file');

        DB::beginTransaction();
        try {
            $student = $this->studentService->updateStudent($data, $student, $file_ids, $file);

            DB::commit();
            return $this->responseSuccess($this->transform($student, StudentTransformer::class, $request));
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param StudentUpdatePasswordRequest $request
     * @return JsonResponse
     */
    public function updatePassword(StudentUpdatePasswordRequest $request)
    {
        /** @var Student $student */
        $student = auth('student')->user();

        if ($student->password && !Hash::check($request->get('current_password'), $student->password)) {
            return $this->responseErrors(400, "Mật khẩu hiện tại không đúng.");
        }

        $student->password = Hash::make($request->get('new_password'));
        $student->save();

        return $this->responseSuccess($this->transform($student, StudentTransformer::class, $request));
    }
}
