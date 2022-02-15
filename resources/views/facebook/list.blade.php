@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | List Pendaftaran Online

@stop
@section('page-title') 
<h2>List Pendaftaran Online</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>List Pendaftaran Online</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">List Pendaftaran Online</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>id</th>
							<th>Nama Pasien</th>
							<th>Pembayaran</th>
							<th>Poli</th>
							<th>Sudah Pernah Berobat</th>
							<th>Daftar Jam</th>
							<th colspan="2">Acition</th>
						</tr>
					</thead>
					<tbody>
						@if($facebook_daftars->count() > 0)
							@foreach($facebook_daftars as $fb)
								<tr>
									<td>{{ $fb->id }}</td>
									<td>{{ $fb->nama_pasien }}</td>
									<td>{{ $fb->pembayaran }}</td>
									<td>{{ $fb->poli->poli }}</td>
									<td>{{ $fb->status_berobat }}</td>
									<td>{{ $fb->created_at }}</td>
									<td> <a class="btn btn-xs btn-success btn-block" href="{{ url('facebook/verification/' . $fb->id) }}">Verifikasi</a> </td>
									<td>
										{!! Form::open(array('url' => 'facebook/' . $fb->id . '/delete', 'method' => 'DELETE'))!!} 
										{!! Form::submit('delete', array('class' => 'btn btn-xs btn-danger btn-block', 'onclick' => 'return confirm("Anda yakin mau menghapus pasien ' . $fb->nama_pasien . ' dari antrian?")')) !!}
			</div>
			{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td class="text-center" colspan="8">Tidak Ada Data Untuk Ditampilkan :p</td>
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

