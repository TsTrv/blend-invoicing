@extends('layouts.default')

@section('content')
	
	@include('includes._page_actions', ['fields' => [
        'create' => [
            'label' => 'New',
            'url' => route('projects.create'),
            'class' => '',
            'icon' =>'<i class="glyphicon glyphicon-plus"></i>'
        ]
    ]])

    <div class="row">
        <div class="col-sm-12">
            <div class="custom-panel">
                <div class="custom-panel-heading">Projects</div>

                @include('Projects::projects._table')

            </div>
        </div>
    </div>

@stop