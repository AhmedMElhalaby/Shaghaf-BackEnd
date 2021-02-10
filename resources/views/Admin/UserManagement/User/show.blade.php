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
                                            <th style="border-top: none !important;">{{__('crud.User.name')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getName()}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.User.mobile')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getMobile()}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.User.email')}}</th>
                                            <td style="border-top: none !important;">{{$Object->getEmail()}}</td>
                                        </tr>

                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.User.created_at')}}</th>
                                            <td style="border-top: none !important;">{{\Carbon\Carbon::parse($Object->created_at)->format('Y-m-d')}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.User.balance')}}</th>
                                            <td style="border-top: none !important;">{{\App\Helpers\Functions::UserBalance($Object->getId())}}</td>
                                        </tr>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.User.is_active')}}</th>
                                            <td style="border-top: none !important;">
                                                <span class="label label-{{($Object->isIsActive())?'success':'danger'}}">{{($Object->isIsActive())?__('admin.activation.active'):__('admin.activation.in_active')}}</span>
                                            </td>
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
                                            @foreach(\App\Models\Transaction::where('user_id',$Object->getId())->get() as $Transaction)
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header text-center" style="padding: 5px" data-background-color="{{ config('app.color') }}">
                                    <h4 class="title"> {{__('crud.Document.crud_names')}}</h4>
                                </div>
                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th style="border-top: none !important;">{{__('crud.Document.document_type_id')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Document.front_face')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Document.back_face')}}</th>
                                            <th style="border-top: none !important;">{{__('crud.Document.expiry_date')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\Models\Document::where('user_id',$Object->getId())->get() as $Document)
                                            <tr>
                                                <td>{{(app()->getLocale() =='ar')?$Document->document_type->getNameAr():$Document->document_type->getName()}}</td>
                                                <td><a href="{{asset($Document->getFrontFace())}}" download><i class="fa fa-download"></i></a></td>
                                                <td><a href="{{asset($Document->getBackFace())}}" download><i class="fa fa-download"></i></a></td>
                                                <td>{{($Document->getExpiryDate() != null)?$Document->getExpiryDate():'-'}}</td>
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
