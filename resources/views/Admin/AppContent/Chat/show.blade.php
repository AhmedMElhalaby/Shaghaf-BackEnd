@extends('AhmedPanel.crud.main')
@section('title') | {{__('crud.Chat.name')}} @endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" data-background-color="{{ config('app.color') }}">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="title">{{__('crud.Chat.name')}}</h4>
                    </div>
                </div>
            </div>
            <div class="card-content table-responsive">
                <table class="table">
                    <thead class="text-primary">
                        <th>{{__('crud.Chat.id')}}</th>
                        <th>{{__('crud.Chat.message')}}</th>
                        <th onclick="orderBy('created_at')" class="pointer">
                            {{__('crud.Chat.created_at')}}
                                @if(request()->has('order_type') && request()->order_by =='created_at')
                                    @if(request('order_type') == 'desc')
                                        <span class="px-3"><i class="fa fa-caret-down"></i></span>
                                    @else
                                        <span class="px-3"><i class="fa fa-caret-up"></i></span>
                                    @endif
                                @else
                                    <span class="px-3"><i class="fa fa-sort"></i></span>
                                @endif
                        </th>
                        <th><a href="#" onclick="AdvanceSearch()">{{__('admin.advance_search')}} <i id="advance_search_caret" class="fa fa-caret-down"></i></a></th>
                    </thead>
                    <tbody>
                        <tr id="advance_search">
                            <form action="{{url('app_content/chats/'.$ChatRoom->getId())}}" id="search">
                                <input type="hidden" name="order_by" id="order_by" value="{{app('request')->input('order_by')}}">
                                <input type="hidden" name="order_type" id="order_type" value="{{app('request')->input('order_type')}}">
                                <td>
                                    <div class="form-group" style="margin:0;padding: 0 ">
                                        <label for="id" class="hidden"></label>
                                        <input type="text" name="id" style="margin: 0;padding: 0" id="id" placeholder="{{__('crud.Chat.id')}}" class="form-control" value="{{app('request')->input('id')}}">
                                    </div>
                                </td>
                                <td></td>
                                <td>
                                    <div class="form-group" style="margin:0;padding: 0 ">
                                        <label for="created_at" class="hidden"></label>
                                        <input type="date" name="created_at" style="margin: 0;padding: 0" id="created_at" placeholder="{{__('crud.Chat.created_at')}}" class="form-control" value="{{app('request')->input('created_at')}}">
                                    </div>
                                </td>
                                <td>
                                    <input type="submit" class="btn btn-sm btn-primary" style="margin: 0;" value="{{__('admin.search')}}">
                                </td>
                            </form>
                        </tr>
                    @foreach($Objects as $Object)
                    <tr>
                        <td>#{{$Object->getId()}}</td>
                        <td>
                            @if(\App\Helpers\Constant::CHAT_MESSAGE_TYPE['Text'] ==$Object->getType())
                                {{$Object->getMessage()}}
                            @elseif(\App\Helpers\Constant::CHAT_MESSAGE_TYPE['Audio'] ==$Object->getType())
                                <audio controls>
                                    <source src="{{asset($Object->getMessage())}}">
                                    Your browser does not support the audio element.
                                </audio>
                            @elseif(\App\Helpers\Constant::CHAT_MESSAGE_TYPE['Image'] ==$Object->getType())
                                <span><img src="{{asset($Object->getMessage())}}" class="thumbnail" alt="" style="width: 50px;height: 50px"></span>
                            @elseif(\App\Helpers\Constant::CHAT_MESSAGE_TYPE['File'] ==$Object->getType())
                                <span><a href="{{asset($Object->getMessage())}}" download><i class="fa fa-download"></i></a></span>
                            @endif
                        </td>
                        <td>{{\Carbon\Carbon::parse($Object->created_at)->format('M,d Y h:i A')}}</td>
                        <td class="text-primary">
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="pagination-div">
        {{ $Objects->appends(['id','created_at'])->links('pagination::default') }}
    </div>
</div>
@endsection

