@extends('layouts.default')

@section('content')

    @include('includes._page_actions', ['fields' => [
        'create' => [
            'label' => 'New',
            'url' => route('clients.create'),
            'class' => '',
            'icon' =>'<i class="glyphicon glyphicon-plus"></i>'
        ]
    ]])

    <div class="row">
        <div class="col-sm-12">
            <div class="custom-panel">
                <div class="custom-panel-heading">Clients</div>
                
                <table class="table table-bordered table-hover" id="clientsList">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Active</th>
                        <th>Balance</th>
                        <th>Options</th>
                    </thead>
                </table>

            </div>
        </div>
    </div>
    
@stop

@section('js')

<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function(){

        $('#clientsList').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("clients.datatable")}}',
            columns: [
                {data: 0, name: 'id'},
                {data: 1, name: 'name'},
                {data: 2, name: 'email'},
                {data: 3, name: 'phone'},
                {data: 4, name: 'balance', sortable: false, searchable: false},
                {data: 5, name: 'active'},
                {data: 6, name: 'actions', sortable: false, searchable: false}
            ]
        });
    });
</script>


@stop