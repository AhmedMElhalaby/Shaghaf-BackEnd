<?php

namespace App\Models;

use App\Helpers\Functions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer id
 * @property mixed latest_user_id
 * @property mixed latest_message
 * @property mixed latest_type
 * @method ChatRoom find(mixed $chat_room_id)
 */
class ChatRoom extends Model
{
    protected $table = 'chats_rooms';
    protected $fillable = ['latest_user_id','latest_message','latest_type'];

    public function latest_user(): belongsTo
    {
        return $this->belongsTo(User::class,'latest_user_id');
    }
    public function chat_room_users(): HasMany
    {
        return $this->hasMany(ChatRoomUser::class,'chat_room_id');
    }
    public function chat_room_messages(): HasMany
    {
        return $this->hasMany(ChatRoomMessage::class,'chat_room_id');
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
    public function getLatestUserId()
    {
        return $this->latest_user_id;
    }

    /**
     * @param mixed $latest_user_id
     */
    public function setLatestUserId($latest_user_id): void
    {
        $this->latest_user_id = $latest_user_id;
    }

    /**
     * @return mixed
     */
    public function getLatestMessage()
    {
        return $this->latest_message;
    }

    /**
     * @param mixed $latest_message
     */
    public function setLatestMessage($latest_message): void
    {
        $this->latest_message = $latest_message;
    }

    /**
     * @return mixed
     */
    public function getLatestType()
    {
        return $this->latest_type;
    }

    /**
     * @param mixed $latest_type
     */
    public function setLatestType($latest_type): void
    {
        $this->latest_type = $latest_type;
    }

}
