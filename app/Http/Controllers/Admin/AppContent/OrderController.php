<?php

namespace App\Http\Controllers\Admin\AppContent;

use App\Helpers\Constant;
use App\Http\Controllers\Admin\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Traits\AhmedPanelTrait;

class OrderController extends Controller
{
    use AhmedPanelTrait;

    public function setup()
    {
        $this->setRedirect('app_content/orders');
        $this->setEntity(new Order());
        $this->setTable('orders');
        $this->setLang('Order');
        $this->setViewShow('Admin.AppContent.Order.show');
        $this->setCreate(false);
        $this->setColumns([
            'user_id'=> [
                'name'=>'user_id',
                'type'=>'custom_relation',
                'relation'=>[
                    'data'=> User::where('type',Constant::USER_TYPE['Customer'])->get(),
                    'custom'=>function($Object){
                        return ($Object)?$Object->getName():'-';
                    },
                    'entity'=>'user'
                ],
                'is_searchable'=>true,
                'order'=>true
            ],
            'freelancer_id'=> [
                'name'=>'freelancer_id',
                'type'=>'custom_relation',
                'relation'=>[
                    'data'=> User::where('type',Constant::USER_TYPE['Freelancer'])->get(),
                    'custom'=>function($Object){
                        return ($Object)?$Object->getName():'-';
                    },
                    'entity'=>'freelancer'
                ],
                'is_searchable'=>true,
                'order'=>true
            ],
            'product_id'=> [
                'name'=>'product_id',
                'type'=>'custom_relation',
                'relation'=>[
                    'data'=> Product::all(),
                    'custom'=>function($Object){
                        return ($Object)?$Object->getName():'-';
                    },
                    'entity'=>'product'
                ],
                'is_searchable'=>true,
                'order'=>true
            ],
            'status'=> [
                'name'=>'status',
                'type'=>'select',
                'data'=>[
                    Constant::ORDER_STATUSES['New'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['New'],[],session('my_locale')),
                    Constant::ORDER_STATUSES['Accept'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['Accept'],[],session('my_locale')),
                    Constant::ORDER_STATUSES['Rejected'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['Rejected'],[],session('my_locale')),
                    Constant::ORDER_STATUSES['Canceled'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['Canceled'],[],session('my_locale')),
                    Constant::ORDER_STATUSES['Payed'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['Payed'],[],session('my_locale')),
                    Constant::ORDER_STATUSES['InProgress'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['InProgress'],[],session('my_locale')),
                    Constant::ORDER_STATUSES['Delivered'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['Delivered'],[],session('my_locale')),
                    Constant::ORDER_STATUSES['Received'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['Received'],[],session('my_locale')),
                    Constant::ORDER_STATUSES['NotDelivered'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['NotDelivered'],[],session('my_locale')),
                    Constant::ORDER_STATUSES['NotReceived'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['NotReceived'],[],session('my_locale')),
                    Constant::ORDER_STATUSES['ReceivedByAdmin'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['ReceivedByAdmin'],[],session('my_locale')),
                    Constant::ORDER_STATUSES['NotReceivedByAdmin'] =>__('crud.Order.Statuses.'.Constant::ORDER_STATUSES['NotReceivedByAdmin'],[],session('my_locale')),
                ],
                'is_searchable'=>true,
                'order'=>true
            ],
            'total'=> [
                'name'=>'total',
                'type'=>'text',
                'is_searchable'=>true,
                'order'=>true
            ]
        ]);
        $this->SetLinks([
            'show',
        ]);
    }

}
