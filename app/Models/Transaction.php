<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer id
 * @property integer user_id
 * @property integer|null ref_id
 * @property integer type
 * @property mixed payment_type
 * @property float value
 * @property string|null payment_token
 * @property integer status
 * @method Transaction find(int $id)
 * @method static updateOrCreate(array $array, array $array1)
 */
class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['user_id','ref_id','type','value','payment_token','payment_type','status'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function getNextId()
    {
        $statement = DB::select("show table status like 'posts'");
        return $statement[0]->Auto_increment;
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
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return int|null
     */
    public function getRefId(): ?int
    {
        return $this->ref_id;
    }

    /**
     * @param int|null $ref_id
     */
    public function setRefId(?int $ref_id): void
    {
        $this->ref_id = $ref_id;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function getPaymentToken(): ?string
    {
        return $this->payment_token;
    }

    /**
     * @param string|null $payment_token
     */
    public function setPaymentToken(?string $payment_token): void
    {
        $this->payment_token = $payment_token;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->payment_type;
    }

    /**
     * @param mixed $payment_type
     */
    public function setPaymentType($payment_type): void
    {
        $this->payment_type = $payment_type;
    }

}
