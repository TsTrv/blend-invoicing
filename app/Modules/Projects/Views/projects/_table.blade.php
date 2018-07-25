<table class="table table-bordered table-hover" id="projectsList">
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Description</th>
        <th>Client</th>
        <th>Options</th>
    </thead>
</table>

@section('js')
    @parent
    <script>
        $(document).ready(function(){

            $('#projectsList').DataTable({
                    "bServerSide": true,
                    "bProcessing": true,
                    "sAjaxSource": "{{ route('projects.datatable') }}",
                    "aoColumns": [
                        {data: 0, name: 'id', "sWidth": "10%"},
                        {data: 1, name: 'name', "sWidth": "30%"},
                        {data: 2, name: 'description', "sWidth": "40%"},
                        {data: 3, name: 'client_id', sortable: false, searchable: false, "sWidth": "20%" },
                        {data: 4, name: 'actions', sortable: false, searchable: false, "sWidth": "10%"}
                    ]
            });
        });
    </script>
@stop