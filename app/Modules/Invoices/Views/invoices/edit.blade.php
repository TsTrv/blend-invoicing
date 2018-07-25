@extends('layouts.default')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="custom-panel">
            <div class="custom-panel-heading">Invoice #{{ $invoice->number }} 
            	<div class="pull-right">
            		<a href="{{ route('invoices.pdf.view', [$invoice->id, 'download']) }}"><i class="glyphicon glyphicon-file"></i></a>
            	</div>
            </div>
            {!! Form::model($invoice, ['method' => 'PUT', 'route' => ['invoices.update', $invoice->id], 'class' => 'form-horizontal update-invoice-form']) !!}

                @include('Invoices::invoices._form')

            {!! Form::close() !!}
        </div>
    </div>
</div>

@stop