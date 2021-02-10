<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\CheckResetCodeRequest;
use App\Http\Requests\Api\Auth\ForgetPasswordRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\PasswordRequest;
use App\Http\Requests\Api\Auth\RefreshRequest;
use App\Http\Requests\Api\Auth\RegistrationRequest;
use App\Http\Requests\Api\Auth\ResendVerifyRequest;
use App\Http\Requests\Api\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\Auth\UserRequest;
use App\Http\Requests\Api\Auth\VerifyForm;
use App\Http\Resources\Api\User\UserResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ResponseTrait;
    /**
     * Create user
     *
     * @param RegistrationRequest $form
     * @return JsonResponse
     */
    public function register(RegistrationRequest $form): JsonResponse
    {
        return $form->persist();
    }

    /**
     * Login user and create token
     *
     * @param LoginRequest $form
     * @return JsonResponse
     */
    public function login(LoginRequest $form): JsonResponse
    {
        return $form->persist();
    }

    /**
     * Show user profile
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        return $this->successJsonResponse( [__('auth.login')], new UserResource($request->user(),$request->bearerToken()),'User');

    }
    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->update(['device_token'=>null,'device_type'=>null]);
        $request->user()->token()->revoke();
        $request->user()->token()->delete();
        return $this->successJsonResponse([__('auth.logout')]);
    }

    /**
     * Update user profile
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function update(UserRequest $request): JsonResponse
    {
        return $request->persist();
    }
    /**
     * verify account
     *
     * @param ResendVerifyRequest $request
     * @return JsonResponse
     */
    public function resend_verify(ResendVerifyRequest $request): JsonResponse
    {
        return $request->persist();
    }

    /**
     * verify account
     *
     * @param VerifyForm $request
     * @return JsonResponse
     */
    public function verify(VerifyForm $request): JsonResponse
    {
        return $request->persist();
    }

    /**
     * Refresh device token
     *
     * @param RefreshRequest $request
     * @return JsonResponse
     */
    public function refresh(RefreshRequest $request): JsonResponse
    {
         return $request->persist();
    }

    /**
     * @param PasswordRequest $request
     * @return JsonResponse
     */
    public function change_password(PasswordRequest $request): JsonResponse
    {
        return $request->persist();
    }

    /**
     * @param ForgetPasswordRequest $request
     * @return JsonResponse
     */
    public function forget_password(ForgetPasswordRequest $request): JsonResponse
    {
        return $request->persist();
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function reset_password(ResetPasswordRequest $request): JsonResponse
    {
        return $request->persist();
    }

    /**
     * @param CheckResetCodeRequest $request
     * @return JsonResponse
     */
    public function check_reset_code(CheckResetCodeRequest $request): JsonResponse
    {
        return $request->persist();
    }
}
