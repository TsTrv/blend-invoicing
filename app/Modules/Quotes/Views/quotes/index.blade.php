@extends('layouts.default')

@section('content')

    @include('includes._page_actions', ['fields' => [
        'create' => [
            'label' => 'New',
            'url' => '#',
            'class' => 'create-quote-trigger',
            'icon' =>'<i class="glyphicon glyphicon-plus"></i>'
        ]
    ]])

    @include('errors._form-errors')

    <div class="row">
        <div class="col-sm-12">
            <div class="custom-panel">
                <div class="custom-panel-heading">Quotes</div>
                
                @include('Quotes::quotes._table')

            </div>
        </div>
    </div>
    
    @include('Quotes::quotes._modal_create')
@stop