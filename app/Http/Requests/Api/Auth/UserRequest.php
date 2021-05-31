<?php

namespace App\Http\Requests\Api\Auth;

use App\Helpers\Constant;
use App\Http\Requests\Api\ApiRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * @property mixed name
 * @property mixed country_id
 * @property mixed city_id
 * @property mixed mobile
 * @property mixed email
 * @property mixed lat
 * @property mixed lng
 * @property mixed bio
 * @property mixed gender
 * @property mixed iban_number
 * @property mixed identity_image
 * @property mixed is_available
 * @property mixed app_locale
 * @property mixed device_token
 * @property mixed device_type
 * @property mixed provider_type
 * @property mixed company_name
 * @property mixed maroof_cert
 * @property mixed commercial_cert
 */
class UserRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|max:255,',
            'country_id' => 'exists:countries,id',
            'city_id' => 'exists:cities,id',
            'mobile' => 'numeric|min:6|unique:users,mobile,'. auth()->user()->id,
            'email' => 'email|unique:users,email,'. auth()->user()->id,
            'device_token' => 'string|required_with:device_type',
            'device_type' => 'string|required_with:device_token',
            'app_locale' => 'string|in:ar,en',
            'portfolio_id' => 'sometimes|exists:Portfolio'
        ];
    }
    public function run(): JsonResponse
    {
        $logged = $this->user();
        if($this->hasFile('identity_image')){
            $logged->setIdentityImage($this->file('identity_image'));
        }
        if($this->hasFile('avatar')){
            $logged->setAvatar($this->file('avatar'));
        }
        if ($this->filled('name')){
            $logged->setName($this->name);
        }
        if ($this->filled('iban_number')){
            $logged->setIbanNumber($this->iban_number);
        }
        if ($this->filled('is_available')){
            $logged->setIsAvailable($this->is_available);
        }
        if ($this->filled('city_id')){
            $logged->setCityId($this->city_id);
        }
        if ($this->filled('country_id')){
            $logged->setCountryId($this->country_id);
        }
        if ($this->filled('mobile')){
            $logged->setMobile($this->mobile);
        }
        if ($this->filled('email')){
            $logged->setEmail($this->email);
        }
        if ($this->filled('lat')){
            $logged->setLat($this->lat);
        }
        if ($this->filled('lng')){
            $logged->setLng($this->lng);
        }
        if ($this->filled('bio')){
            $logged->setBio($this->bio);
        }
        if ($this->filled('provider_type')){
            $logged->setProviderType($this->provider_type);
        }
        if ($this->filled('company_name')){
            $logged->setCompanyName($this->company_name);
        }
        if ($this->hasFile('maroof_cert')){
            $logged->setMaroofCert($this->maroof_cert);
        }
        if ($this->hasFile('commercial_cert')){
            $logged->setCommercialCert($this->commercial_cert);
        }
        if ($this->filled('gender')){
            $logged->setGender($this->gender);
        }
        if ($this->filled('app_locale')){
            $logged->setAppLocale($this->app_locale);
        }
        if ($this->filled('device_token')&&$this->filled('device_type')){
            $logged->setDeviceToken($this->device_token);
            $logged->setDeviceType($this->device_type);
        }
        $logged->save();
        $logged->refresh();
        if ($logged->getType() == Constant::USER_TYPE['Freelancer']){
            if ($logged->getProviderType() == Constant::PROVIDER_TYPE['Individual']){
                if ($logged->identity_image != null && $logged->maroof_cert != null){
                    $logged->setProfileCompleted(true);
                    $logged->save();
                }
            }else{
                if ($logged->identity_image != null && $logged->commercial_cert != null){
                    $logged->setProfileCompleted(true);
                    $logged->save();
                }
            }
        }
        DB::table('oauth_access_tokens')->where('user_id', $logged->id)->delete();
        $tokenResult = $logged->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return $this->successJsonResponse( [__('messages.updated_successful')],new UserResource($logged,$tokenResult->accessToken),'User');
    }
}
