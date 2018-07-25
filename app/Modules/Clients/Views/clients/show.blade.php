@extends('layouts.default')

@section('content')

    @include('includes._page_actions', ['fields' => [
    	'delete' => [
            'label' => 'Delete',
            'url' => route('clients.delete', $client->id),
            'class' => 'btn-danger',
            'icon' =>'<i class="glyphicon glyphicon-remove"></i>'
        ],
        'edit' => [
            'label' => 'Edit',
            'url' => route('clients.edit', $client->id),
            'class' => '',
            'icon' =>'<i class="glyphicon glyphicon-edit"></i>'
        ]
    ]])

	<div class="row">
	    <div class="col-sm-12">
	        <div class="custom-panel">
	            <div class="custom-panel-heading">{!! $client->name !!}</div>
	            
	            <ul  class="nav nav-pills">
					<li class="active"><a  href="#client-details" data-toggle="tab">Details</a></li>
					<li><a href="#client-invoices" data-toggle="tab">Invoices</a></li>
					<li><a href="#client-quotes" data-toggle="tab">Quotes</a></li>
				</ul>

				<div class="tab-content clearfix">
				  	<div class="tab-pane active" id="client-details">
			          	<table class="table table-striped">
			          		<tbody>
				          		<tr>
				          			<td>Address</td>
				          			<td>{!! $client->address !!}</td>
				          		</tr>
				          		<tr>
				          			<td>Email</td>
				          			<td>{!! $client->email !!}</td>
				          		</tr>
				          		<tr>
				          			<td>Phone</td>
				          			<td>{!! $client->phone !!}</td>
				          		</tr>
				          		<tr>
				          			<td>Web</td>
				          			<td><a href="{!! $client->web !!}" target="_blank">{!! $client->web !!}</a></td>
				          		</tr>
				          		<tr>
				          			<td>Status</td>
				          			<td>{!! $client->active_formatted !!}</td>
				          		</tr>
							</tbody>
			          	</table>
					</div>
					
					<div class="tab-pane" id="client-invoices">
                		@include('Invoices::invoices._table', ['client_id' => $client->id])
					</div>

			        <div class="tab-pane" id="client-quotes">
                		@include('Quotes::quotes._table', ['client_id' => $client->id])
					</div>
			      	
				</div>

	        </div>
	    </div>
	</div>
@endsection

@section('js')


@endsection
