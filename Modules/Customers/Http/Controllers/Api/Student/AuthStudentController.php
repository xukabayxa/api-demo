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
use Modules\Customers\Repositories\CustomerRepository;
use Modules\Customers\Repositories\StudentRepository;
use Modules\Customers\Service\ActivationService;
use Modules\Customers\Service\StudentService;
use Modules\Customers\Transformers\StudentTransformer;


/**
 * Class AuthStudentController
 * @property StudentRepository $repository
 * @package Modules\Customers\Http\Controllers\Api
 */
class AuthStudentController extends BaseApiController
{

    protected $studentService;
    protected $activationService;

    /**
     * AuthStudentController constructor.
     * @param StudentRepository $repository
     * @param StudentService $studentService
     * @param ActivationService $activationService
     */
    public function __construct(StudentRepository $repository, StudentService $studentService, ActivationService $activationService)
    {
        $this->studentService = $studentService;
        $this->activationService = $activationService;

        parent::__construct($repository);
    }

    public function login(Request $request)
    {
        try {
            $credentials = request(['email', 'password']);

            if (!$token = auth('student')->attempt($credentials)) {
                return $this->responseErrors(401);
            }

            if (!Student::isActive($credentials['email'])) {
                return response()->json(array_merge_recursive([
                    'meta' => [
                        'code' => 401,
                        'message' => 'Tài khoản chưa được xác thực, vui lòng kiểm tra email để xác thực tài khoản.'
                    ]
                ]))->setStatusCode(401);
            }

            $student = auth('student')->user();

            $response = [
                'token' => $token,
                'student' => $this->transform($student, StudentTransformer::class, $request)
            ];

            return $this->responseSuccess($response);
        } catch (\Exception $e) {
            Log::error($e);
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    /**
     * @param StudentCreateApiRequest $request
     * @return JsonResponse
     */
    public function register(StudentCreateApiRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only(['name', 'email', 'password', 'phone', 'address', 'student_type_id', 'area_id', 'school_id']);

            $data['active'] = 0;

            $data['password'] = Hash::make($data['password']);

            $file = $request->file('file');

            $student = $this->studentService->createStudent($data, $file);

            $this->activationService->sendActivationMail($student);

//            $token = auth('student')->tokenById($student->id);
//
//            $response = [
//                'token' => $token,
//                'customer' => $this->transform($student, StudentTransformer::class, $request)
//            ];
            $response = [];
            DB::commit();
            return $this->responseSuccess([], 200, 'Thư xác nhận tài khoản đã được gửi đến email.');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return $this->responseErrors(500, $e->getMessage());
        }
    }

    public function activateStudent($token)
    {
        if ($student = $this->activationService->activateUser($token)) {
//            auth()->login($user);
//            return redirect('/login');
            return 1;
        }
        abort(404);
    }

}
