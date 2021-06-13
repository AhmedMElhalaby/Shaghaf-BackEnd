<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer id
 * @property mixed chat_room_id
 * @property mixed user_id
 * @property mixed unread_messages
 */
class ChatRoomUser extends Model
{
    protected $table = 'chats_rooms_users';
    protected $fillable = ['chat_room_id','user_id','unread_messages'];

    public function chat_room(): belongsTo
    {
        return $this->belongsTo(ChatRoom::class);
    }
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
    protected static function boot() {
        parent::boot();
        static::deleting(function($Object) {
            ChatRoom::where('id',$Object->chat_room_id)->delete();
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
    public function getUnreadMessages()
    {
        return $this->unread_messages;
    }

    /**
     * @param mixed $unread_messages
     */
    public function setUnreadMessages($unread_messages): void
    {
        $this->unread_messages = $unread_messages;
    }

}
