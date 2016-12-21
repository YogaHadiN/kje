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
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
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
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<div class="panel-title">Edit Tunai / Piutan</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Pembayaran</th>
								<th>Nilai</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td> Tunai </td>
								<td id="tunai">{{ $periksa->tunai }}</td>
								<td> <a class="btn btn-xs btn-warning btn-block" href="#" value="{{ $periksa->id }}" onclick="rowEditTunai(this);return false;">Edit</a> </td>
							</tr>
							<tr>
								<td>Piutang</td>
								<td id="piutang">{{ $periksa->piutang }}</td>
								<td> <a class="btn btn-xs btn-warning btn-block"  value="{{ $periksa->id }} "href="#" onclick="rowEditPiutang(this);return false;">Edit</a> </td>
							</tr>
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

	function rowCancelTunai(control){
		var old = $(control).closest('tr').find('.biayaOld').html();
		tempDelete(control, 'tunai', old);
	}
	function rowCancelPiutang(control){
		var old = $(control).closest('tr').find('.biayaOld').html();
		tempDelete(control, 'piutang', old);
	}

	function rowEditTunai(control){
		tempJenis(control, 'tunai');
	}

	function rowEditPiutang(control){
		tempJenis(control, 'piutang');
	}

	function rowUpdateTunai(control){
		tempUpdate(control, 'tunai');
	}

	function rowUpdatePiutang(control){
		tempUpdate(control, 'piutang');
	}
	
	function tempDelete(control, tempo, old){
		 $('#' + tempo).html(old);
		 var action = '<a class="btn btn-warning btn-xs btn-block" href="#" onclick="rowEdit' + sentenceCase(tempo)+ '(this);return false;">Edit</a>';
		 $(control).closest('td').html(action);
	}
	function tempUpdate(control, tempo){
		var tunai = $('#' + tempo).find('input').val();
		var param = {
			 'nilai':tunai
		};
		$.post('{{ url("periksas/" . $periksa->id . '/update') }}' + '/' + tempo, param, function(data) {
			 data = $.trim(data);
			tempDelete(control, tempo, data);
		});
	}
	
	
	
	


	
	
function tempJenis(control, temp){
		var tunai = $('#' + temp).html();
		 var tempo = '<input type="text" class="form-control" value="' + tunai + '">'
			 tempo += '<span class="hide biayaOld">' + tunai + '</span>';
		 $('#' + temp).html(tempo);
		var tempAction = '<a class="btn btn-info btn-xs btn-block" href="#" onclick="rowUpdate' + sentenceCase(temp)+  '(this);return false;">Update</a> ';
		tempAction += '<a class="btn btn-danger btn-xs btn-block" href="#" onclick="rowCancel' + sentenceCase(temp)+  '(this);return false;">Cancel</a> ';
		$(control).closest('td').html(tempAction);
}

function sentenceCase(str)
{
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}
	






</script>
	
@stop
	
