<?php

namespace App\Http\Controllers\Admin\AppData;

use App\Http\Controllers\Admin\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Traits\AhmedPanelTrait;

class SubCategoryController extends Controller
{
    use AhmedPanelTrait;

    public function setup()
    {
        $this->setRedirect('app_data/sub_categories');
        $this->setEntity(new Category());
        $this->setTable('categories');
        $this->setLang('Category');
        $this->setFilters([
            'parent_id'=>[
                'name'=>'parent_id',
                'type'=>'whereNotNull',
            ]
        ]);
        $this->setColumns([
            'parent_id'=> [
                'name'=>'parent_id',
                'type'=>'custom_relation',
                'relation'=>[
                    'data'=> Category::whereNull('parent_id')->get(),
                    'custom_search'=>function($Object){
                        return ($Object)?app()->getLocale() == 'ar'?$Object->getNameAr():$Object->getName():'-';
                    },
                    'custom'=>function($Object){
                        return ($Object)?app()->getLocale() == 'ar'?$Object->getNameAr():$Object->getName():'-';
                    },
                    'entity'=>'parent'
                ],
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
            'parent_id'=> [
                'name'=>'parent_id',
                'type'=>'custom_relation',
                'relation'=>[
                    'data'=> Category::whereNull('parent_id')->get(),
                    'custom'=>function($Object){
                        return app()->getLocale() == 'ar'?$Object->getNameAr():$Object->getName();
                    },
                    'entity'=>'parent'
                ],
                'is_required'=>true
            ],
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
