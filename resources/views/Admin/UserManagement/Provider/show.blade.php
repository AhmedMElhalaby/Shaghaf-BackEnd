@extends('AhmedPanel.crud.main')
@section('out-content')
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{url($redirect.'/destroy')}}" id="delete_form" method="post">
                <input name="_method" type="hidden" value="DELETE">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel">{{__('admin.delete')}} :  <span id="del_name"></span></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" >
                        <p>{{__('admin.sure_to_delete')}}  !! </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('admin.cancel')}}</button>
                        <button type="submit" class="btn btn-danger">{{__('admin.delete')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header " data-background-color="{{ config('app.color') }}">
                    <h4 class="title">{{__('admin.show')}} {{__(('crud.'.$lang.'.crud_the_name'))}}</h4>
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.name')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getName()}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.mobile')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getMobile()}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.email')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getEmail()}}</td>
                                        </tr>

                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.created_at')}}</th>
                                            <td style="border-top: none !important;">{{\Carbon\Carbon::parse($Object->created_at)->format('Y-m-d')}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.balance')}}</th>
                                            <td style="border-top: none !important;">{{\App\Helpers\Functions::UserBalance($Object->getId())}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.is_active')}}</th>
                                            <td style="border-top: none !important;">
                                                <span class="label label-{{($Object->isIsActive())?'success':'danger'}}">{{($Object->isIsActive())?__('admin.activation.active'):__('admin.activation.in_active')}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.iban_number')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getIbanNumber()}}</td>
                                        </tr>
                                        @if($Object->getIdentityImage())
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.identity_image')}}</th>
                                            <td style="border-top: none !important;"><a href="{{$Object->getIdentityImage()}}" download></a></td>
                                        </tr>
                                        @endif
                                        @if($Object->getMaroofCert())
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.maroof_cert')}}</th>
                                            <td style="border-top: none !important;"><a href="{{$Object->getMaroofCert()}}" download></a></td>
                                        </tr>
                                        @endif
                                        @if($Object->getCommercialCert())
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.commercial_cert')}}</th>
                                            <td style="border-top: none !important;"><a href="{{$Object->getCommercialCert()}}" download></a></td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.orders_count')}}</th>
                                            <td style="border-top: none !important;"><a href="{{url('app_content/orders?freelancer_id='.$Object->getId())}}">{{\App\Models\Order::where('freelancer_id',$Object->getId())->count()}}</a></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header text-center" style="padding: 5px" data-background-color="{{ config('app.color') }}">
                                    <h4 class="title"> {{__('crud.Transaction.crud_names')}}</h4>
                                </div>
                                <div class="card-content table-responsive" style="height: 312px;overflow: scroll">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.Transaction.type')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Transaction.value')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Transaction.status')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Transaction.created_at')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(\App\Models\Transaction::where('user_id',$Object->getId())->get() as $Transaction)
                                                <tr>
                                                    <td>{{__('crud.Transaction.Types.'.$Transaction->getType())}}</td>
                                                    <td>{{$Transaction->getValue()}}</td>
                                                    <td>{{__('crud.Transaction.Statuses.'.$Transaction->getStatus())}}</td>
                                                    <td>{{\Carbon\Carbon::parse($Transaction->created_at)->format('Y-m-d')}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header" data-background-color="{{ config('app.color') }}">
                                    <h4 class="title">  {{__('admin.Home.n_send_general')}} </h4>
                                </div>
                                <div class="card-content">
                                    <form action="{{url('notification/send')}}" method="post">
                                        @csrf
                                        <input type="hidden" id="user_id" name="user_id" value="{{$Object->getId()}}">
                                        <div class="row">
                                            <div class="col-md-4 btn-group required">
                                                <label for="title">{{__('admin.Home.n_title')}} :</label>
                                                <input type="text" required="" name="title" id="title" class="form-control" placeholder="{{__('admin.Home.n_enter_title')}}">
                                            </div>
                                            <div class="col-md-6 btn-group required">
                                                <label for="msg">{{__('admin.Home.n_text')}} :</label>
                                                <input type="text" required="" name="msg" id="msg" class="form-control" placeholder="{{__('admin.Home.n_enter_text')}}">
                                            </div>
                                            <div class="col-md-1 " style="margin-top: 50px">
                                                <button type="submit" id="send" class="btn btn-primary">{{__('admin.Home.n_send')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header text-center" style="padding: 5px" data-background-color="{{ config('app.color') }}">
                                    <h4 class="title"> {{__('crud.Portfolio.crud_names')}}</h4>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.Portfolio.media')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Portfolio.description')}}</th>
                                            <th style="border-top: none !important;">{{__('admin.delete')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Models\Portfolio::where('user_id',$Object->getId())->get() as $Portfolio)
                                            <tr>
                                                <td><span><img src="{{asset($Portfolio->getMedia())}}" class="thumbnail" alt="" style="width: 50px;height: 50px"></span></td>
                                                <td>{{$Portfolio->getDescription()}}</td>
                                                <td>
                                                    <a href="#" class="fs-20" data-toggle="modal" data-target="#delete" onclick="document.getElementById('del_name').innerHTML = '{{@$Portfolio->getDescription()}}';document.getElementById('id').value = '{{@$Portfolio->getId()}}';document.getElementById('delete_form').action = '{{url('app_content/portfolios/'.$Portfolio->getId())}}'"><i class="fa fa-trash" data-toggle="tooltip" data-placement="bottom" title="{{__('admin.delete')}}"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header text-center" style="padding: 5px" data-background-color="{{ config('app.color') }}">
                                    <h4 class="title"> {{__('crud.Product.crud_names')}}</h4>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.Product.name')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Product.category_id')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Product.price')}}</th>
                                            <th style="border-top: none !important;">{{__('admin.delete')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Models\Product::where('user_id',$Object->getId())->get() as $Product)
                                            <tr>
                                                <td>{{$Product->getName()}}</td>
                                                <td>@if($Product->category) @if(app()->getLocale() =='en') {{$Product->category->getName()}}/{{$Product->sub_category->getName()}} @else {{$Product->category->getNameAr()}}/{{$Product->sub_category->getNameAr()}} @endif @else - @endif</td>
                                                <td>{{$Product->getPrice()}}</td>
                                                <td>
                                                    <a href="#" class="fs-20" data-toggle="modal" data-target="#delete" onclick="document.getElementById('del_name').innerHTML = '{{@$Product->getName()}}';document.getElementById('id').value = '{{@$Product->getId()}}';document.getElementById('delete_form').action = '{{url('app_content/products/'.$Product->getId())}}'"><i class="fa fa-trash" data-toggle="tooltip" data-placement="bottom" title="{{__('admin.delete')}}"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
