@extends('layout.master')
@section('title') 
Klinik Jati Elok | Belanja Bukan Obat
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
{!! Form::open(['url'=>'pengeluarans', 'method'=> 'post', 'files' => 'true']) !!} 
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="panelLeft">
                        Belanja Bukan Obat
                    </div>
                    <div class="panelRight">
                        <button class="btn btn-primary btn-block" type="submit" data-toggle="modal" data-target="#create_supplier">Supplier tidak ditemukan</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                    {!! Form::text('belanja_id', 3, ['class' => 'hide']) !!} 
                    <div class="form-group">
                      {!! Form::label('supplier_id', 'Supplier') !!}
                      {!! Form::select('supplier_id', App\Classes\Yoga::supplierList(), null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
                    </div>
					<div class="form-group">
                      {!! Form::label('staf_id', 'Petugas') !!}
                      {!! Form::select('staf_id', App\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
                    </div>
					<div class="form-group" @if($errors->has('sumber_uang')) class="has-error" @endif>
					  {!! Form::label('sumber_uang', 'Sumber Uang') !!}
					  {!! Form::select('sumber_uang' , $sumber_uang, null, ['class' => 'form-control']) !!}
					  @if($errors->has('sumber_uang'))<code>{{ $errors->first('sumber_uang') }}</code>@endif
					</div>
                    <div class="form-group">
                      {!! Form::label('nilai', 'Nilai') !!}
						<div class="input-group">
                          <div class="input-group-addon">Rp. </div>
                           {!! Form::text('nilai' , null, ['class' => 'form-control rq']) !!}
						</div>
                    </div>
					<div class="form-group" @if($errors->has('tanggal')) class="has-error" @endif)>
					  {!! Form::label('tanggal', 'Tanggal') !!}
					  {!! Form::text('tanggal' , date('d-m-Y'), ['class' => 'form-control tanggal']) !!}
					  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
					</div>
					<div class="form-group">
                      {!! Form::label('keterangan', 'Uangnya Dipakai Buat apa') !!}
                      {!! Form::textarea('keterangan' , null, ['class' => 'form-control textareacustom']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::submit('Belanja Bukan Obat', ['class' => 'btn btn-success btn-block btn-lg']) !!}
                    </div>
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
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="panel panel-info">
					<div class="panel-body">
						<div class="form-group{{ $errors->has('faktur_image') ? ' has-error' : '' }}">
							{!! Form::label('faktur_image', 'Upload Gambar Faktur') !!}
							{!! Form::file('faktur_image') !!}
								@if (isset($pengeluaran) && $pengeluaran->faktur_image)
									<p> {!! HTML::image(asset('img/belanja/lain/'.$pengeluaran->faktur_image), null, ['class'=>'img-rounded upload']) !!} </p>
								@else
									<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
								@endif
							{!! $errors->first('faktur_image', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>
							
			</div>
		</div>
    </div>
</div>

{!! Form::close() !!}
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
								<th>Tanggal</th>
								<th>Supplier</th>
								<th>Staf</th>
								<th>Nilai</th>
								<th>Keterangan</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pengeluarans as $peng)
								<tr>
									<td>{{ $peng->tanggal->format('d-m-Y') }}</td>
									<td>{{ $peng->supplier->nama }}</td>
									<td>{{ $peng->staf->nama }}</td>
									<td class="uang">{{ $peng->nilai }}</td>
									<td>{{ $peng->keterangan }}</td>
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


