@extends('layouts.default')

@section('content')

	@include('includes._page_actions', ['fields' => [
        'edit' => [
            'label' => 'Edit',
            'url' => route('employees.edit', $employee->id),
            'class' => '',
            'icon' =>'<i class="glyphicon glyphicon-edit"></i>'
        ]
    ]])

	<div class="row">
	    <div class="col-sm-12">
	        <div class="custom-panel">
	            <div class="custom-panel-heading">{!! $employee->name !!}</div>

				<div class="tab-content clearfix">
				  	<div class="tab-pane active" id="client-details">
			          	<table class="table table-striped">
			          		<tbody>
				          		<tr>
				          			<td>Name</td>
				          			<td>{!! $employee->name !!}</td>
				          		</tr>

				          		<tr>
				          			<td>Role</td>
				          			<td>{!! $employee->roles_formatted !!}</td>
				          		</tr>

				          		<tr>
				          			<td>Email</td>
				          			<td>{!! $employee->email !!}</td>
				          		</tr>
				   
							</tbody>
			          	</table>
					</div>
			      
				</div>

	        </div>
	    </div>
	</div>

@endsection