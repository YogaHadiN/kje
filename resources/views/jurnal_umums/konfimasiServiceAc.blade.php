@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Konfimasi Service Ac
@stop
@section('page-title') 
<h2>Konfimasi Service Ac</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Konfimasi Service Ac</strong>
	  </li>
</ol>
@stop
@section('content') 
{!! Form::open(['url' => 'service_ac/konfirmasi', 'method' => 'post']) !!}
	
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="alert alert-danger">
			<ul>
				<li>Sebelum melanjutkan Anda harus menentukan dulu Service Ac yang sudah dilakukan dan keterangan kerusakan</li>
				<li>Klik Gambar Untuk memperbesar Gambar Nota Agar lebih jelas</li>
			</ul>
			
		</div>
	</div>
</div>
@foreach( $faktur_belanjas as $fb )
	@include('jurnal_umums.konfimasiForm', ['ikhtisar' => 'service_ac'])
@endforeach
<div class="row" id="danger_row" style="display:none;">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="alert alert-danger" id="danger_alert">
			
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<button class="btn btn-success btn-block btn-lg" type="button" onclick='dummySubmit();return false;'>Submit</button>
		{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<a class="btn btn-danger btn-block btn-lg" href="{{ url('laporans') }}">Cancel</a>
	</div>
</div>
{!! Form::text('route', $route, ['class' => 'form-control hide']) !!}
{!! Form::close() !!}
@stop
@section('footer') 
{!! HTML::script('js/notReady.js')!!}
<script type="text/javascript" charset="utf-8">
$('.temp').val('[]');
function dummySubmit(){
	var keterangan_false = [];
	$('.temp').each(function(){
		sama = true;
		var keterangan = $.trim( $(this).closest('.panel').find('.keterangan').html() );
		var temp       = parseTemp(this);
		if( temp.length < 1 ){
			sama = false;
			keterangan_false.push('Keterangan Service Ac ' + keterangan + ' belum diisi');
		}
	});
	console.log('sama = ');
	console.log(sama);
	if( sama == false ){
		var text = '<p>Terdapat kesalahan berikut ini </p>';
		text += '<ul>';
		 for (var i = 0; i < keterangan_false.length; i++) {
			text += '<li>' +keterangan_false[i]+ '</li>';
		 }
		text += '</ul>';
		$('#danger_row').show();
		$('#danger_alert').html(text);
		return false;
	}
	if( validatePass() ){
		console.log('passed');
		$('#submit').click();
	} else {
		console.log('not passed');
	}
}

function inp(control){
	var datas = tempData(control);
	var pg_id          = datas.pg_id;
	var sumber_uang_id = datas.sumber_uang_id;
	var tanggal        = datas.tanggal;
	var staf_id        = datas.staf_id;
	var supplier_id    = datas.supplier_id;
	var faktur_image   = datas.faktur_image;
	var created_at     = datas.created_at;
	var temp           = datas.temp;

	var ac_id       = $(control).closest('tr').find('.ac_id').val();
	var ac_id_text       = $(control).closest('tr').find('.ac_id option:selected').text();
	var kerusakan    = $(control).closest('tr').find('.kerusakan').val();

	if( ac_id == '' || kerusakan == '' ){
		var textAlert = '';
		if( ac_id == '' ){
			textAlert += 'AC yang rusak, '
		}
		if( kerusakan == '' ){
			textAlert += 'keterangan kerusakan '
		}
		textAlert += 'harus diisi !'
		alert(textAlert);
		$(control).closest('table').find('.ac_id').focus();
		return false;
	}
	temp[temp.length]= {
		'pg_id':          pg_id,
		'ac_id':      ac_id,
		'kerusakan':   kerusakan,
		'sumber_uang_id': sumber_uang_id,
		'staf_id':        staf_id,
		'tanggal':        tanggal,
		'faktur_image':        faktur_image,
		'ac_id_text':     ac_id_text,
		'supplier_id':    supplier_id,
		'created_at':     created_at
	}
	stringify(temp, control);
}
function view(control){
	var temp = parseTemp(control);
	var arr = '';
	if( temp.length < 1 ){
		arr += '<tr>';
		arr += '<td colspan="4" class="text-center"> Tidak ada data untuk ditampilikan</td>';
		arr += '</tr>';
	} else {
		 for (var i = 0; i < temp.length; i++) {
			arr += '<tr>';
			arr += '<td>' + temp[i].ac_id_text + '</td>';
			arr += '<td>' + temp[i].kerusakan+ '</td>';
			arr += '<td> <button class="btn btn-danger btn-xs btn-block" type="button" onclick="rowDel(this);return false;">delete</button> </td>';
		 }
		arr += '</tr>';
	}
	$(control).closest('table').find('tbody').html(arr);
	$(control).closest('table').find('.ac_id').focus();
}
</script>

@stop
