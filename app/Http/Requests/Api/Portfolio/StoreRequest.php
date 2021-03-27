<?php

namespace App\Http\Requests\Api\Portfolio;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\User\PortfolioResource;
use App\Models\Media;
use App\Models\Portfolio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed description
 * @property mixed type
 * @property mixed media
 */
class StoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'description' => 'required',
            'type' => 'required|in:'.Constant::PORTFOLIO_MEDIA_TYPE_RULES,
            'media'=>'required'
        ];
    }

    public function run(): JsonResponse
    {
        $Object =new  Portfolio();
        $Object->setUserId(auth()->user()->getId());
        $Object->setDescription(@$this->description);
        $Object->setType($this->type);
        if ($this->type == Constant::PORTFOLIO_MEDIA_TYPE['Image']) {
            $Object->setMedia(Functions::StoreImage('media','portfolio/media'));
        }else{
            $Object->setMedia($this->media);
        }
        $Object->save();
        $Object->refresh();
        return $this->successJsonResponse([__('messages.created_successful')],new PortfolioResource($Object),'Portfolio');
    }
}
