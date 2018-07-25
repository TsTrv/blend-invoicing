<table class="table table-bordered table-hover" id="quotesList">
    <thead>
        <th>Quote #</th>
        <th>Date</th>
        <th>Due Date</th>
        <th>Client</th>
        <th>Total</th>
        <th>Status</th>
        <th>Options</th>
    </thead>
</table>

@php
    $filter = isset($client_id) ? ['client_id' => $client_id] : null;
@endphp

@section('js')
    @parent
    <script>
        $(document).ready(function(){

            $('#quotesList').DataTable({
                    "bServerSide": true,
                    "bProcessing": true,
                    "sAjaxSource": "{{ route('quotes.datatable', $filter) }}",
                    "aoColumns": [
                        {data: 0, name: 'number', "sWidth": "10%"},
                        {data: 1, name: 'issued_date', "sWidth": "10%"},
                        {data: 2, name: 'due_date', "sWidth": "10%"},
                        {data: 3, name: 'client_id', sortable: false, searchable: false, "sWidth": "25%" },
                        {data: 4, name: 'total', "sWidth": "10%"},
                        {data: 5, name: 'status_id', "sWidth": "5%"},
                        {data: 6, name: 'actions', sortable: false, searchable: false, "sWidth": "10%"}
                    ]
            });
        });
    </script>
@stop