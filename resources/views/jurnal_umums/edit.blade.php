@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Edit Jurnal

@stop
@section('page-title') 
<h2>Edit Jurnal</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Jurnal</strong>
	  </li>
</ol>
@stop
@section('content') 
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		@include('jurnal_umums.peringatan')
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Edit Jurnal</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						@include('jurnal_umums.templateJurnal', [
							'jurnals' => $ju->jurnalable_type::find($ju->jurnalable_id)->jurnals,
							'count' => count( $ju->jurnalable_type::find($ju->jurnalable_id)->jurnals )
						]);
					</div>
				</div>
				<div class="row">
					<div id="tidakSama" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="alert alert-danger">
							Jumlah Seluruh Kolom Debet dan Seluruh Kolom Kredit harus sama <br />
							Saat ini jumlah debit = <span id="jumlah_debit"></span> <br />
							Saat ini jumlah kredit = <span id="jumlah_kredit"></span>
						</div>
					</div>
				</div>
				  <div class="row">
					{!! Form::open(['url' => 'jurnal_umums/' .$ju->id, 'method' => 'put']) !!}
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit();return false;">Update</button>
								{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
							</div> 
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<a class="btn btn-danger btn-block btn-lg" href="{{ url('generiks') }}">Cancel</a>
						</div>
						{!! Form::textarea('temp', $ju->jurnalable_type::find($ju->jurnalable_id)->jurnals, [
							'class' => 'hide',
							'id' => 'temp',
						]) !!}
					{!! Form::close() !!}
				  </div>
			</div>
		</div>
	</div>
</div>
	

@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		$('#tidakSama').hide();
		function dummySubmit(){
			var data = parse();
			 var debit = 0;
			 var kredit = 0;
			 for (var i = 0; i < data.length; i++) {
				 if(data[i].debit == '1'){
					debit += parseInt( data[i].nilai );
				 }else if( data[i].debit == '0' ) {
					kredit += parseInt( data[i].nilai );
				 }
			 }


			$('#jumlah_debit').html(uang(debit));
			$('#jumlah_kredit').html(uang(kredit));

			 if(debit == kredit){
			 	$('#submit').click();
				$('#tidakSama').hide();  
			 } else {
				$('#tidakSama').show();  
			 }

		}
		function parse(){
			 var data = $('#temp').val();
			 return JSON.parse(data);
		}
		
		function nilaiKeyUp(control){

			 var nilai = $(control).val();
			 var key   = parseInt( $(control).closest('tr').find('.key').html() );
			 nilai     = cleanUang(nilai);

			var data = parse();
			 data[key]['nilai'] = nilai;

			 data = JSON.stringify(data);
			 $('#temp').val(data);
		}
		
		function coaChange(control){
			var key    = parseInt( $(control).closest('tr').find('.key').html() );
			var coa_id = $(control).val();
			var data   = parse();
			data[key]['coa_id'] = coa_id;
			stringify(data);
		}
		function createdAtKeyUp(control){
			var key   = parseInt( $(control).closest('tr').find('.key').html() );
			var timestamp = $(control).val();

			var data = parse();
			data[key]['created_at'] = timestamp;
			data[key]['updated_at'] = timestamp;
			stringify(data);
		}

		function stringify(data){
			data = JSON.stringify(data);
			$('#temp').val(data);
		}
	</script>
@stop

