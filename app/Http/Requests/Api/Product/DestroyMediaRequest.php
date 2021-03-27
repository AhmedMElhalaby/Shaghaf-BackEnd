<?php

namespace App\Http\Requests\Api\Product;

use App\Http\Requests\Api\ApiRequest;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed media_id
 */
class DestroyMediaRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'media_id'=>'required|exists:media,id',
        ];
    }

    public function run(): JsonResponse
    {
        $Object = (new Media())->find($this->media_id);
        try {
            $Object->delete();
            return $this->successJsonResponse([__('messages.deleted_successful')]);
        } catch (\Exception $e) {
            return $this->failJsonResponse([$e->getMessage()]);
        }
    }
}
