
 @extends('layout.master')

 @section('title') 
Klinik Jati Elok | Daftarkan Supplier

 @stop
 @section('head')
    <style>
        .nav-tabs li {
          width:50%;
        }
    </style>
 @stop
 @section('page-title') 
 <h2>Daftarkan Supplier</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('suppliers')}}">Supplier</a>
      </li>
      <li class="active">
          <strong>Buat Akun Coa Baru</strong>
      </li>
</ol>
 @stop
 @section('content') 
 {!! Form::open(['url' => 'coas', 'method' => 'post']) !!}
	 <div class="panel panel-success">
	 	<div class="panel-heading">
	 		<div class="panel-title">Buat Coa Baru</div>
	 	</div>
	 	<div class="panel-body">
			 <div class="row">
				 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					 <div class="form-group">
						 {!! Form::label('kelompok_coa_id', 'Kelompok Coa') !!}
						 {!! Form::select('kelompok_coa_id', $kelompokCoaList, null, [
							 'class' => 'form-control form-coa rq' , 
							 'id' => 'kelompok_coa_id',
							 'onchange' => 'kelompok_coa_change(this);return false'
						 ]) !!}
					 </div>
				 </div>
				 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					 <div class="form-group">
						 {!! Form::label('coa_id', 'Kode Coa') !!}
						 {!! Form::text('coa_id' , null, [
							 'class' => 'form-control form-coa rq', 
							 'id'=>'kode_coa', 
							 'disabled' => 'disabled',
							 'onkeyup' => 'kode_coa_keyup(); return false'
						 ]) !!}
					 </div>
				 </div>
			 </div>
			 <div class="row">
				 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					 <div class="form-group">
						 {!! Form::label('coa', 'Keterangan Coa') !!}
						 {!! Form::text('coa' , null, ['class' => 'form-control form-coa rq', 'id'=>'keterangan_coa', 'disabled' => 'disabled']) !!}
					 </div>
				 </div>
			 </div>
			 <div class="row">
				 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					 <button class="btn btn-success btn-block" type="button" id="submit_coa" onclick="submitCoa();return false;">Submit</button>
					 <button class="hide" type="submit" id="submit">Submit</button>
				 </div>
				 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					 <button class="btn btn-danger btn-block" type="button" id="cancel_coa" onclick=" $('#coa_baru').modal('hide');return false;">Cancel</button>
				 </div>
			 </div>
	 	</div>
	 </div>
 {!! Form::close() !!}
 @stop
 @section('footer') 
	 <script src="{{ url('js/create_supplier.js') }}"> </script>
	 <script type="text/javascript" charset="utf-8">
	var akun_oke = false;
	 	$(function () {
			kelompok_coa_change();
	 	});
		function kelompok_coa_change(){
			var kelompok_coa_id = $('#kelompok_coa_id').val();
			if(kelompok_coa_id != ''){
				$('#kode_coa')
					.val(kelompok_coa_id)
					.removeAttr('disabled');
			} else {
				$('#kode_coa')
					.val( '' )
					.prop('disabled', 'disabled');
			}
		}

		function kode_coa_keyup(){

			var kelompok_coa_id = $('#kelompok_coa_id').val();
			var kode_coa_id = $('#kode_coa').val();
			var arr = kode_coa_id.split('');

			 if(kelompok_coa_id.length == 1){
				 if(arr[0] != kelompok_coa_id){
					 $('#kode_coa').val(kelompok_coa_id);
				 }
			 }
			 if(kelompok_coa_id.length == 2){
				 if(arr[0] + arr[1] != kelompok_coa_id){
					 $('#kode_coa').val(kelompok_coa_id);
				 }
			 }

			 $.post('{{ url("coas/cek_coa_sama") }}',
				{ 'kode_coa_id': $('#kode_coa').val() },
				function (data) {
					data = $.trim(data);
					if(data == '1'){
						$('#kode_coa').closest('div')
							.append('<code>Sudah Ada Kode Akun Yang Sama</code>')
							.addClass('has-error');
						akun_oke = false;
						alert(akun_oke);
					} else {
						akun_oke = true;
					}
				}
			 );

			 if(kode_coa_id.length > 5 && akun_oke == true){
				$('#keterangan_coa').removeAttr('disabled');
			 } else {
				$('#keterangan_coa')
					.val('')
					.prop('disabled', 'disabled');
			 }
		}
		function submitCoa(){
			 if(validatePass()){
				$('#submit').click();
			 }
		}




	 </script>
 @stop


       
