@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Bagi Hasil Pelayanan Gigi

@stop
@section('page-title') 
<h2>Bagi Hasil Pelayanan Gigi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Bagi Hasil Pelayanan Gigi</strong>
	  </li>
</ol>

@stop
@section('content') 
	{!! Form::open(['url' => 'pengeluarans/bagi_hasil_gigi', 'method' => 'post']) !!}

	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Bagi Hasil Gigi</div>
				</div>
				<div class="panel-body">
					<h1>Bagi Hasil Gigi</h1>
					<hr>
					<div class="form-group @if($errors->has('sumber_coa_id'))has-error @endif">
					  {!! Form::label('sumber_coa_id', 'Sumber Uang', ['class' => 'control-label']) !!}
					  {!! Form::select('sumber_coa_id' , App\Models\Classes\Yoga::sumberCoaList(), 110004, ['class' => 'form-control']) !!}
					  @if($errors->has('sumber_coa_id'))<code>{{ $errors->first('sumber_coa_id') }}</code>@endif
					</div>
					<div class="form-group @if($errors->has('nilai'))has-error @endif">
					  {!! Form::label('nilai', 'Nilai', ['class' => 'control-label']) !!}
					  {!! Form::text('nilai' , null, ['class' => 'form-control uangInput']) !!}
					  @if($errors->has('nilai'))<code>{{ $errors->first('nilai') }}</code>@endif
					</div>
					<div class="form-group @if($errors->has('bulan'))has-error @endif">
					  {!! Form::label('bulan', 'Bulan Periode', ['class' => 'control-label']) !!}
					  {!! Form::text('bulan' , null, [
													  'class'    => 'form-control bulanTahun',
													  'onchange' => 'changePeriod(this);return false',
													  'id'       => 'periode'
												  ]) !!}
					  @if($errors->has('bulan'))<code>{{ $errors->first('bulan') }}</code>@endif
					</div>
					<div class="form-group @if($errors->has('petugas_id'))has-error @endif">
					  {!! Form::label('petugas_id', 'Petugas Penginput', ['class' => 'control-label']) !!}
					  {!! Form::select('petugas_id' , App\Models\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
					  @if($errors->has('petugas_id'))<code>{{ $errors->first('petugas_id') }}</code>@endif
					</div>
					<div class="form-group @if($errors->has('tanggal_dibayar'))has-error @endif">
					  {!! Form::label('tanggal_dibayar', 'Tanggal Dibayar', ['class' => 'control-label']) !!}
					  {!! Form::text('tanggal_dibayar' , date('d-m-Y'), ['class' => 'form-control tanggal']) !!}
					  @if($errors->has('tanggal_dibayar'))<code>{{ $errors->first('tanggal_dibayar') }}</code>@endif
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit(); return false;">Submit</button>
								<button class="btn btn-success btn-block btn-lg hide" id="submit" type="submit">Submit</button>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<a href="{{ url('laporan_laba_rugis') }}" class="btn btn-danger btn-block btn-lg">Cancel</a>
							</div>
						</div>
					</div>
			  </div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Kalkulator Bagi Hasil</div>
				</div>
				<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed table-bordered">
								<tbody>
									<tr>
										<td>
											<div class="form-group @if($errors->has('pendapatan_bpjs')) has-error @endif">
												  {!! Form::label('pendapatan_bpjs', 'Pendapatan BPJS', ['class' => 'control-label']) !!}
												  {!! Form::text('pendapatan_bpjs' , null, ['class' => 'form-control money']) !!}
												  @if($errors->has('pendapatan_bpjs'))<code>{{ $errors->first('pendapatan_bpjs') }}</code>@endif
											</div>
										</td>
										<td>
											x 20 %
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group @if($errors->has('gaji_dokter_gigi_bpjs')) has-error @endif">
												  {!! Form::label('gaji_dokter_gigi_bpjs', 'Gaji Dokter Gigi BPJS', ['class' => 'control-label']) !!}
												  {!! Form::text('gaji_dokter_gigi_bpjs' , null, ['class' => 'form-control money']) !!}
												  @if($errors->has('gaji_dokter_gigi_bpjs'))<code>{{ $errors->first('gaji_dokter_gigi_bpjs') }}</code>@endif
											</div>
										</td>
										<td>
											Dikurangi
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group @if($errors->has('asisten_gigi')) has-error @endif">
												{!! Form::label('asisten_gigi', 'Asisten Gigi', ['class' => 'control-label']) !!}
												{!! Form::text('asisten_gigi' , null, ['class' => 'form-control money']) !!}
												@if($errors->has('asisten_gigi'))<code>{{ $errors->first('asisten_gigi') }}</code>@endif
											</div>
										</td>
										<td>
											Dikurangi
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group @if($errors->has('bahan_gigi_vendor')) has-error @endif">
											{!! Form::label('bahan_gigi_vendor', 'Bahan Gigi Yang Dikeluarkan Vendor', ['class' => 'control-label']) !!}
											{!! Form::text('bahan_gigi_vendor' , null, ['class' => 'form-control money']) !!}
											@if($errors->has('bahan_gigi_vendor'))<code>{{ $errors->first('bahan_gigi_vendor') }}</code>@endif
											</div>
										</td>
										<td>
											Dikurangi
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group @if($errors->has('bahan_gigi_owner')) has-error @endif">
											{!! Form::label('bahan_gigi_owner', 'Bahan Gigi Yang Dikeluarkan Owner', ['class' => 'control-label']) !!}
											{!! Form::text('bahan_gigi_owner' , null, ['class' => 'form-control money']) !!}
											@if($errors->has('bahan_gigi_owner'))<code>{{ $errors->first('bahan_gigi_vendor') }}</code>@endif
											</div>
										</td>
										<td>
											Dikurangi
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group @if($errors->has('listrik')) has-error @endif">
												{!! Form::label('listrik', 'Listrik', ['class' => 'control-label']) !!}
												{!! Form::text('listrik' , null, ['class' => 'form-control money']) !!}
												@if($errors->has('listrik'))<code>{{ $errors->first('listrik') }}</code>@endif
											</div>
										</td>
										<td>
											Dikurangi
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group @if($errors->has('obat')) has-error @endif">
												{!! Form::label('obat', 'Obat', ['class' => 'control-label']) !!}
												{!! Form::text('obat' , null, ['class' => 'form-control money']) !!}
												@if($errors->has('obat'))<code>{{ $errors->first('obat') }}</code>@endif
											</div>
										</td>
										<td>
											Dikurangi
										</td>
									</tr>
								</tbody>
							</table>
						</div>
				</div>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Daftar Pembayaran Bagi Hasil</div>
		</div>
		<div class="panel-body">
			<?php echo $bagi_gigi->appends(Input::except('page'))->links(); ?>
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>Petugas Penginput</th>
							<th>Bagi Hasil Dibayarkan</th>
							<th>Pph21</th>
							<th>Periode Bulan</th>
							<th>Tanggal Dibayar</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($bagi_gigi as $gaji)
							<tr>
							<td>{{ $gaji->petugas->nama }}</td>
								<td class="uang">{{ $gaji->nilai }}</td>
								<td class="uang">{{ $gaji->pph21 }}</td>
								<td class="text-center">{{ $gaji->mulai->format('M Y') }}</td>
								<td class="text-center">{{ $gaji->tanggal_dibayar->format('d-m-Y') }}</td>
								<td>
									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
											 <a class="btn btn-info btn-block" href="{{ url('pdfs/bagi_hasil_gigi/' . $gaji->id) }}" >Struk</a> 
										</div>
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
											{!! Form::open(['url' => 'pengeluarans/bagi_hasil_gigi/' . $gaji->id, 'method' => 'delete']) !!}
												<button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus bagi hasil gigi ini?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
											{!! Form::close() !!}
										</div>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<?php echo $bagi_gigi->appends(Input::except('page'))->links(); ?>
		</div>
	</div>
@stop
@section('footer') 
	{!! HTML::script('js/bagi_gigi.js')!!}
@stop

