@extends('layout.master')
@section('title') 
{{ env("NAMA_KLINIK") }} | Belanja Bukan Obat
@stop
@section('page-title') 
 <h2>Supplier</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Belanja Bukan Obat</strong>
      </li>
</ol>
@stop
@section('content') 
@if (Session::has('print'))
<div id="print-struk" class="hide">
</div>
@endif
@if( !isset( $kirim_berkas ) )
	{!! Form::open(['url'=>'pengeluarans', 'method'=> 'post', 'files' => 'true']) !!} 
@else
	{!! Form::open(['url'=>'kirim_berkas/' . $kirim_berkas->id_view. '/inputNota', 'method'=> 'post', 'files' => 'true']) !!} 
@endif
@if( isset($kirim_berkas) )
	{!! Form::text('kirim_berkas_id', $kirim_berkas->id, ['class' => 'form-control hide']) !!}
@endif
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="panelLeft">
                        Belanja Bukan Obat
                    </div>
                    <div class="panelRight">
                        <button class="btn btn-primary btn-block" type="button" data-toggle="modal" data-target="#create_supplier">Supplier tidak ditemukan</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
				@include('suppliers.belanja_bukan_obat_form')
			</div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="alert alert-info">
					<ul>
						<li>Belanja bukan obat Adalah untuk input pembelian obat yang tidak masuk dalam daftar stok barang</li>
						<li>Untuk pembelian / pengeluaran uang yang masuk dalam stok barang contoh : belanja obat pilihannya masuk ke dalam <br /> <a href="{{ url('suppliers/belanja__obat') }}" class="btn btn-info">Belanja Obat</a> </li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			@if(!isset($kirim_berkas))
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			@else
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			@endif
				<div class="panel panel-info">
					<div class="panel-body">
						<div class="form-group{{ $errors->has('faktur_image') ? ' has-error' : '' }}">
							{!! Form::label('faktur_image', 'Upload Gambar Faktur') !!}
							{!! Form::file('faktur_image') !!}
								@if (isset($pengeluaran) && $pengeluaran->faktur_image)
									<p> <img src="{{ \Storage::disk('s3')->url('img/belanja/lain/'.$pengeluaran->faktur_image) }}" alt="" class="img-rounded upload"> </p>
								@else
									<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
								@endif
							{!! $errors->first('faktur_image', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>
			</div>
			@if(isset($kirim_berkas))
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-info">
					<div class="panel-body">
						<div class="form-group{{ $errors->has('foro_berkas_dan_bukti') ? ' has-error' : '' }}">
							{!! Form::label('foto_berkas_dan_bukti', 'Foto Berkas Dan Bukti') !!}
							{!! Form::file('foto_berkas_dan_bukti') !!}
								@if (isset($pengeluaran) && $pengeluaran->foto_berkas_dan_bukti)
									<p> <img src="{{ \Storage::disk('s3')->url('img/belanja/lain/'.$pengeluaran->foto_berkas_dan_bukti) }}" alt="" class="img-rounded upload"> </p>
								@else
									<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
								@endif
							{!! $errors->first('foto_berkas_dan_bukti', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>
			</div>
			@endif
		</div>
    </div>
</div>

{!! Form::close() !!}
@if( !isset( $kirim_berkas ) )
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-title">Daftar Belanja Obat</div>
				</div>
				<div class="panel-body">
					<?php echo $pengeluarans->appends(Input::except('page'))->links(); ?>
					<div class="table-responsive">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th nowrap>Tanggal</th>
									<th>Supplier</th>
									<th>Staf</th>
									<th>Nilai</th>
									<th>Keterangan</th>
									<th colspan="2">Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach($pengeluarans as $peng)
									<tr>
										<td nowrap>{{ $peng->tanggal->format('d-m-Y') }}</td>
										<td>{{ $peng->supplier->nama }}</td>
										<td>{{ $peng->staf->nama }}</td>
										<td class="uang">{{ $peng->nilai }}</td>
										<td>{{ $peng->keterangan }}</td>
										<td> <a class="btn btn-primary btn-xs" href="{{ url("pengeluarans/show/" . $peng->id) }}" target="_blank">Detail</a> </td>
										<td> <a class="btn btn-info btn-xs" href="{{ url("pdfs/pengeluaran/" . $peng->id) }}" target="_blank">Print Struk</a> </td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<?php echo $pengeluarans->appends(Input::except('page'))->links(); ?>
				</div>
			</div>
		</div>
	</div>
@endif
<div class="modal fade" tabindex="-1" role="dialog" id="create_supplier">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Buat Supplier Baru</h4>
      </div>
      <div class="modal-body">
          @include('suppliers.form', ['submit' => 'SUBMIT'])
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
@section('footer') 
<script>
	var base = "{{ url('/') }}";
</script>
<script src="{{ url('js/create_supplier.js') }}"></script>
{{--{!! HTML::script('js/create_supplier_ajax.js')!!} --}}
<script>
  jQuery(document).ready(function($) {
	$('#supplier_submit input[type="submit"]').click(function(){
		$.post('{{ url("suppliers") }}', {
					'nama' : $('#nama_supplier').val(),
					'alamat' : $('#alamat').val(),
					'hp_pic' : $('#hp_pic').val(),
					'no_telp' : $('#no_telp').val()
				}, function (data) {
				data = $.parseJSON(data);
				if(data.confirm == '1'){
					var options = data.options;
					var option = '';
					console.log(data.options);
					for (var i = 0; i < options.length; i++) {
						option += '<option value="' + options[i].value + '">' + options[i].text + '</option>';
					}

					console.log(option);
					$('#supplier_id').html(option).val(data.last_id).selectpicker('refresh');
					$('#create_supplier').modal('hide');
				}
			}
		);
	});
	if( $('#print-struk').length > 0 ){
		window.open("{{ url('pdfs/pengeluaran/' . Session::get('print')) }}", '_blank');
	}
	$('#dummySubmitSupplier').click(function(){
		 if( $('#nama').val() == '' ){
			 validasi('#nama', 'Harus Diisi!!');
		 } else {
			$('#create_supplier input[type="submit"]').click(); 
		 }
	});
  });

  function buy(control){
    var supplier_id = $(control).closest('tr').find('td:first-child').html();
    var supplier_name = $(control).closest('tr').find('td:nth-child(2)').html();

    console.log($(control).attr('data-belanja-obat'));

    $('#tipe_belanja').html($(control).val());
    $('#supplier_id_buy').val(supplier_id);
    $('#supplier_name_buy').html(supplier_name);

    $('#btn_modal').click();
  }

  function dummySub(){

        if (
            $('input[name="tanggal"]').val() == '' ||
            $('input[name="nomor_faktur"]').val() == '' ||
            $('select[name="belanja_id"]').val() == '' ||
            $('input[name="supplier_id"]').val() == '' ||
            $('select[name="staf_id"]').val() == ''

          ) {

            if($('input[name="tanggal"]').val() == '' ) {
              validasi('input[name="tanggal"]', 'Harus Diisi!!');
            } 
            if($('input[name="nomor_faktur"]').val() == '' ) {
              validasi('input[name="nomor_faktur"]', 'Harus Diisi!!');
            } 
            if($('select[name="belanja_id"]').val() == '' ) {
              validasi('select[name="belanja_id"]', 'Harus Diisi!!');
            } 
            if($('input[name="supplier_id"]').val() == '' ) {
              validasi('input[name="supplier_id"]', 'Harus Diisi!!');
            } 
            if($('select[name="staf_id"]').val() == '' ) {
              validasi('select[name="staf_id"]', 'Harus Diisi!!');
            }
        } else {
          var supplier_id = $('#supplier_id_buy').val();
          var nomor_faktur = $('#nomor_faktur_buy').val();

          var param = {
            'supplier_id'  : supplier_id,
            'nomor_faktur' : nomor_faktur,
            '_token' : '{{ Session::token() }}'
          }; 

          $.post('{{ url("suppliers/ajax/ceknotalama") }}', param, function(data, textStatus, xhr) {
            data = $.trim(data);
            if (data == '1') {
              var r = confirm('Sudah ada nomor_faktur dengan supplier yang sama. Anda akan mengedit faktur yang sudah ada. Lanjutkan? Jika mau buat baru tekan Cancel dan ganti nomor_faktur nya');

              if (r) {
                $('#submit').click();
              }
            } else {
              $('#submit').click();
            }
          });
        }
  }
</script>

@stop


