<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property mixed user_id
 * @property mixed name
 * @property mixed email
 * @property mixed title
 * @property mixed message
 * @property mixed attachment
 * @property mixed status
 * @method Ticket find(int $id)
 * @method static updateOrCreate(array $array, array $array1)
 */
class Ticket extends Model
{
    protected $table = 'tickets';
    protected $fillable = ['user_id','name','email','title','message','attachment','status'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function ticket_responses(){
        return $this->hasMany(TicketResponse::class);
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
    public function getEmail()
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getAttachment()
    {
        return asset($this->attachment);
    }

    /**
     * @param mixed $attachment
     */
    public function setAttachment($attachment): void
    {
        $this->attachment = Functions::StoreImageModel($attachment,'tickets');
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
