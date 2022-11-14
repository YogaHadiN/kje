@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Gaji Dokter

@stop
@section('head') 
    <link href="{!! asset('css/pembelian.css') !!}" rel="stylesheet" media="print">
@stop
@section('page-title') 
<h2>Bayar Dokter</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li>
        <a href="{{ url('stafs')}}">Staf</a>
    </li>
    <li class="active">
        <strong>Gaji Dokter</strong>
    </li>
</ol>

@stop
@section('content') 
    <div class="row">
      <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Pembayaran</div>
            </div>
            <div class="panel-body">
			<h1>Dokter {{ $staf->nama }}</h1>
                {!! Form::open(['url'=>'pengeluarans/bayardokter/bayar', 'method'=> 'post']) !!} 
                    {!! Form::hidden('mulai', $mulai, ['class' => 'form-control']) !!} 
                    {!! Form::hidden('akhir', $akhir, ['class' => 'form-control']) !!} 
                    {!! Form::hidden('tanggal_dibayar', $tanggal_dibayar, ['class' => 'form-control']) !!} 
                <div class="form-group hide">
                    {!! Form::label('staf_id', 'Staf') !!}
                    {!! Form::text('staf_id' , $id, ['class' => 'form-control']) !!}
                </div>
				<div class="form-group @if($errors->has('hutang'))has-error @endif">
					  {!! Form::label('hutang', 'Jasa Dokter', ['class' => 'control-label']) !!}
                    {!! Form::text('hutang' , $total, ['class' => 'form-control', 'readonly' => 'readonly']) !!}
				  @if($errors->has('hutang'))<code>{{ $errors->first('hutang') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('gaji_pokok'))has-error @endif">
				  {!! Form::label('gaji_pokok', 'Pembayaran', ['class' => 'control-label']) !!}
                    {!! Form::text('gaji_pokok', null, ['class' => 'form-control uangInput', 'id' => 'pembayaran']) !!}
				  @if($errors->has('gaji_pokok'))<code>{{ $errors->first('gaji_pokok') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('petugas_id'))has-error @endif">
				  {!! Form::label('petugas_id', 'Petugas', ['class' => 'control-label']) !!}
                    {!! Form::select('petugas_id', App\Models\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'id' => 'pembayaran', 'data-live-search' => 'true']) !!}
				  @if($errors->has('petugas_id'))<code>{{ $errors->first('petugas_id') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('sumber_uang_id'))has-error @endif">
				  {!! Form::label('sumber_uang_id', 'Sumber Uang', ['class' => 'control-label']) !!}
                  {!! Form::select('sumber_uang_id', App\Models\Classes\Yoga::sumberuang(), null, ['class' => 'form-control', 'id' => 'pembayaran']) !!}
				  @if($errors->has('sumber_uang_id'))<code>{{ $errors->first('sumber_uang_id') }}</code>@endif
				</div>
                <div class="form-group">
                    <button class="btn btn-success" type="button" onclick="submitPage();return false;">Submit</button>
                    {!! Form::submit('Bayar', ['class' => 'btn btn-success hide', 'id'=>'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
      </div>
	  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	  	<div class="panel panel-info">
	  		<div class="panel-body">
				@if(empty( trim( $staf->npwp ) ))
					<div class="alert alert-danger">
						Dokter yang tidak punya Npwp akan dikalikan pph nya 20 % dari pada yang punya npwp, pastikan dokter punya npwp dan rubah dulu di staf edit bila memang punya npwp
					</div>
				@endif
	  		</div>
	  	</div>
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">
					<div class="panelLeft">
						Data Staf 
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<tbody>
							<tr>
								<td>Nama</td>
								<td>{{ $staf->nama }}</td>
							</tr>
							<tr>
								<td>Npwp</td>
								<td>{{ $staf->npwp }}</td>
							</tr>
							<tr>
								<td>Menikah</td>
								<td>{{ $staf->status_pernikahan }}</td>
							</tr>
							<tr>
								<td>Jumlah Anak</td>
								<td>{{ $staf->jumlah_anak }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	  </div>
    </div>
	{!! Form::text('npwp', trim( $staf->npwp ), ['class' => 'form-control hide', 'id' => 'npwp']) !!}
    <div id="content-print">
        <h1>
            Pembayaran Jasa Dokter 
        </h1>
        <hr>
        <div class="box">
            <table>
                <tbody>
                    <tr>
                        <td>Tanggal Mulai</td>
                        <td>{{ $mulai }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Akhir</td>
                        <td>{{ $akhir }}</td>
                    </tr>
                    <tr>
                        <td>Nama Dokter</td>
						<td>{{ $staf->nama }}</td>
                    </tr>
                    <tr class="border-top">
                        <td>Total</td>
                        <td>
                            <h2 id="pembayaranDokter">
                                <!--pembayaran goes here-->
                            </h2>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            Diserahkan pada <span id="tanggal"></span> jam <span id="jam"></span>
			<div class="table-responsive">
				<table class="table-center">
					<tbody>
						<tr class="border-top">
							<td>Diserahkan Oleh</td>
							<td>Diterima Oleh</td>
						</tr>
						<tr class="tanda-tangan">
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>( ............. )</td>
							<td>{{ $staf->nama }}</td>
						</tr>
					</tbody>
				</table>
			</div>
        </div>
        <div class="small-padding">

        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>
					Dokter : {{ $staf->nama }}
                    </h3>
                </div>
                <div class="panelRight">
                    <h3>
                        Tanggal : {{ $mulai }} s/d {{ $akhir }} 
                    </h3>
                </div>
            </div>
        </div>
        <div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover " id="tableAsuransi">
					<thead>
						<tr>
							<th>No</th>
							<th>ID</th>
							<th>Tanggal</th>
							<th>Nama Pasien</th>
							<th>Asuransi</th>
							<th>Transaksi</th>
							<th>Jasa Dokter</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($hutangs as $k => $hutang)
							<tr>
								<td>{!! $k + 1 !!}</td>
								<td>
									pasien_id : {!! $hutang->pasien_id !!} <br />
									periksa_id : {!! $hutang->id !!} <br />
								</td>
								<td>{!! App\Models\Classes\Yoga::updateDatePrep( $hutang->tanggal  )!!}</td>
								<td>{!! $hutang->pasien->nama !!}</td>
								<td>{!! $hutang->asuransi->nama !!}</td>
								<td>
								   <table class="table table-condensed">
									   <thead>
										   <tr>
											   <th class="text-center">Jenis Transaksi</th>
											   <th class="text-center"></th>
											   <th class="text-center">Biaya</th>
										   </tr>
									   </thead>
									   <tbody>
										   {!! $hutang->tindakan_html !!}
									   </tbody>
								   </table> 
								</td>
								<td class="uang">{!! $hutang->hutang_dokter !!}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4" class="text-right"><h2>Total</h2></td>
							<td colspan="3" class="bold"><h2 class="uang">{{ $total }}</h2></td>
						</tr>
					</tfoot> 
				</table>
			</div>
        </div>
    </div>
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
    function testPrint(){
       var pembayaran = $('#pembayaran').val(); 
       $('#pembayaranDokter').html(uang( pembayaran ));
       $('#tanggal').html(date()); 
       $('#jam').html(time()); 
    }
    
    function submitPage(){
        if(validatePass()){
			if( $('#npwp').val() == '' ){
				var r = confirm('Dokter ini tidak memiliki NPWP, maka akan diberlakukan tarif maksimal pph21, Apa Anda yakin mau melanjutkan?');
				if( r ){
					$('#submit').click();
				}
				return false;
			} else {
				$('#submit').click();
			}
        }
    }
</script>
@stop


