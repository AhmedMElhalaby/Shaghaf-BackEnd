<?php

namespace App\Http\Requests\Admin\AppContent\Chat;

use App\Http\Controllers\Admin\AppManagement\AdminController;
use App\Models\ChatRoom;
use App\Models\ChatRoomMessage;
use App\Traits\AhmedPanelTrait;
use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }
    public function preset($id){
        $ChatRoom = (new ChatRoom())->find($id);
        $Objects = new ChatRoomMessage();
        $Objects = $Objects->where('chat_room_id',$id);
        if ($this->filled('created_at')){
            $Objects = $Objects->whereDate('created_at',$this->created_at);
        }
        $Objects = $Objects->paginate(10);
        return view('Admin.AppContent.Chat.show',compact('Objects','ChatRoom'));
    }
}
