<?php

namespace App\Http\Controllers\Admin\AppContent;

use App\Http\Controllers\Admin\Controller;
use App\Models\Discount;
use App\Traits\AhmedPanelTrait;

class DiscountController extends Controller
{
    use AhmedPanelTrait;

    public function setup()
    {
        $this->setRedirect('app_content/discounts');
        $this->setEntity(new Discount());
        $this->setTable('discounts');
        $this->setLang('Discount');
        $this->setColumns([
            'code'=> [
                'name'=>'code',
                'type'=>'text',
                'is_searchable'=>true,
                'order'=>true
            ],
            'expire_date'=> [
                'name'=>'expire_date',
                'type'=>'date',
                'is_searchable'=>true,
                'order'=>true
            ],
            'is_active'=> [
                'name'=>'is_active',
                'type'=>'active',
                'is_searchable'=>true,
                'order'=>true
            ],
        ]);
        $this->setFields([
            'code'=> [
                'name'=>'code',
                'type'=>'text',
                'is_required'=>true
            ],
            'use_times'=> [
                'name'=>'use_times',
                'type'=>'number',
                'is_required'=>true
            ],
            'expire_date'=> [
                'name'=>'expire_date',
                'type'=>'date',
                'is_required'=>true
            ],
            'value'=> [
                'name'=>'value',
                'type'=>'number',
                'is_required'=>true
            ],
            'limit'=> [
                'name'=>'limit',
                'type'=>'number',
                'is_required'=>true
            ],
            'is_active'=> [
                'name'=>'is_active',
                'type'=>'active',
                'is_required'=>true
            ],
        ]);
        $this->SetLinks([
            'edit',
            'delete',
        ]);
    }

}
