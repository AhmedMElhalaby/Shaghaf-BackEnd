<?php

namespace App\Http\Requests\Api\Product;

use App\Helpers\Constant;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Product\ProductResource;
use App\Models\Category;
use App\Models\FreelancerCategory;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

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
    public function rules(): array
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
    public function run(): JsonResponse
    {
        $logged = auth()->user();
        if ($logged->getMobileVerifiedAt() == null){
            return $this->failJsonResponse([__('auth.mobile_not_verified')]);
        }
        $Category = (new Category())->find($this->category_id);
        if ($Category->getUserType() == Constant::CATEGORY_USER_TYPE['All'] || $Category->getUserType() == $logged->getType()){
            $Product =new  Product();
            $Product->setUserId($logged->getId());
            $Product->setName($this->name);
            $Product->setDescription($this->description);
            $Product->setCategoryId($this->category_id);
            $Product->setSubCategoryId($this->sub_category_id);
            $Product->setPrice($this->price);
            $Product->setType($this->type);
            $Product->save();
            $Product->refresh();
            foreach ($this->file('media') as $media) {
                $Media = new Media();
                $Media->setRefId($Product->getId());
                $Media->setMediaType(Constant::MEDIA_TYPES['Product']);
                $Media->setFile($media);
                $Media->save();
            }
            FreelancerCategory::firstOrCreate(
                ['category_id' => $this->category_id,'sub_category_id' => $this->sub_category_id, 'user_id' => $logged->getId()]
            );
            $Product->refresh();
            return $this->successJsonResponse([__('messages.saved_successfully')],new ProductResource($Product),'Product');
        }
        else{
            return $this->failJsonResponse([__('messages.you_are_not_allowed')]);
        }
    }
}
