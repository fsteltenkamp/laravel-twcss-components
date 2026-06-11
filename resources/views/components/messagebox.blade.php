<div class="{{$boxClasses}}" role="alert">
    @if($title)
        <div class=" {{$titleClasses}}">{{$title}}</div>
    @endif

    <div class="px-4 py-3">
        {{$slot}}
    </div>
</div>
