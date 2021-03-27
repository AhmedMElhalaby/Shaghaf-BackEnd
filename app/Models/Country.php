<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer id
 * @property mixed name
 * @property mixed name_ar
 * @property mixed country_code
 * @property mixed flag
 * @property boolean is_active
 */
class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = ['name','name_ar','country_code','flag','is_active'];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class,'country_id')->where('is_active',true);
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getNameAr(): string
    {
        return $this->name_ar;
    }

    /**
     * @param string $name_ar
     */
    public function setNameAr(string $name_ar): void
    {
        $this->name_ar = $name_ar;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    /**
     * @param string $country_code
     */
    public function setCountryCode(string $country_code): void
    {
        $this->country_code = $country_code;
    }

    /**
     * @return mixed
     */
    public function getFlag()
    {
        return asset($this->flag)?asset($this->flag):null;
    }

    /**
     * @param string $flag
     */
    public function setImage(string $flag): void
    {
        $this->flag = Functions::StoreImageModel($flag,'country/flag');
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

}
