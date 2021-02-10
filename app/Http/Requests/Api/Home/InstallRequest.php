<?php

namespace App\Http\Requests\Api\Home;

use App\Helpers\Constant;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Home\AdvertisementResource;
use App\Http\Resources\Api\Home\CategoryResource;
use App\Http\Resources\Api\Home\CityResource;
use App\Http\Resources\Api\Home\CountryResource;
use App\Http\Resources\Api\Home\FaqResource;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Faq;
use App\Models\Setting;
use App\Traits\ResponseTrait;

class InstallRequest extends ApiRequest
{
    use ResponseTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    public function persist()
    {
        $data = [];
        $data['Settings'] = Setting::pluck((app()->getLocale() =='en')?'value':'value_ar','key')->toArray();
        $data['Faqs'] = FaqResource::collection(Faq::where('is_active',true)->get());
        $data['Categories'] = CategoryResource::collection(Category::where('is_active',true)->get());
        $data['Countries'] = CountryResource::collection(Country::where('is_active',true)->get());
        $data['Advertisements'] = AdvertisementResource::collection(Advertisement::where('is_active',true)->get());
        $data['Essentials'] = [
            'TicketsStatus'=>Constant::TICKETS_STATUS,
            'NotificationType'=>Constant::NOTIFICATION_TYPE,
            'SenderType'=>Constant::SENDER_TYPE,
            'VerificationType'=>Constant::VERIFICATION_TYPE,
            'PaymentMethod'=>Constant::PAYMENT_METHOD,
            'TransactionStatus'=>Constant::TRANSACTION_STATUS,
            'TransactionTypes'=>Constant::TRANSACTION_TYPES,
            'UserTypes'=>Constant::USER_TYPE,
            'ProductTypes'=>Constant::PRODUCT_TYPE,
        ];
        return $this->successJsonResponse([],$data);
    }
}
