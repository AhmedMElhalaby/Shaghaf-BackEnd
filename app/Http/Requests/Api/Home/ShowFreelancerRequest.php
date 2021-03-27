<?php

namespace App\Http\Requests\Api\Home;

use App\Helpers\Constant;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Home\FreelancerResource;
use App\Models\FreelancerCategory;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed user_id
 */
class ShowFreelancerRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }
    public function run(): JsonResponse
    {
        return $this->successJsonResponse([__('messages.saved_successfully')],new FreelancerResource((new User())->find($this->user_id)),'Freelancer');
    }
}
