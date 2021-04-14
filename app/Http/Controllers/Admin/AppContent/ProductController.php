<?php

namespace App\Http\Controllers\Admin\AppContent;

use App\Helpers\Constant;
use App\Http\Controllers\Admin\Controller;
use App\Models\Product;
use App\Models\User;
use App\Traits\AhmedPanelTrait;

class ProductController extends Controller
{
    use AhmedPanelTrait;

    public function setup()
    {
        $this->setRedirect('app_content/products');
        $this->setEntity(new Product());
        $this->setTable('products');
        $this->setLang('Product');
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
            'name'=>[
                'name'=>'name',
                'type'=>'text',
                'is_searchable'=>true,
                'order'=>true
            ],
            'description'=>[
                'name'=>'description',
                'type'=>'text',
                'is_searchable'=>true,
                'order'=>true
            ],
            'price'=>[
                'name'=>'price',
                'type'=>'text',
                'is_searchable'=>true,
                'order'=>true
            ],
        ]);
        $this->SetLinks([
            'show',
        ]);
    }

}
