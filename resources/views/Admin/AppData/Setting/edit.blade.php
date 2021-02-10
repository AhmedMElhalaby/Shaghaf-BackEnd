@extends('AhmedPanel.crud.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" data-background-color="{{ config('app.color') }}">
                    <h4 class="title">{{__('admin.edit')}} {{__(('crud.'.$lang.'.crud_the_name'))}}</h4>
                </div>
                <div class="card-content">
                    <form action="{{url($redirect.'/'.$Object->id)}}" method="post" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PUT">
                        @csrf
                        <div class="row">
                            @if($Object->getType() == \App\Helpers\Constant::SETTING_TYPE['Page'] ||$Object->getType() == \App\Helpers\Constant::SETTING_TYPE['Notification'] )
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label for="name" class="control-label">{{__('crud.'.$lang.'.name')}} *</label>
                                    <input type="text" id="name" name="name" required class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{$Object->getName()}}">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label for="name_ar" class="control-label">{{__('crud.'.$lang.'.name_ar')}} *</label>
                                    <input type="text" id="name_ar" name="name_ar" required class="form-control {{ $errors->has('name_ar') ? ' is-invalid' : '' }}" value="{{$Object->getNameAr()}}">
                                </div>
                                @if ($errors->has('name_ar'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name_ar') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @endif
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label for="value" class="control-label">{{__('crud.'.$lang.'.value')}} *</label>
                                    <textarea id="value" name="value" required class="form-control {{ $errors->has('value') ? ' is-invalid' : '' }}">{{$Object->getValue()}}</textarea>
                                </div>
                                @if ($errors->has('value'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('value') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @if($Object->getType() == \App\Helpers\Constant::SETTING_TYPE['Page'] ||$Object->getType() == \App\Helpers\Constant::SETTING_TYPE['Notification'] )
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label for="value_ar" class="control-label">{{__('crud.'.$lang.'.value_ar')}} *</label>
                                    <textarea id="value_ar" name="value_ar" required class="form-control {{ $errors->has('value_ar') ? ' is-invalid' : '' }}">{{$Object->getValueAr()}}</textarea>
                                </div>
                                @if ($errors->has('value_ar'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('value_ar') }}</strong>
                                    </span>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="row submit-btn">
                            <button type="submit" class="btn btn-primary" style="margin-left:15px;margin-right:15px;">{{__('admin.save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        function permissionCheck() {
            let roleEls = document.getElementsByClassName('role');
            let permissionEls = document.getElementsByClassName('permission');
            for (let p = 0;p<permissionEls.length;p++){
                // permissionEls[p].checked=false;
                permissionEls[p].disabled=false;
            }
            for (let r = 0;r<roleEls.length;r++){
                let roleEl = roleEls[r];
                let permission = RolePermission[roleEl.id];
                for(let i = 0; i < permission.length; i++){
                    let permissionEl = document.getElementById('permission'+permission[i]);
                    if(roleEl.checked){
                        permissionEl.checked=true;
                        permissionEl.disabled=true;
                    }
                }
            }

        }
        permissionCheck();
    </script>
@endsection
