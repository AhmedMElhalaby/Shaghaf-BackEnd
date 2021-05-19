<?php

namespace App\Http\Requests\Api\Home;

use App\Helpers\Constant;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\Home\AdvertisementResource;
use App\Http\Resources\Api\Home\CategoryResource;
use App\Http\Resources\Api\Home\CountryResource;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Country;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class InstallRequest extends ApiRequest
{
    public function run(): JsonResponse
    {
        $data = [];
        $data['Settings'] = Setting::pluck((app()->getLocale() =='en')?'value':'value_ar','key')->toArray();
        $data['Categories'] = CategoryResource::collection(Category::where('is_active',true)->whereNull('parent_id')->get());
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
            'UserGender'=>Constant::USER_GENDER,
            'ProductTypes'=>Constant::PRODUCT_TYPE,
            'OrderStatuses'=>Constant::ORDER_STATUSES,
            'ChatMessageType'=>Constant::CHAT_MESSAGE_TYPE,
            'ProviderType'=>Constant::PROVIDER_TYPE,
            'CategoryUserType'=>Constant::CATEGORY_USER_TYPE,
        ];
        return $this->successJsonResponse([],$data);
    }
}
