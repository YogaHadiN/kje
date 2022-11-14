@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Detil Pengeluaran

@stop
@section('page-title') 
<h2>Detail Pengeluaran</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Detail Pengeluaran</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-info">
	<div class="panel-heading">
		<div class="panelLeft">
			<div class="panel-title">Detail Pengaluaran</div>
		</div>
		<div class="panelRight">
		  Panel Right
		</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<tbody>
							<tr>
								<th>ID</th>
								<td>{{ $pengeluaran->id }}</td>
							</tr>
							<tr>
								<th>Keterangan</th>
								<td>{{ $pengeluaran->keterangan }}</td>
							</tr>
							<tr>
								<th>Nilai</th>
								<td>{{App\Models\Classes\Yoga::buatrp(  $pengeluaran->nilai  )}}</td>
							</tr>
							<tr>
								<th>Supplier</th>
								<td>
								<a href="{{ url('suppliers/' . $pengeluaran->supplier_id) }}">
										{{ $pengeluaran->supplier->nama }}
									</a>
								</td>
							</tr>
							<tr>
								<th>Tanggal</th>
								<td>
									{{ $pengeluaran->tanggal->format('d M Y') }}
								</td>
							</tr>
							<tr>
								<th>Sumber Uang {{ \Auth::id() }}</th>
								<td>
									{{ $pengeluaran->sumberUang->coa }}
								</td>
							</tr>
						</tbody>
					</table>
				</div>	
				<a class="btn btn-primary btn-lg btn-block" href="{{ url('pdfs/pengeluaran/' . $pengeluaran->id) }}" target="_blank">Cetak PDF Struk</a>
				@if (\Auth::id() == '28')
					<br>
				{!! Form::open(['url' => 'pengeluarans/' . $pengeluaran->id, 'method' => 'delete']) !!}
					{!! Form::submit('Hapur Pengeluaran', [
						'class'   => 'btn btn-danger btn-block btn-lg',
						'onclick' => 'return confirm("anda yakin mau menghapus transaksi ini?")',
						'id'      => 'submit'
					]) !!}
				{!! Form::close() !!}
				@endif
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a target="_blank" href="{{ \Storage::disk('s3')->url('img/belanja/lain/' . $pengeluaran->faktur_image) }}">
					<img src="{{ \Storage::disk('s3')->url('img/belanja/lain/' . $pengeluaran->faktur_image) }}" class="img-responsive,img-rounded,img-circle,img-thumbnail" alt="Responsive image">
				</a>
			</div>
		</div>
	</div>
</div>

@stop
@section('footer') 
@stop
