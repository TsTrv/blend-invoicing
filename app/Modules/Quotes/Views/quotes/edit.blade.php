@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">Quote #{{ $quote->number }}</div>
            {!! Form::model($quote, ['method' => 'PUT', 'route' => ['quotes.update', $quote->id], 'class' => 'form-horizontal update-quote-form']) !!}

                @include('Quotes::quotes._form')

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop