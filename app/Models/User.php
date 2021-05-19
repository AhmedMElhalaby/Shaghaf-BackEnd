<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;

/**
 * @property integer id
 * @property string|null name
 * @property string|null email
 * @property string|null mobile
 * @property string|null password
 * @property string|null type
 * @property string|null country_id
 * @property string|null city_id
 * @property string|null avatar
 * @property string|null bio
 * @property string|null gender
 * @property string|null iban_number
 * @property string|null identity_image
 * @property string|null portfolio_id
 * @property string|null device_token
 * @property string|null device_type
 * @property string|null lat
 * @property string|null lng
 * @property string|null provider_type
 * @property string|null company_name
 * @property string|null maroof_cert
 * @property string|null commercial_cert
 * @property string|null profile_completed
 * @property string|null rate
 * @property string|null email_verified_at
 * @property string|null mobile_verified_at
 * @property string|null order_count
 * @property string|null app_locale
 * @property string|null is_available
 * @property boolean is_active
 * @method User find(int $id)
 */
class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    protected $fillable = ['name','email','mobile','type','country_id','city_id','avatar','bio','gender','iban_number','identity_image','portfolio_id','device_token','device_type','rate','provider_type','company_name','maroof_cert','commercial_cert','profile_completed','lat','lng','email_verified_at','mobile_verified_at','app_locale','order_count','is_available','is_active',];

    protected $hidden = ['password'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function portfolios(): hasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    /**
     * @param $query
     * @param $lat
     * @param $lng
     * @return mixed
     */
    public function scopeNearest($query, $lat, $lng)
    {
        $lat = (float) $lat;
        $lng = (float) $lng;
        return $query->select(DB::raw("*,
                            (6378.10 * ACOS(COS(RADIANS($lat))
                                * COS(RADIANS(lat))
                                * COS(RADIANS($lng) - RADIANS(lng))
                                + SIN(RADIANS($lat))
                                * SIN(RADIANS(lat)))) AS distance"))
            ->orderBy('distance', 'asc');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = Hash::make($password);
    }

    /**
     * @return mixed
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCountryId(): ?string
    {
        return $this->country_id;
    }

    /**
     * @param mixed $country_id
     */
    public function setCountryId($country_id): void
    {
        $this->country_id = $country_id;
    }

    /**
     * @return mixed
     */
    public function getCityId(): ?string
    {
        return $this->city_id;
    }

    /**
     * @param mixed $city_id
     */
    public function setCityId($city_id): void
    {
        $this->city_id = $city_id;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return ($this->avatar)?asset($this->avatar):null;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar): void
    {
        $this->avatar = Functions::StoreImageModel($avatar,'users/avatar');
    }

    /**
     * @return mixed
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * @param mixed $bio
     */
    public function setBio($bio): void
    {
        $this->bio = $bio;
    }

    /**
     * @return mixed
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getIbanNumber(): ?string
    {
        return $this->iban_number;
    }

    /**
     * @param mixed $iban_number
     */
    public function setIbanNumber($iban_number): void
    {
        $this->iban_number = $iban_number;
    }

    /**
     * @return mixed
     */
    public function getIdentityImage()
    {
        return ($this->identity_image)?asset($this->identity_image):null;
    }

    /**
     * @param mixed $identity_image
     */
    public function setIdentityImage($identity_image): void
    {
        $this->identity_image = Functions::StoreImageModel($identity_image,'users/identity_image');
    }

    /**
     * @return mixed
     */
    public function getPortfolioId(): ?string
    {
        return $this->portfolio_id;
    }

    /**
     * @param mixed $portfolio_id
     */
    public function setPortfolioId($portfolio_id): int
    {
        $this->portfolio_id = $portfolio_id;
    }

    /**
     * @return mixed
     */
    public function getDeviceToken(): ?string
    {
        return $this->device_token;
    }

    /**
     * @param mixed $device_token
     */
    public function setDeviceToken($device_token): void
    {
        $this->device_token = $device_token;
    }

    /**
     * @return mixed
     */
    public function getDeviceType(): ?string
    {
        return $this->device_type;
    }

    /**
     * @param mixed $device_type
     */
    public function setDeviceType($device_type): void
    {
        $this->device_type = $device_type;
    }

    /**
     * @return mixed
     */
    public function getRate(): ?string
    {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @return string|null
     */
    public function getProviderType(): ?string
    {
        return $this->provider_type;
    }

    /**
     * @param mixed $provider_type
     */
    public function setProviderType($provider_type): void
    {
        $this->provider_type = $provider_type;
    }

    /**
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }

    /**
     * @param mixed $company_name
     */
    public function setCompanyName($company_name): void
    {
        $this->company_name = $company_name;
    }

    /**
     * @return string|null
     */
    public function getMaroofCert(): ?string
    {
        return ($this->maroof_cert)?asset($this->maroof_cert):null;
    }

    /**
     * @param mixed $maroof_cert
     */
    public function setMaroofCert($maroof_cert): void
    {
        $this->maroof_cert = Functions::StoreImageModel($maroof_cert,'users/maroof_cert');
    }

    /**
     * @return string|null
     */
    public function getCommercialCert(): ?string
    {
        return ($this->commercial_cert)?asset($this->commercial_cert):null;
    }

    /**
     * @param mixed $commercial_cert
     */
    public function setCommercialCert($commercial_cert): void
    {
        $this->commercial_cert = Functions::StoreImageModel($commercial_cert,'users/commercial_cert');
    }

    /**
     * @return string|null
     */
    public function getProfileCompleted(): ?string
    {
        return $this->profile_completed;
    }

    /**
     * @param string|null $profile_completed
     */
    public function setProfileCompleted(?string $profile_completed): void
    {
        $this->profile_completed = $profile_completed;
    }

    /**
     * @return mixed
     */
    public function getLat(): ?string
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng(): ?string
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng): void
    {
        $this->lng = $lng;
    }

    /**
     * @return mixed
     */
    public function getEmailVerifiedAt(): ?string
    {
        return $this->email_verified_at;
    }

    /**
     * @param mixed $email_verified_at
     */
    public function setEmailVerifiedAt($email_verified_at): void
    {
        $this->email_verified_at = $email_verified_at;
    }

    /**
     * @return mixed
     */
    public function getMobileVerifiedAt(): ?string
    {
        return $this->mobile_verified_at;
    }

    /**
     * @param mixed $mobile_verified_at
     */
    public function setMobileVerifiedAt($mobile_verified_at): void
    {
        $this->mobile_verified_at = $mobile_verified_at;
    }

    /**
     * @return mixed
     */
    public function getAppLocale(): ?string
    {
        return $this->app_locale;
    }

    /**
     * @param mixed $app_locale
     */
    public function setAppLocale($app_locale): void
    {
        $this->app_locale = $app_locale;
    }

    /**
     * @return mixed
     */
    public function getIsAvailable(): ?string
    {
        return $this->is_available;
    }

    /**
     * @param mixed $is_available
     */
    public function setIsAvailable($is_available): void
    {
        $this->is_available = $is_available;
    }

    /**
     * @return bool
     */
    public function isIsActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     */
    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return mixed
     */
    public function getOrderCount(): ?string
    {
        return $this->order_count;
    }

    /**
     * @param mixed $order_count
     */
    public function setOrderCount($order_count): void
    {
        $this->order_count = $order_count;
    }

}
