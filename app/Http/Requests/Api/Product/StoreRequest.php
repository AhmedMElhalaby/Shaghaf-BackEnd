<?php

namespace App\Http\Requests\Api\Product;

use App\Helpers\Constant;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Product\ProductResource;
use App\Models\Media;
use App\Models\Product;
use App\Traits\ResponseTrait;

/**
 * @property mixed name
 * @property mixed description
 * @property mixed category_id
 * @property mixed sub_category_id
 * @property mixed price
 * @property mixed type
 */
class StoreRequest extends ApiRequest
{
    use ResponseTrait;


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|string',
            'description'=>'required|string',
            'category_id'=>'required|exists:categories,id',
            'sub_category_id'=>'required|exists:categories,id',
            'price'=>'required|numeric',
            'type'=>'required|numeric|in:'.Constant::PRODUCT_TYPE_RULES,
            'media'=>'required|array',
            'media.*'=>'required|mimes:jpeg,jpg,png'
        ];
    }

    public function persist()
    {
        $logged = auth()->user();
        $Product =new  Product();
        $Product->setUserId($logged->getId());
        $Product->setName($this->name);
        $Product->setDescription($this->description);
        $Product->setCategoryId($this->category_id);
        $Product->setSubCategoryId($this->sub_category_id);
        $Product->setPrice($this->price);
        $Product->setType($this->type);
        foreach ($this->file('media') as $media) {
            $Media = new Media();
            $Media->setRefId($Product->getId());
            $Media->setMediaType(Constant::MEDIA_TYPES['Product']);
            $Media->setFile($media);
            $Media->save();
        }
        $Product->save();
        $Product->refresh();
        return $this->successJsonResponse([__('messages.saved_successfully')],new ProductResource($Product),'Product');
    }
}
