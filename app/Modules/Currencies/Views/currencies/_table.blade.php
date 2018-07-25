<table class="table table-bordered table-hover" id="taxesList">
    <thead>
        <th>#</th>
        <th>Code</th>
        <th>Name</th>
        <th>Symbol</th>
    </thead>
</table>

@section('js')
    @parent
    <script>
        $(document).ready(function(){

            $('#taxesList').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("currencies.datatable")}}',
                columns: [
                    {data: 0, name: 'id'},
                    {data: 1, name: 'name'},
                    {data: 2, name: 'code'},
                    {data: 3, name: 'symbol'},
                ]
            });
        });
    </script>
@stop