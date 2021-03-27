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
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.user_id')}}</th>
                                            <td style="border-top: none !important;">{{$Object->user->getName()}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.freelancer_id')}}</th>
                                            <td style="border-top: none !important;">{{$Object->freelancer->getName()}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.product_id')}}</th>
                                            <td style="border-top: none !important;">{{$Object->product->getName()}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.quantity')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getQuantity()}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.price')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getPrice()}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.total')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getTotal()}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.created_at')}}</th>
                                            <td style="border-top: none !important;">{{\Carbon\Carbon::parse($Object->created_at)->format('Y-m-d')}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.status')}}</th>
                                            <td style="border-top: none !important;">{{__('crud.'.$lang.'.Statuses.'.$Object->getStatus())}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.delivered_date')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getDeliveredDate()}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.'.$lang.'.delivered_time')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getDeliveredTime()}}</td>
                                        </tr>
                                        @if($Object->getRejectReason() != null)
                                            <tr>
                                                <th style="border-top: none !important;">{{__('crud.'.$lang.'.reject_reason')}}</th>
                                                <td style="border-top: none !important;">{{$Object->getRejectReason()}}</td>
                                            </tr>
                                        @endif
                                        @if($Object->getCancelReason() != null)
                                            <tr>
                                                <th style="border-top: none !important;">{{__('crud.'.$lang.'.cancel_reason')}}</th>
                                                <td style="border-top: none !important;">{{$Object->getCancelReason()}}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header text-center" style="padding: 5px" data-background-color="{{ config('app.color') }}">
                                    <h4 class="title"> {{__('crud.Order.statuses_history')}}</h4>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.Order.status')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Order.created_at')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Object->order_statuses as $order_status)
                                            <tr>
                                                <td>{{__('crud.Order.Statuses.'.$order_status->getStatus())}}</td>
                                                <td>{{\Carbon\Carbon::parse($order_status->created_at)->format('Y-m-d h:i A')}}</td>
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
