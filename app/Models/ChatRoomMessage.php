<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property integer id
 * @property mixed chat_room_id
 * @property mixed user_id
 * @property mixed message
 * @property mixed type
 * @property mixed read_at
 */
class ChatRoomMessage extends Model
{
    protected $table = 'chats_rooms_messages';
    protected $fillable = ['chat_room_id','user_id','message','type','read_at'];

    public function chat_room(): belongsTo
    {
        return $this->belongsTo(ChatRoom::class);
    }
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
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
    public function getChatRoomId()
    {
        return $this->chat_room_id;
    }

    /**
     * @param mixed $chat_room_id
     */
    public function setChatRoomId($chat_room_id): void
    {
        $this->chat_room_id = $chat_room_id;
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
    public function getType()
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
    public function getReadAt()
    {
        return $this->read_at;
    }

    /**
     * @param mixed $read_at
     */
    public function setReadAt($read_at): void
    {
        $this->read_at = $read_at;
    }

}
