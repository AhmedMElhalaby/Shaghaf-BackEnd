<?php

namespace App\Http\Requests\AhmedPanel;

use App\Http\Controllers\Admin\AppManagement\AdminController;
use App\Traits\AhmedPanelTrait;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
    public function preset($crud){
        $Objects = $crud->getEntity();
        foreach ($crud->getFilters() as $filter){
            if ($filter['type'] == 'where'){
                $Objects = $Objects->where($filter['name'],$filter['value']);
            }
            elseif ($filter['type'] == 'whereNull'){
                $Objects = $Objects->whereNull($filter['name']);
            }
            elseif ($filter['type'] == 'whereNotNull'){
                $Objects = $Objects->whereNotNull($filter['name']);
            }
        }
        foreach ($crud->getColumns() as $column){
            if($this->filled($column['name']) && $column['is_searchable']) {
                if (isset($column['CustomSearch'])){
                    $Objects = $column['CustomSearch']($this->{$column['name']},$Objects);
                }else{
                    $Objects = $Objects->where($column['name'], 'LIKE', '%' . $this->{$column['name']} . '%');
                }
            }

        }
        if($this->filled('order_by') && $this->filled('order_type')) $Objects = $Objects->orderBy($this->order_by,$this->order_type);
        $Objects = $Objects->paginate(($this->per_page)?$this->per_page:10);
        return view($crud->getViewIndex(),compact('Objects'))->with($crud->getParams());
    }
}
