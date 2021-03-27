<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer id
 * @property mixed user_id
 * @property mixed transaction_id
 * @property mixed token_id
 * @property mixed name
 * @property mixed iban
 * @property mixed swift_code
 * @property mixed address_1
 * @property mixed address_2
 * @property mixed address_3
 * @property mixed amount
 * @property mixed status
 */
class RequestRefund extends Model
{
    protected $table = 'requests_refunds';
    protected $fillable = ['user_id','transaction_id','token_id','name','iban','swift_code','address_1','address_2','address_3','amount','status',];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'parent_id');
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    /**
     * @param mixed $transaction_id
     */
    public function setTransactionId($transaction_id): void
    {
        $this->transaction_id = $transaction_id;
    }

    /**
     * @return mixed
     */
    public function getTokenId()
    {
        return $this->token_id;
    }

    /**
     * @param mixed $token_id
     */
    public function setTokenId($token_id): void
    {
        $this->token_id = $token_id;
    }

    /**
     * @return mixed
     */
    public function getName()
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
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param mixed $iban
     */
    public function setIban($iban): void
    {
        $this->iban = $iban;
    }

    /**
     * @return mixed
     */
    public function getSwiftCode()
    {
        return $this->swift_code;
    }

    /**
     * @param mixed $swift_code
     */
    public function setSwiftCode($swift_code): void
    {
        $this->swift_code = $swift_code;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address_1;
    }

    /**
     * @param mixed $address_1
     */
    public function setAddress1($address_1): void
    {
        $this->address_1 = $address_1;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address_2;
    }

    /**
     * @param mixed $address_2
     */
    public function setAddress2($address_2): void
    {
        $this->address_2 = $address_2;
    }

    /**
     * @return mixed
     */
    public function getAddress3()
    {
        return $this->address_3;
    }

    /**
     * @param mixed $address_3
     */
    public function setAddress3($address_3): void
    {
        $this->address_3 = $address_3;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

}
