<?php

namespace App\Http\Controllers\Admin\AppData;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\AppData\Setting\SearchRequest;
use App\Http\Requests\AhmedPanel\UpdateRequest;
use App\Models\Setting;
use App\Traits\AhmedPanelTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class SettingController extends Controller
{
    use AhmedPanelTrait;

    public function setup()
    {
        $this->setRedirect('app_data/settings');
        $this->setEntity(new Setting());
        $this->setTable('settings');
        $this->setLang('Setting');
        $this->setCreate(false);
        $this->setExport(false);
        $this->setViewIndex('Admin.AppData.Setting.index');
        $this->setViewEdit('Admin.AppData.Setting.edit');
        $this->setColumns([
            'name'=> [
                'name'=>'name',
                'type'=>'text',
                'is_searchable'=>true,
                'order'=>true
            ],
        ]);
        $this->setFields([
            'name'=> [
                'name'=>'name',
                'type'=>'text',
                'is_required'=>false
            ],
            'name_ar'=> [
                'name'=>'name_ar',
                'type'=>'text',
                'is_required'=>false
            ],
            'value'=> [
                'name'=>'value',
                'type'=>'textarea',
                'is_required'=>true
            ],
            'value_ar'=> [
                'name'=>'value_ar',
                'type'=>'textarea',
                'is_required'=>true
            ],
        ]);
        $this->SetLinks([
            'edit',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param SearchRequest $request
     * @return Factory|View
     */
    public function index(SearchRequest $request)
    {
        return $request->preset($this);
    }
    /**
     * Display a listing of the resource.
     *
     * @param UpdateRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request,$id): RedirectResponse
    {
        if (!$request->filled('value_ar')) {
            $request['value_ar'] = $request->value;
        }
        $validator = Validator::make($request->all(),$this->FieldsRules(true,$id));
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        return $request->preset($this,$id);
    }
}
