@extends('layout.master')

@section('title') 
Klinik Jati Elok | Kirim Berkas

@stop
@section('page-title') 
<h2>Kirim Berkas</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Kirim Berkas</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<div class="panelRight">
					<a class="btn btn-success" href="{{ url('kirim_berkas/create') }}">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 
						Create
					</a>
				</div>
			</h3>
		</div>
		<div class="panel-body">
			{{ $kirim_berkas->links() }}
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Tanggal Kirim</th>
							<th>Staf</th>
							<th>Rekap Tagihan</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($kirim_berkas->count() > 0)
							@foreach($kirim_berkas as $kirim)
								<tr>
									<td>{{ App\Models\Classes\Yoga::updateDatePrep( $kirim->tanggal ) }}</td>
									<td>
										<div class="table-responsive">
											<table class="table table-hover table-condensed table-bordered">
												<tbody>
													@foreach($kirim->petugas_kirim as $petugas)	
														<tr>
															<td>{{ $petugas->staf->nama }}</td>
															<td>{{ $petugas->role_pengiriman->role_pengiriman }}</td>
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</td>
									<td>
										<div class="table-responsive">
											<table class="table table-hover table-condensed table-bordered">
												<tbody>
													@foreach($kirim->rekap_tagihan as $k => $tagihan)	
														<tr>
															<td nowrap><a href="{{ url('invoices/' . str_replace('/', '!', $tagihan['nomor_invoice'])) }}">{{ $tagihan['nomor_invoice'] }}</a></td>
															<td>{{ $k }}</td>
															<td nowrap class="text-right">{{ $tagihan['jumlah_tagihan'] }} Tagihan</td>
															<td nowrap class="text-right">{{ App\Models\Classes\Yoga::buatrp( $tagihan['total_tagihan'] ) }}</td>
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</td>
									<td nowrap class="autofit">
										{!! Form::open(['url' => 'kirim_berkas/'. $kirim->id_view, 'method' => 'delete']) !!}
										<div class="table-responsive">
											<table class="table table-hover table-condensed table-bordered">
												<tbody>
													<tr>
														<td>
															<a class="btn btn-info btn-xs btn-block" href="{{ url('kirim_berkas/' . $kirim->id_view . '/edit') }}">
																<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
																Edit
															</a>
														</td>
													</tr>
													<tr>
														<td>
															@if(!is_null($kirim->foto_berkas_dan_bukti))
																<a target="_blank" class="btn btn-primary btn-xs btn-block" href="{{ \Storage::disk('s3')->url('img/foto_berkas_dan_bukti/' . $kirim->foto_berkas_dan_bukti) }}">
																<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
																Lihat Pengesahan
															</a>
															@else
															<a class="btn btn-warning btn-xs btn-block" href="{{ url('kirim_berkas/' . $kirim->id_view . '/inputNota') }}">
																<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
																Input Nota
															</a>
															@endif
														</td>
													</tr>
													<tr>
														<td>
															<a target="_blank" class="btn btn-success btn-xs btn-block" href="{{ url('pdfs/kirim_berkas/' . $kirim->id_view ) }}">
																<span class="glyphicon glyphicon-check" aria-hidden="true"></span>
																Cetak Form
															</a>
														</td>
													</tr>
													<tr>
														<td>
															<button class="btn btn-danger btn-xs btn-block" type="submit" onclick="return confirm('Anda yakin mau menghapus form berkas ini?');return false;"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="4" class="text-center">Tidak ada data untuk ditampilkan</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
	
@stop
@section('footer') 
	
@stop

