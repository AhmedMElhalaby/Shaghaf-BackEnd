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
 * @property mixed product_id
 */
class UpdateRequest extends ApiRequest
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
            'product_id'=>'required|exists:products,id',
            'name'=>'string',
            'description'=>'string',
            'category_id'=>'exists:categories,id',
            'sub_category_id'=>'exists:categories,id',
            'price'=>'numeric',
            'type'=>'numeric|in:'.Constant::PRODUCT_TYPE_RULES,
            'media'=>'array',
            'media.*'=>'mimes:jpeg,jpg,png'
        ];
    }

    public function persist()
    {
        $logged = auth()->user();
        $Product = (new  Product())->find($this->product_id);
        if ($this->filled('name')) {
            $Product->setName($this->name);
        }
        if ($this->filled('description')) {
            $Product->setDescription($this->description);
        }
        if ($this->filled('category_id')) {
            $Product->setCategoryId($this->category_id);
        }
        if ($this->filled('sub_category_id')) {
            $Product->setSubCategoryId($this->sub_category_id);
        }
        if ($this->filled('price')) {
            $Product->setPrice($this->price);
        }
        if ($this->filled('type')) {
            $Product->setType($this->type);
        }
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
