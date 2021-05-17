<?php

namespace App\Http\Middleware;

use Closure;
use Modules\Customers\Entities\Student;
use Modules\Customers\Entities\StudentActivation;

class ActivationStudent
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $student = auth('student')->user();

        if ($student->active == 1) {
            return $next($request);
        }

       return response()->json(array_merge_recursive([
            'meta' => [
                'code' => 401,
                'message' => 'Tài khoản chưa được xác thực, vui lòng kiểm tra email để xác thực tài khoản.'
            ]
        ]))->setStatusCode(401);

    }
}
