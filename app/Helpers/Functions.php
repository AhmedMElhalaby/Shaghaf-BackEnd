<?php


namespace App\Helpers;


use App\Events\CreateMessageEvent;
use App\Events\SendGlobalNotificationEvent;
use App\Events\SendNotificationEvent;
use App\Http\Resources\Api\General\NotificationResource;
use App\Models\DiscountHistory;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PasswordReset;
use App\Models\Transaction;
use App\Models\VerifyAccounts;
use App\Notifications\PasswordReset as PasswordResetNotification;
use App\Notifications\VerifyAccount;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class Functions
{
    use ResponseTrait;
    public static function SendNotification($user,$title,$msg,$title_ar,$msg_ar,$ref_id = null,$type= 0,$store = true,$replace =[]): bool
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        if ($user && $user->device_token){
            $registrationIds = $user->device_token;

            $message = array
            (
                'body'  => ($user->getAppLocale() == 'en')?$msg:$msg_ar,
                'title' => ($user->getAppLocale() == 'en')?$title:$title_ar,
                'sound' => true,
                'badge' => Notification::where('user_id',$user->getId())->whereNull('read_at')->count(),
            );
            $extraNotificationData = ["ref_id" =>$ref_id,"type"=>$type];
            $fields = array
            (
                'to'        => $registrationIds,
                'notification'  => $message,
                'data' => $extraNotificationData
            );
            $headers = array
            (
                'Authorization: key='.config('app.notification_key') ,
                'Content-Type: application/json'
            );


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$fcmUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            $result = curl_exec($ch);
            curl_close($ch);
            if($store){
                $notify = new Notification();
                $notify->setType($type);
                $notify->setUserId($user->id);
                $notify->setTitle($title);
                $notify->setMessage($msg);
                $notify->setTitleAr($title_ar);
                $notify->setMessageAr($msg_ar);
                $notify->setRefId(@$ref_id);
                $notify->save();
                $notify->refresh();
            }
            $pusher_data =array
            (
                'body'  => ($user->getAppLocale() == 'en')?$msg:$msg_ar,
                'title' => ($user->getAppLocale() == 'en')?$title:$title_ar,
                'badge' => Notification::where('user_id',$user->getId())->whereNull('read_at')->count(),
                "ref_id" =>$ref_id,
                "type" =>$type
            );
            SendNotificationEvent::dispatch($pusher_data,$user->id);
        }
        return true;
    }
    public static function SendNotifications($users,$title,$msg,$ref_id = null,$type= 0,$store = true,$replace =[]): bool
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $registrationIds = [];
        foreach ($users as $user){
            $registrationIds[] = $user->device_token;

        }

        $message = array
        (
            'body'  => $msg,
            'title' => $title,
            'sound' => true,
        );
        $extraNotificationData = ["ref_id" =>$ref_id,"type"=>$type];
        $fields = array
        (
            'registration_ids' => $registrationIds,
            'notification' => $message,
            'data' => $extraNotificationData
        );
        $headers = array
        (
            'Authorization: key='.config('app.notification_key') ,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        if($store){
            foreach ($users as $user){
                $notify = new Notification();
                $notify->setType($type);
                $notify->setUserId($user->id);
                $notify->setTitle($title);
                $notify->setMessage($msg);
                $notify->setTitleAr($title);
                $notify->setMessageAr($msg);
                $notify->setRefId(@$ref_id);
                $notify->save();
            }
        }
        $pusher_data =array
        (
            'body'  => $msg,
            'title' => $title,
            "ref_id" =>$ref_id,
            "type" =>$type
        );
        SendGlobalNotificationEvent::dispatch($pusher_data);
        return true;
    }
    public static function SendSms($msg,$to){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.msegat.com/gw/sendsms.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);

        $fields = <<<EOT
        {
          "userName": "Passion",
          "numbers": "${to}",
          "userSender": "Passion",
          "apiKey": "3695f1bdf6f10a611ffc8a8badc854e2",
          "msg": "${msg}"
        }
        EOT;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json"
        ));
        $response = curl_exec($ch);
        curl_close($ch);
    }
    public static function SendVerification($user,$type = null): JsonResponse
    {
        if($type != null){
            switch ($type){
                case Constant::VERIFICATION_TYPE['Email']:{
                    if($user->getEmailVerifiedAt() != null)
                        return (new Functions)->failJsonResponse([__('auth.verified_before')]);
                    $code_email = rand( 1000 , 9999 );
                    $token = Str::random(40).time();
                    VerifyAccounts::updateOrCreate(
                        ['user_id' => $user->getId(),'type'=>Constant::VERIFICATION_TYPE['Email']],
                        [
                            'user_id' => $user->getId(),
                            'code' => $code_email,
                            'token' => $token,
                            'type'=>Constant::VERIFICATION_TYPE['Email']
                        ]
                    );
                    $user->notify(
                        new VerifyAccount($token,$code_email)
                    );
                    break;
                }
                case Constant::VERIFICATION_TYPE['Mobile']:{
                    if($user->getMobileVerifiedAt() != null)
                        return (new Functions)->failJsonResponse([__('auth.mobile_verified_before')]);
                    $code_mobile = rand( 1000 , 9999 );
                    $token = Str::random(40).time();
                    VerifyAccounts::updateOrCreate(
                        ['user_id' => $user->getId(),'type'=>Constant::VERIFICATION_TYPE['Mobile']],
                        [
                            'user_id' => $user->getId(),
                            'code' => $code_mobile,
                            'token' => $token,
                            'type'=>Constant::VERIFICATION_TYPE['Mobile']
                        ]
                    );
                    static::SendSms('كود تفعيل الحساب هو : '.$code_mobile,$user->getMobile());
                    break;
                }
            }
        }
        else{
            $code_email = rand( 1000 , 9999 );
            $code_mobile = rand( 1000 , 9999 );
            $token = Str::random(40).time();
            VerifyAccounts::updateOrCreate(
                ['user_id' => $user->getId(),'type'=>Constant::VERIFICATION_TYPE['Email']],
                [
                    'user_id' => $user->getId(),
                    'code' => $code_email,
                    'token' => $token,
                    'type'=>Constant::VERIFICATION_TYPE['Email']
                ]
            );
            VerifyAccounts::updateOrCreate(
                ['user_id' => $user->getId(),'type'=>Constant::VERIFICATION_TYPE['Mobile']],
                [
                    'user_id' => $user->getId(),
                    'code' => $code_mobile,
                    'token' => $token,
                    'type'=>Constant::VERIFICATION_TYPE['Mobile']
                ]
            );
            static::SendSms('كود تفعيل الحساب هو : '.$code_mobile,$user->getMobile());
//            $user->notify(
//                new VerifyAccount($token,$code_email)
//            );
        }
        return (new Functions)->successJsonResponse( [__('auth.verification_code_sent')]);
    }
    public static function SendForget($user,$type = null){
        $code = rand( 1000 , 9999 );
        $token = Str::random(40).time();
        PasswordReset::updateOrCreate(
            ['user_id' => $user->getId()],
            [
                'user_id' => $user->getId(),
                'code' => $code,
                'token' => $token,
            ]
        );
        static::SendSms('كود استرجاع كلمة المرور هو : '.$code,$user->getMobile());
//        $user->notify(
//            new PasswordResetNotification($code)
//        );
    }
    public static function StoreImage($attribute_name,$destination_path): ?string
    {
        $destination_path = "storage/".$destination_path.'/';
        $request = Request::instance();
        if ($request->hasFile($attribute_name)) {
            $file = $request->file($attribute_name);
            if ($file->isValid()) {
                $file_name = md5($file->getClientOriginalName().time()).'.'.$file->getClientOriginalExtension();
                $file->move($destination_path, $file_name);
                $attribute_value =  $destination_path.$file_name;
            }
        }
        return $attribute_value??null;
    }
    public static function StoreImageModel($file,$destination_path): ?string
    {
        $destination_path = "storage/".$destination_path.'/';
        if ($file->isValid()) {
            $file_name = md5($file->getClientOriginalName().time()).'.'.$file->getClientOriginalExtension();
            $file->move($destination_path, $file_name);
            $attribute_value =  $destination_path.$file_name;
        }
        return $attribute_value??null;
    }
    public static function UserBalance($user_id){
        $Deposits = Transaction::where('user_id',$user_id)->where('type',Constant::TRANSACTION_TYPES['Deposit'])->where('status',Constant::TRANSACTION_STATUS['Paid'])->sum('value');
        $Withdraws = Transaction::where('user_id',$user_id)->where('type',Constant::TRANSACTION_TYPES['Withdraw'])->where('status',Constant::TRANSACTION_STATUS['Paid'])->sum('value');
        $Holding = Transaction::where('user_id',$user_id)->where('type',Constant::TRANSACTION_TYPES['Holding'])->where('status',Constant::TRANSACTION_STATUS['Paid'])->sum('value');
        return $Deposits - $Withdraws - $Holding;
    }
    public static function ChangeOrderStatus($OrderId,$Status){
        $OrderStatus = new OrderStatus();
        $OrderStatus->setOrderId($OrderId);
        $OrderStatus->setStatus($Status);
        $OrderStatus->save();
    }
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit) {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }
    public static function GenerateCheckout($value,$payment_type,$object_id){
        $url = "https://oppwa.com/v1/checkouts";
        $entityId= '';
        if ($payment_type == Constant::PAYMENT_TYPES['Credit Card']){
            $entityId = config('app.HYPERPAY_ENTITY_CARD');
        }
        if ($payment_type == Constant::PAYMENT_TYPES['Mada']){
            $entityId = config('app.HYPERPAY_ENTITY_MADA');
        }
        if ($payment_type == Constant::PAYMENT_TYPES['Apple Pay']){
            $entityId = config('app.HYPERPAY_ENTITY_APPLEPAY');
        }
        $data = "entityId=".$entityId.
            "&amount=".$value .
            "&currency=SAR" .
            "&paymentType=DB" .
            "&merchantTransactionId=".$object_id .
            "&customer.email=".auth('api')->user()->getEmail() .
            "&customer.givenName=".auth('api')->user()->getName() .
            "&customer.surname=".auth('api')->user()->getName() .
            "&billing.city=".'Jaddah' .
            "&billing.state=".'Jaddah' .
            "&billing.country=".'SA' .
            "&billing.postcode=".'34424' .
            "&customer.surname=".auth('api')->user()->getName() .
            "&notificationUrl=http://www.example.com/notify";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer '. config('app.HYPERPAY_AUTH_TOKEN')));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData);
        if ($responseData->result->code == "000.200.100"){
            return  [
                'status'=>true,
                'id'=>$responseData->id
            ];
        }else{
            return  [
                'status'=>false,
                'message'=>$responseData->result->description
            ];
        }
    }
    public static function CheckPayment($id,$payment_type){
        $url = "https://oppwa.com/v1/checkouts/{$id}/payment";
        $entityId= '';
        if ($payment_type == Constant::PAYMENT_TYPES['Credit Card']){
            $entityId = config('app.HYPERPAY_ENTITY_CARD');
        }
        if ($payment_type == Constant::PAYMENT_TYPES['Mada']){
            $entityId = config('app.HYPERPAY_ENTITY_MADA');
        }
        if ($payment_type == Constant::PAYMENT_TYPES['Apple Pay']){
            $entityId = config('app.HYPERPAY_ENTITY_APPLEPAY');
        }
        $url .= "?entityId=".$entityId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer '.config('app.HYPERPAY_AUTH_TOKEN')));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData);
        if ($responseData->result->code == "000.100.110"){
            return  [
                'status'=>true,
                'response'=>$responseData
            ];
        }else{
            return  [
                'status'=>false,
                'response'=>$responseData
            ];
        }
    }
    public static function AuthSplitHyperPay(){
        $email = 'faisal-hmood@outlook.com';
        $password = 'passion2020$';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://splits.sandbox.hyperpay.com/api/v1/login");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"email\": \"${email}\",
          \"password\": \"${password}\"
        }");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept: application/json"
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);
        if ($result->status) {
            return $result->data->accessToken;
        }else{
            return false;
        }
    }

    public static function Payout($iban,$swift_code,$name,$amount,$address_1,$address_2,$address_3,$request_refund_id){
        $email = 'faisal-hmood@outlook.com';
        $password = 'passion2020$';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://splits.sandbox.hyperpay.com/api/v1/login");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"email\": \"${email}\",
          \"password\": \"${password}\"
        }");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept: application/json"
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);
        if (!$result->status) {
            return [
                'status'=>false
            ];
        }
        $token= $result->data->accessToken;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://splits.sandbox.hyperpay.com/api/v1/orders");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
          \"merchantTransactionId\": \"${request_refund_id}\",
          \"transferOption\": \"0\",
          \"batchDescription\": \"Transfer fund to beneficiary\",
          \"configId\": \"1afeee12f1b06010cb986433a1d1a33d\",
          \"beneficiary\": [
            {
              \"name\": \"${name}\",
              \"accountId\": \"${iban}\",
              \"debitCurrency\": \"SAR\",
              \"transferAmount\": \"${amount}\",
              \"transferCurrency\": \"SAR\",
              \"payoutBeneficiaryAddress1\": \"${address_1}\",
              \"payoutBeneficiaryAddress2\": \"${address_2}\",
              \"payoutBeneficiaryAddress3\": \"${address_3}\"
            }
          ]
        }");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Bearer ${token}"
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);
        $token_id=$result->data->uniqueId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://splits.sandbox.hyperpay.com/api/v1/orders/${iban}/${token_id}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Bearer ${token}"
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);
        $batch_id= $result->data[0]->batch_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://splits.sandbox.hyperpay.com/api/v1/payouts/${batch_id}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Bearer ${token}"
        ));
        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response);
        if (isset($result->data)) {
            $status = @$result->data[0]->PayoutStatus;
            if ($status != 'Completed') {
                return [
                    'status'=>true,
                    'token_id'=>$token_id
                ];
            }else{
                return [
                    'status'=>false
                ];
            }
        }else{
            return [
                'status'=>false
            ];
        }

    }

    public static function CheckDiscountCode($Discount): array
    {
        $DiscountHistoryCount = (new DiscountHistory())->where('discount_id',$Discount->getId())->where('user_id',auth('api')->user()->getId())->whereIn('payment',[Constant::DISCOUNT_PAYMENT['Pending'],Constant::DISCOUNT_PAYMENT['Done']])->count();
        if (!$Discount->getIsActive()) {
            return [
                'status'=>false,
                'msg'=>__('crud.Discount.Errors.disabled')
            ];
        }
        if ($DiscountHistoryCount == $Discount->getUseTimes()) {
            return [
                'status'=>false,
                'msg'=>__('crud.Discount.Errors.max_usage')
            ];
        }
        if (Carbon::parse($Discount->getExpireDate())->lte(Carbon::today())){
            return [
                'status'=>false,
                'msg'=>__('crud.Discount.Errors.expiration')
            ];
        }
        return ['status'=>true];
    }
}
