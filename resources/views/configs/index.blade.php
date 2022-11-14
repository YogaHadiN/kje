@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Pengaturan

@stop
@section('head') 
<style type="text/css" media="all">
table tr td:first-child {
	width:20%
}

table tr td:nth-child(2) {
	width:65%
}

table tr td:nth-child(3) {
	width:15%
}
</style>
@stop
@section('page-title') 
<h2>Pengaturan</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Pengaturan</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">
						<div class="panel-left">
							Pengaturan
						</div>
						<div class="panel-right">
							<a href="{{ url('configs/create') }}"  class="btn btn-primary">Buat Pengaturan Baru</a>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>Jenis Pengaturan</th>
									<th>Nilai</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if($configs->count() > 0)
									@foreach($configs as $config)
										<tr>
											<td class="config_variable">{{ $config->config_variable }}</td>
											<td class="value">{{ $config->value }}</td>
											<td> <button class="btn btn-warning btn-xs" type="button" onclick="rowEdit(this);return false;">Edit</button> </td>
										</tr>
									@endforeach
								@else
									<tr>
										<td class="text-center" colspan="2">Tidak Ada Data Untuk Ditampilkan :p</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
			
		</div>
	</div>
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
	function rowEdit(control){
		 var $tr = $(control).closest('tr');
		 var config_variable = $tr.find('.config_variable').html();
		 var value = $tr.find('.value').html();
		 var temp = '';
		 temp += '<td class="config_variable">' + config_variable + '</td>';
		 temp += '<td> <textarea class="form-control textareacustom value" > ' + value + '</textarea></td>';
		 temp += '<td class="hide"><input type="text" class="form-control value_before" value="' + value + '" /></td>';
		 temp += '<td nowrap> <button class="btn btn-info btn-xs" type="button" onclick="rowUpdate(this);return false"> Update</button> &nbsp;<button class="btn btn-danger btn-xs" type="button" onclick="rowCancel(this);return false">Cancel</button></td>';
		 $tr.html(temp);
	}
	function rowCancel(control){
		 var $tr = $(control).closest('tr');
		 var config_variable = $tr.find('.config_variable').html();
		 var value = $tr.find('.value_before').val();
		 var temp = '';
		 temp += '<td class="config_variable">' + config_variable + '</td>';
		 temp += '<td class="value">'+ value +'</td>';
		 temp += '<td> <button class="btn btn-warning btn-xs" type="button" onclick="rowEdit(this);return false;">Edit</button> </td>';
		 $tr.html(temp);
	}

	function rowUpdate(control){
		 var $tr = $(control).closest('tr');
		 var config_variable = $tr.find('.config_variable').html();
		 var value = $tr.find('.value').val();

		 console.log(value);

		 var param = { 
			 'config_variable' : config_variable,
			 'value' : value
		 };

		 $.post('{{ url("configs/update") }}', param, function(data) {
			 var temp = '';
			 temp += '<td class="config_variable">' + config_variable + '</td>';
			 temp += '<td class="value">'+ data +'</td>';
			 temp += '<td> <button class="btn btn-warning btn-xs" type="button" onclick="rowEdit(this);return false;">Edit</button> </td>';
			 $tr.html(temp);
		 });
	}
	
	
	
	

	
	
</script>
	
@stop

