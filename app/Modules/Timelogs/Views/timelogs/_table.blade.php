<table class="table table-bordered table-hover" id="projectsList">
    <thead>
        <th>#</th>
        <th>Employee</th>
        <th>Project</th>
        <th>Hours</th>
        <th>Date</th>
        <th>Options</th>
    </thead>
</table>

@section('js')
    @parent
    <script>
        $(document).ready(function(){

            var table = $('#projectsList').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("timelogs.datatable")}}',
                order: [[ 0, "desc" ]],
                columns: [
                    {data: 0, name: 'id'},
                    {data: 1, name: 'user_id'},
                    {data: 2, name: 'project_id'},
                    {data: 3, name: 'total'},
                    {data: 4, name: 'date'},
                    {data: 5, name: 'actions', sortable: false, searchable: false}
                ]
            });
        });
    </script>
@stop