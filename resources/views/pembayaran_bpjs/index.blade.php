@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Pendapatan Kapitasi BPJS

@stop
@section('page-title') 
<h2>Pendapatan Kapitasi BPJS</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Pendapatan Kapitasi BPJS</strong>
      </li>
</ol>

@stop
@section('content') 
@if (Session::has('print'))
   <div id="print-struk">
       
   </div> 
@endif
{!! Form::open(['url' => 'pendapatans/pembayaran_bpjs']) !!}
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="panelLeft">Pendapatan Kapitasi BPJS</div>
                </div>
            </div>
            <div class="panel-body">
				
				<div class="form-group @if($errors->has('staf_id'))has-error @endif">
				  {!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
				  {!! Form::select('staf_id', App\Models\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true']) !!}
				  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
				</div>
				
				<div class="form-group @if($errors->has('nilai'))has-error @endif">
					  {!! Form::label('nilai', 'Nilai', ['class' => 'control-label']) !!}
					  {!! Form::text('nilai' , null, ['class' => 'form-control rq uangInput']) !!}
				  @if($errors->has('nilai'))<code>{{ $errors->first('nilai') }}</code>@endif
				</div>
				
				<div class="form-group @if($errors->has('periode_bulan'))has-error @endif">
				  {!! Form::label('periode_bulan', 'Periode Bulan', ['class' => 'control-label']) !!}
				  {!! Form::text('periode_bulan' , date("m-Y",strtotime("-1 month"))  ,['class' => 'form-control bulanTahun rq']) !!}
				  @if($errors->has('periode_bulan'))<code>{{ $errors->first('periode_bulan') }}</code>@endif
				</div>
				<div class="form-group @if($errors->has('tanggal_pembayaran'))has-error @endif">
				  {!! Form::label('tanggal_pembayaran', 'Tanggal Pembayaran') !!}
				  {!! Form::text('tanggal_pembayaran' , date('d-m-Y'), ['class' => 'form-control tanggal rq']) !!}
				  @if($errors->has('tanggal_pembayaran'))<code>{{ $errors->first('tanggal_pembayaran') }}</code>@endif
				</div>
				<div class="form-group">
					<button class="btn btn-success btn-block btn-lg" type="button" onclick="cek_tagihan();">Submit</button>
					{!! Form::submit('Submit Pendapatan Lain-lain', ['class' => 'btn btn-success btn-block btn-lg hide', 'id' => 'submit_form']) !!}
				</div>
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="alert alert-info">
			<h2>Perhatian</h2>
            <p>Formulir ini hanya bisa diisi oleh Pak Yoga</p>
            <p>Pengisian dilakukan setiap bulan</p>
					
        </div>
		<div class="alert alert-danger hide" id="tagihan">
			<h2>Konfirmasikan</h2>
			<p>Konfirmasikan transaksi ini bukan didapat dari pembayaran tagihan asuransi dan perusahaan</p>
			<p>karena masing2 sudah ada form yang berbeda</p>
			{!! Form::hidden('konfirmasikan', '0', ['class' => 'form-control', 'id' => 'konfirmasikan']) !!}
			<br />
			<button class="btn btn-warning btn-lg btn-block" type="button" id="confirm_button" onclick="confirmed();return false;">Konfirmasikan</button>
			<button class="btn btn-primary btn-lg btn-block hide" type="button" id="unconfirm_button" onclick="unconfirmed();return false;">Batalkan Konfirmasi</button>
		</div>
    </div>
</div>
{!! Form::close() !!}
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Pendapatan Pembayaran Kapitasi BPJS</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>ID</th>
								<th>Tanggal Pembayaran</th>
								<th>Nama Petugas</th>
								<th>Nilai Uang</th>
								<th>Periode</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($bpjs as  $bpj)	
								<tr>
									<td>{{ $bpj->id }}</td>
									<td>{{ $bpj->tanggal_pembayaran->format('d-m-Y') }}</td>
									<td>{{ $bpj->staf->nama }}</td>
									<td class="uang">{{ $bpj->nilai }}</td>
									<td>{{ $bpj->mulai_tanggal->format('d-m-Y') }} s/d {{ $bpj->akhir_tanggal->format('d-m-Y') }}</td>
									<td> <a class="btn btn-success btn-xs" href="#">details</a> </td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@stop
@section('footer') 
	<script>
function cek_tagihan(){
	 if( validatePass() ){
	 	$('#submit_form').click();
	 }
}
	</script>
	
@stop
