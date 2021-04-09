<li class="nav-item @if(url()->current() == url('/')) active @endif ">
    <a href="{{url('/')}}" class="nav-link">
        <i class="material-icons">dashboard</i>
        <p>{{__('admin.sidebar.home')}}</p>
    </a>
</li>
@foreach(\App\Models\Link::whereNull('parent_id')->get() as $links)
    @if (auth('admin')->user()->can($links->permission->getKey()))
    <li class="nav-item ">
        <a class="nav-link collapsed" data-toggle="collapse" href="#{{$links->getUrl()}}" aria-expanded="false">
            <i class="material-icons">keyboard_arrow_down</i>
            <p> {{app()->getLocale()=='ar'?$links->getNameAr():$links->getName()}}</p>
        </a>
        <div class="collapse @if(strpos(url()->current() , url($links->getUrl()))===0) in @endif" id="{{$links->getUrl()}}" @if(strpos(url()->current() , url($links->getUrl()))===0) aria-expanded="true" @endif>
            <ul class="nav">
                @foreach($links->children as $link)
                    @if (auth('admin')->user()->can($link->permission->getKey()))
                    <li class="nav-item @if(strpos(url()->current() , url($links->getUrl().'/'.$link->getUrl()))===0) active @endif">
                        <a href="{{url($links->getUrl().'/'.$link->getUrl())}}" class="nav-link">
                            <i class="material-icons">{{$link->getIcon()}}</i>
                            <p> {{app()->getLocale()=='ar'?$link->getNameAr():$link->getName()}}</p>
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </li>
    @endif
@endforeach
