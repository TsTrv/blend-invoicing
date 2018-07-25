@if(count($fields))
<div class="btn-group">
    <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
        Options <span class="caret"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-right">
        @foreach($fields as $field)
        <li>
            <a href="{{ $field['url'] }}" class="{{ $field['class'] }}" onclick="{!! @$field['onclick'] !!}">
                {!! $field['icon'] !!} {{ $field['label'] }}
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endif