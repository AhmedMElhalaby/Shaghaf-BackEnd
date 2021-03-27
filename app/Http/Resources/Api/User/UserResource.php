<?php

namespace App\Http\Resources\Api\User;

use App\Helpers\Constant;
use App\Http\Resources\Api\Home\CityResource;
use App\Http\Resources\Api\Home\CountryResource;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected $token;
    public function __construct($resource, $token =null)
    {
        $this->token = $token;
        parent::__construct($resource);
    }
    public function toArray($request): array
    {
        $Object['id'] = $this->getId();
        $Object['name'] = $this->getName();
        $Object['mobile'] = $this->getMobile();
        $Object['country_id'] = $this->getCountryId();
        $Object['city_id'] = $this->getCityId();
        $Object['Country'] = new CountryResource($this->country);
        $Object['City'] = new CityResource($this->city);
        $Object['email'] = $this->getEmail();
        $Object['bio'] = $this->getBio();
        $Object['gender'] = $this->getGender();
        $Object['iban_number'] = $this->getIbanNumber();
        $Object['identity_image'] = $this->getIdentityImage();
        $Object['mobile_verified_at'] = $this->getMobileVerifiedAt()?Carbon::parse($this->getMobileVerifiedAt())->format('Y-m-d'):null;
        $Object['email_verified_at'] = $this->getEmailVerifiedAt()?Carbon::parse($this->getEmailVerifiedAt())->format('Y-m-d'):null;
        $Object['avatar'] = asset($this->getAvatar());
        $Object['lat'] = $this->getLat();
        $Object['lng'] = $this->getLng();
        $Object['type'] = $this->getType();
        $Object['provider_type'] = $this->getProviderType();
        $Object['company_name'] = $this->getCompanyName();
        $Object['maroof_cert'] = $this->getMaroofCert();
        $Object['commercial_cert'] = $this->getCommercialCert();
        if ($this->getProviderType() == Constant::PROVIDER_TYPE['Individual']) {
            if ($this->getIdentityImage() != null && $this->getMaroofCert() !=null) {
                $Object['profile_completed'] = true;
            }else{
                $Object['profile_completed'] = false;
            }
        }else{
            if ($this->getIdentityImage() != null && $this->getCommercialCert() !=null) {
                $Object['profile_completed'] = true;
            }else{
                $Object['profile_completed'] = false;
            }
        }
        $Object['rate'] = $this->getRate();
        $Object['Portfolios'] = PortfolioResource::collection($this->portfolios);
        $Object['is_available'] = $this->getIsAvailable();
        $Object['app_locale'] = $this->getAppLocale();
        $Object['notification_count'] = Notification::where('user_id',$this->getId())->where('read_at',null)->count();
        $Object['access_token'] = $this->token;
        $Object['token_type'] = 'Bearer';
        return $Object;
    }

}
