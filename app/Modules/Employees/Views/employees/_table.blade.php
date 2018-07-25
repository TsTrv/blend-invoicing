<table class="table table-bordered table-hover" id="employeesList">
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Options</th>
    </thead>
</table>

@section('js')
    @parent
    <script>
        $(document).ready(function(){

            $('#employeesList').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("employees.datatable")}}',
                columns: [
                    {data: 0, name: 'id'},
                    {data: 1, name: 'name'},
                    {data: 2, name: 'email'},
                    {data: 3, name: 'role', sortable: false, searchable: false},
                    {data: 4, name: 'actions', sortable: false, searchable: false},
                ]
            });
        });
    </script>
@stop