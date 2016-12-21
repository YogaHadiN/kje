@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Transaksi Periksa

@stop
@section('page-title') 
<h2>Edit Transaksi Periksa</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Transaksi Periksa</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Edit Transaksi Periksa</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>id</th>
							<th>Jenis Tarif</th>
							<th>Biaya</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($tra->count() > 0)
							@foreach($tra as $t)
								<tr>
									<td class='id'>{{ $t->id }}</td>
									<td class='jenis_tarif'>{{ $t->jenisTarif->jenis_tarif }}</td>
									<td class='biaya'>{{ $t->biaya }}</td>
									<td class='action'>
										<a class="btn btn-warning btn-xs btn-block" href="#" onclick="rowEdit(this);return false;">Edit</a>
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td class="text-center" colspan="4">Tidak Ada Data Untuk Ditampilkan :p</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
	function rowEdit(control){
		 var $id = $(control).closest('tr').find('.id');
		 var $jenis_tarif = $(control).closest('tr').find('.jenis_tarif');
		 var $biaya = $(control).closest('tr').find('.biaya');
		 var $action = $(control).closest('tr').find('.action');
		 var biaya = $biaya.html();
		 var temp = '<input type="text" class="form-control" value="' + biaya + '">'
			 temp += '<span class="hide biayaOld">' + biaya + '</span>';
		 $biaya.html(temp);
		 var tempAction = '<a class="btn btn-info btn-xs btn-block" href="#" onclick="rowUpdate(this);return false;">Update</a> ';
		 tempAction += '<a class="btn btn-danger btn-xs btn-block" href="#" onclick="rowCancel(this);return false;">Cancel</a> ';
		 $action.html(tempAction);
	}

	function rowCancel(control){
		var biayaOld = $(control).closest('tr').find('.biayaOld').html();
		retrieve(control, biayaOld);
	}

	function rowUpdate(control){
		 
		 var $id = $(control).closest('tr').find('.id');
		 var $jenis_tarif = $(control).closest('tr').find('.jenis_tarif');
		 var $biaya = $(control).closest('tr').find('.biaya');
		 var $action = $(control).closest('tr').find('.action');

		 var param = {
			  'id' : $id.html(),
			  'nilai' : $biaya.find('input').val(),
		 }
		 $.post('{{url("periksas/" . $tra[0]->periksa_id . '/update/transaksiPeriksa')}}', param, function(data) {
			 data = $.trim(data);
			 retrieve(control, data);
		 });
	}
	function retrieve(control, biayaOld){
		 var $id = $(control).closest('tr').find('.id');
		 var $jenis_tarif = $(control).closest('tr').find('.jenis_tarif');
		 var $biaya = $(control).closest('tr').find('.biaya');
		 var $action = $(control).closest('tr').find('.action');
		$biaya.html(biayaOld);
		var action = '<a class="btn btn-warning btn-xs btn-block" href="#" onclick="rowEdit(this);return false;">Edit</a>';
		$action.html(action);
	}
	
	






</script>
	
@stop
	
