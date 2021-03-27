<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer id
 * @property mixed user_id
 * @property mixed freelancer_id
 * @property mixed product_id
 * @property mixed status
 * @property mixed quantity
 * @property mixed note
 * @property mixed price
 * @property mixed total
 * @property mixed delivered_date
 * @property mixed delivered_time
 * @property mixed reject_reason
 * @property mixed cancel_reason
 * @method Order find(mixed $order_id)
 */
class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['user_id','freelancer_id','product_id','status','quantity','price','total','note','delivered_date','delivered_time','reject_reason','cancel_reason'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function freelancer(): BelongsTo
    {
        return $this->belongsTo(User::class,'freelancer_id');
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function order_statuses(): HasMany
    {
        return $this->hasMany(OrderStatus::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
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
    public function getFreelancerId()
    {
        return $this->freelancer_id;
    }

    /**
     * @param mixed $freelancer_id
     */
    public function setFreelancerId($freelancer_id): void
    {
        $this->freelancer_id = $freelancer_id;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id): void
    {
        $this->product_id = $product_id;
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

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note): void
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getDeliveredDate()
    {
        return $this->delivered_date;
    }

    /**
     * @param mixed $delivered_date
     */
    public function setDeliveredDate($delivered_date): void
    {
        $this->delivered_date = $delivered_date;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getRejectReason()
    {
        return $this->reject_reason;
    }

    /**
     * @param mixed $reject_reason
     */
    public function setRejectReason($reject_reason): void
    {
        $this->reject_reason = $reject_reason;
    }

    /**
     * @return mixed
     */
    public function getCancelReason()
    {
        return $this->cancel_reason;
    }

    /**
     * @param mixed $cancel_reason
     */
    public function setCancelReason($cancel_reason): void
    {
        $this->cancel_reason = $cancel_reason;
    }

    /**
     * @return mixed
     */
    public function getDeliveredTime()
    {
        return $this->delivered_time;
    }

    /**
     * @param mixed $delivered_time
     */
    public function setDeliveredTime($delivered_time): void
    {
        $this->delivered_time = $delivered_time;
    }



}
