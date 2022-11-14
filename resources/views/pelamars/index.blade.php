@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Data Pelamar

@stop
@section('head') 
	<style type="text/css" media="all">
td{
	white-space:nowrap;
}
	</style>
@section('page-title') 
@stop
<h2>Data Pelamar</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Data Pelamar</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">
				<div class="panelLeft">
					
				</div>
				<div class="panelRight">
					<a class="btn btn-success" href="{{ url('pelamars/create') }}"> Pelamar Baru</a>
				</div>
			
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">

            <?php echo $pelamars->appends(Input::except('page'))->links(); ?>
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>id</th>
							<th>Nama</th>
							<th>No KTP</th>
							<th>No Telp</th>
							<th>Gambar KTP</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($pelamars->count() > 0)
							@foreach($pelamars as $p)
								<tr>
									<td>{{ $p->id }}</td>
									<td>{{ $p->nama }}</td>
									<td>{{ $p->no_ktp }}</td>
									<td>{{ $p->no_telp }}</td>
									<td>
										<img src="{{ \Storage::disk('s3')->url('img/pelamar/' . $p->image) }}" class="img-rounded ktp" alt="Responsive image">
									</td>
									<td> 
										{!! Form::open(['url' => 'pelamars/' .$p->id, 'method' => 'delete']) !!}
											<a class="btn btn-success btn-xs" href="{{ url('pelamars/' . $p->id . '/edit') }}">Edit</a>
											{!! Form::submit('Delete', [
												'class'   => 'btn btn-danger btn-xs',
												'onclick' => 'return confirm("Anda yakin mau menghapus ' . $p->id . '-' . $p->nama.' dari daftar Pelamar?");return false;',
												'id'      => 'submit'
											]) !!}
										{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td class="text-center" colspan="6">Tidak Ada Data Untuk Ditampilkan :p</td>
							</tr>
						@endif
					</tbody>
				</table>
            <?php echo $pelamars->appends(Input::except('page'))->links(); ?>
			</div>
			
		</div>
	</div>

@stop
@section('footer') 
	
@stop

