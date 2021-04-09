<?php

namespace App\Http\Controllers\Admin\AppContent;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\AppContent\Chat\ShowRequest;
use App\Models\ChatRoom;
use App\Models\ChatRoomUser;
use App\Models\User;
use App\Traits\AhmedPanelTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ChatController extends Controller
{
    use AhmedPanelTrait;

    public function setup()
    {
        $this->setRedirect('app_content/chats');
        $this->setEntity(new ChatRoom());
        $this->setViewShow('Admin.AppContent.Chat.show');
        $this->setTable('chats_rooms');
        $this->setLang('ChatRoom');
        $this->setColumns([
            'users_name'=> [
                'name'=>'users_name',
                'type'=>'custom_relation',
                'relation'=>[
                    'data'=>User::all(),
                    'custom_search'=>function($Object){
                        return $Object->getName();
                    },
                    'entity'=>'id',
                    'custom'=>function($Object){
                        $h = '';
                        foreach ($Object->chat_room_users as $key=>$chat_room_user) {
                            $h .= (($key != 0)?' - ':'').$chat_room_user->user->getName();
                        }
                        return $h;
                    },
                ],
                'CustomSearch'=>function($Object,$query){
                    $Objects = (new ChatRoomUser())->where('user_id',$Object)->pluck('chat_room_id');
                    $query = $query->whereIn('id',$Objects);
                    return $query;
                },
                'is_searchable'=>true,
                'order'=>false
            ]
        ]);
        $this->SetLinks([
            'show',
        ]);
    }

    /**
     * @param ShowRequest $request
     * @param $id
     * @return Application|Factory|View
     */
    public function show(ShowRequest $request, $id)
    {
        return $request->preset($id);
    }
}
