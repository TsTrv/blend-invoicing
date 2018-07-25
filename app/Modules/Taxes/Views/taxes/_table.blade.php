<table class="table table-bordered table-hover" id="taxesList">
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Percent</th>
    </thead>
</table>

@section('js')
    @parent
    <script>
        $(document).ready(function(){

            $('#taxesList').DataTable({
                    "bServerSide": true,
                    "bProcessing": true,
                    "sAjaxSource": "{{ route('taxes.datatable') }}",
                    "aoColumns": [
                        {data: 0, name: 'id', "sWidth": "10%"},
                        {data: 1, name: 'name', "sWidth": "50%"},
                        {data: 2, name: 'percent', "sWidth": "40%"}
                    ]
            });
        });
    </script>
@stop