<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer id
 * @property mixed code
 * @property mixed use_times
 * @property mixed expire_date
 * @property mixed value
 * @property mixed limit
 * @property mixed is_active
 */
class Discount extends Model
{
    protected $table = 'discounts';
    protected $fillable = ['code','use_times','expire_date','value','limit','is_active'];

    public function history(): HasMany
    {
        return $this->hasMany(DiscountHistory::class);
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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getUseTimes()
    {
        return $this->use_times;
    }

    /**
     * @param mixed $use_times
     */
    public function setUseTimes($use_times): void
    {
        $this->use_times = $use_times;
    }

    /**
     * @return mixed
     */
    public function getExpireDate()
    {
        return $this->expire_date;
    }

    /**
     * @param mixed $expire_date
     */
    public function setExpireDate($expire_date): void
    {
        $this->expire_date = $expire_date;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active): void
    {
        $this->is_active = $is_active;
    }

}
