@section('js')
	@parent
	<script type="text/javascript">
		$("{!! $element !!}").select2({
	        width: '100%',
	        ajax: {
	            url: "{!! route('clients.selectjson') !!}",
	            dataType: 'json',
	            delay: 250,
	            data: function (params) {
	                return {
	                    q: params.term,
	                    page: params.page
	                };
	            },
	            processResults: function (data, params) {
	                params.page = params.page || 1;

	                return {
	                    results: data.items,
	                    pagination: {
	                        more: (params.page * 10) < data.total_count
	                    }
	                };
	            },
	            cache: false
	        },
	        escapeMarkup: function (markup) { 
	            return markup; 
	        },  
	        minimumInputLength: 1,
	        templateResult: formatRepo,
	        templateSelection: formatRepoSelection
	    });

	    function formatRepo (response) {
	      if (response.loading) return response.text;

	      var markup =  "<div class='select2-result-repository clearfix'>" +
	                        "<div class='select2-result-repository__meta'>" +
	                            "<div class='select2-result-repository__title'>" + response.name + "</div>" +
	                        "</div>" +
	                    "</div>";

	      return markup;
	    }

	    function formatRepoSelection (response) {
	      return response.name;
	    }
	</script>
@endsection