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
                                            <td style="border-top: none !important;"><a href="{{url('app_content/orders?user_id='.$Object->getId())}}">{{\App\Models\Order::where('user_id',$Object->getId())->count()}}</a></td>
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
                                            <th style="border-top: none !important;">{{__('crud.Transaction.created_at')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(\App\Models\Transaction::where('user_id',$Object->getId())->where('status',\App\Helpers\Constant::TRANSACTION_STATUS['Paid'])->get() as $Transaction)
                                                <tr>
                                                    <td>{{__('crud.Transaction.Types.'.$Transaction->getType())}}</td>
                                                    <td>{{$Transaction->getValue()}}</td>
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
                </div>
            </div>
        </div>
    </div>

@endsection
