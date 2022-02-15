@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Gabungkan Pasien Dobel
@stop
@section('page-title') 
<h2>Gabungkan Pasien Dobel</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Gabungkan Pasien Dobel</strong>
	  </li>
</ol>

@stop
@section('head') 

    <link href="{!! asset('js/select2/dist/css/select2.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/select2-bootstrap-theme/dist/select2-bootstrap.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/select2Ajax.css') !!}" rel="stylesheet">
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Pasien 1</div>
				</div>
				<div class="panel-body">
					<div class="form-group @if($errors->has('pasien_id'))has-error @endif">
						<select class="js-data-example-ajax form-control">
						</select>
					  @if($errors->has('pasien_id'))<code>{{ $errors->first('pasien_id') }}</code>@endif
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<div class="panel-title">Pasien 2</div>
				</div>
				<div class="panel-body">
					<div class="form-group @if($errors->has('pasien_id'))has-error @endif">
						<select class="js-data-example-ajax form-control">
						</select>
					  @if($errors->has('pasien_id'))<code>{{ $errors->first('pasien_id') }}</code>@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
	
{!! HTML::script('js/select2/dist/js/select2.min.js')!!}
	<script type="text/javascript" charset="utf-8">
		var base = "{{ url('/') }}";
		$(".js-data-example-ajax").select2({
			  ajax: {
					url: base + "/pasiens/gabungkan/pasien/ganda/select",
					dataType: 'json',
					placeholder: 'Pilih Pasien',
					delay: 250,
					id: function(data){ return data.id },
					data: function (params) {
						  return {
								q: params.term, // search term
								page: params.page
						  };
					},
					processResults: function (data, params) {
						  // parse the results into the format expected by Select2
						  // since we are using custom formatting functions we do not need to
						  // alter the remote JSON data, except to indicate that infinite
						  // scrolling can be used
						  params.page = params.page || 1;

						  return {
								results: data.items,
								pagination: {
								  more: (params.page * 30) < data.total_count
								}
						  };
					},
					cache: true
			  },
			  escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
			  minimumInputLength: 3,
			  multiple: false,
			  templateResult: formatRepo, // omitted for brevity, see the source of this page
			  templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
		});	

		function formatRepo (repo) {
			  if (repo.loading) return repo.text;

			  var markup = "<div class='select2-result-repository clearfix'>" +
				"<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
				"<div class='select2-result-repository__meta'>" +
				  "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

			  if (repo.description) {
					markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
			  }

			  markup += "<div class='select2-result-repository__statistics'>" +
   				"<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + "</div>" +
   				"<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + "</div>" +
   				"<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + "</div>" +
				  "</div>" +
				  "</div></div>";

			  return markup;
		}

		function formatRepoSelection (repo) {
		  return repo.full_name || repo.text;
		}
	</script>
@stop

