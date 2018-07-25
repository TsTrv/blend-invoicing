@if(count($fields))
	<div class="row">
	    <div class="col-sm-12">
	    @foreach($fields as $field)
	        <a href="{{ $field['url'] }}" class="btn btn-primary pull-right {{ $field['class'] }}" onclick="{!! @$field['onclick'] !!}">
                {!! $field['icon'] !!} {{ $field['label'] }}
            </a>
	    @endforeach
	    </div>
	</div>
@endif