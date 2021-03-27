<?php

namespace App\Http\Requests\Api\Portfolio;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\User\PortfolioResource;
use App\Models\Portfolio;
use Illuminate\Http\JsonResponse;

/**
 * @property mixed portfolio_id
 * @property mixed description
 * @property mixed type
 * @property mixed media
 */
class UpdateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'portfolio_id' => 'required|exists:portfolios,id',
            'type' => 'required_with:media|in:'.Constant::PORTFOLIO_MEDIA_TYPE_RULES,
            'media'=>'required_with:type'
        ];
    }
    public function run(): JsonResponse
    {
        $Object = (new  Portfolio())->find($this->portfolio_id);
        if ($this->filled('description')) {
            $Object->setDescription($this->description);
        }
        if ($this->filled('type')) {
            $Object->setType($this->type);
            if ($this->type == Constant::PORTFOLIO_MEDIA_TYPE['Image']) {
                $Object->setMedia(Functions::StoreImage('media','portfolio/media'));
            }else{
                $Object->setMedia($this->media);
            }
        }
        $Object->save();
        $Object->refresh();
        return $this->successJsonResponse([__('messages.saved_successfully')],new PortfolioResource($Object),'Portfolio');
    }
}
