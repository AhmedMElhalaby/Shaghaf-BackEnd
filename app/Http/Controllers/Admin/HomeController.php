<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Functions;
use App\Http\Requests\Admin\Home\DeleteMediaRequest;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;

class HomeController extends Controller
{

    /**
     * @return Factory|View
     */
    public function index(){
        return view('AhmedPanel.home');
    }
    public function lang(): RedirectResponse
    {
        if(session('my_locale','ar') =='en'){
            session(['my_locale' => 'ar']);
        }else{
            session(['my_locale' => 'en']);
        }
        App::setLocale(session('my_locale'));
        return redirect()->back();
    }
    public function general_notification(Request $request): RedirectResponse
    {
        $Title = $request->has('title')?$request->title:'';
        $Message = $request->has('msg')?$request->msg:'';
        $Users = new User();
        if($request->has('type') && $request->type != 0)
            $Users = $Users->where('type',$request->type);
        if ($request->has('user_id')){
            $Users = $Users->where('id',$request->user_id);
        }
        $Users = $Users->whereNotNull('device_token')->get();
        Functions::sendNotifications($Users,$Title,$Message,null,Constant::NOTIFICATION_TYPE['General']);
        return redirect()->back()->with('status', __('admin.messages.notification_sent'));
    }
    public function delete_media(DeleteMediaRequest $request): RedirectResponse
    {
        return $request->preset();
    }
}
