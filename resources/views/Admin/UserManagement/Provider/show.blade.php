@extends('AhmedPanel.crud.main')
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
                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.Transaction.type')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Transaction.value')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Transaction.status')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Transaction.created_at')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody style="height: 300px">
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
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Models\Portfolio::where('user_id',$Object->getId())->get() as $Portfolio)
                                            <tr>
                                                <td><span><img src="{{asset($Portfolio->getMedia())}}" class="thumbnail" alt="" style="width: 50px;height: 50px"></span></td>
                                                <td>{{$Portfolio->getDescription()}}</td>
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
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Models\Product::where('user_id',$Object->getId())->get() as $Product)
                                            <tr>
                                                <td>{{$Product->getName()}}</td>
                                                <td>@if(app()->getLocale() =='en') {{$Product->category->getName()}}/{{$Product->sub_category->getName()}} @else {{$Product->category->getNameAr()}}/{{$Product->sub_category->getNameAr()}} @endif</td>
                                                <td>{{$Product->getPrice()}}</td>
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
