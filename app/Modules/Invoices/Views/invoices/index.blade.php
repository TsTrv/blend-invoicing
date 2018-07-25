@extends('layouts.default')

@section('content')

    @include('includes._page_actions', ['fields' => [
        'create' => [
            'label' => 'New',
            'url' => '#',
            'class' => 'create-invoice-trigger',
            'icon' =>'<i class="glyphicon glyphicon-plus"></i>'
        ]
    ]])

    @include('errors._form-errors')

    <div class="row">
        <div class="col-sm-12">
            <div class="custom-panel">
                <div class="custom-panel-heading">Invoices</div>
                
                @include('Invoices::invoices._table')

            </div>
        </div>
    </div>
    
    @include('Invoices::invoices._modal_create')
@stop