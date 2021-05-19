<?php

namespace App\Http\Controllers\Admin\AppData;

use App\Helpers\Constant;
use App\Http\Controllers\Admin\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Traits\AhmedPanelTrait;

class CategoryController extends Controller
{
    use AhmedPanelTrait;

    public function setup()
    {
        $this->setRedirect('app_data/categories');
        $this->setEntity(new Category());
        $this->setTable('categories');
        $this->setLang('Category');
        $this->setFilters([
            'parent_id'=>[
                'name'=>'parent_id',
                'type'=>'whereNull',
            ]
        ]);
        $this->setColumns([
            'image'=> [
                'name'=>'image',
                'type'=>'image',
                'is_searchable'=>true,
                'order'=>true
            ],
            'name'=> [
                'name'=>'name',
                'type'=>'text',
                'is_searchable'=>true,
                'order'=>true
            ],
            'name_ar'=> [
                'name'=>'name_ar',
                'type'=>'text',
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
            'name'=> [
                'name'=>'name',
                'type'=>'text',
                'is_required'=>true
            ],
            'name_ar'=> [
                'name'=>'name_ar',
                'type'=>'text',
                'is_required'=>true
            ],
            'description'=> [
                'name'=>'description',
                'type'=>'text',
                'is_required'=>true
            ],
            'description_ar'=> [
                'name'=>'description_ar',
                'type'=>'text',
                'is_required'=>true
            ],
            'user_type'=> [
                'name'=>'user_type',
                'type'=>'select',
                'data'=>[
                    Constant::CATEGORY_USER_TYPE['All'] =>__('crud.Category.UserTypes.'.Constant::CATEGORY_USER_TYPE['All'],[],session('my_locale')),
                    Constant::CATEGORY_USER_TYPE['Customer'] =>__('crud.Category.UserTypes.'.Constant::CATEGORY_USER_TYPE['Customer'],[],session('my_locale')),
                    Constant::CATEGORY_USER_TYPE['Freelancer'] =>__('crud.Category.UserTypes.'.Constant::CATEGORY_USER_TYPE['Freelancer'],[],session('my_locale')),
                ],
                'is_required'=>true
            ],
            'image'=> [
                'name'=>'image',
                'type'=>'image',
                'is_required'=>true,
                'is_required_update'=>false
            ],
            'has_product'=> [
                'name'=>'has_product',
                'type'=>'boolean',
                'is_required'=>true
            ],
            'has_service'=> [
                'name'=>'has_service',
                'type'=>'boolean',
                'is_required'=>true
            ],
            'home_service'=> [
                'name'=>'home_service',
                'type'=>'boolean',
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
