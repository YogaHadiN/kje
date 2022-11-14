@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Daftar AC

@stop
@section('page-title') 
<h2>Daftar AC</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Daftar AC</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">
						<div class="panelLeft">
							Daftar Air Conditioner
						</div>
						<div class="panelRight">
							<a class="btn btn-success" href="{{ url('acs/create') }}">Pembelian AC baru</a>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed table-bordered">
							<thead>
								<tr>
									<th>id</th>
									<th>merek</th>
									<th>Keterangan</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@if($acs->count() > 0)
									@foreach($acs as $ac)
										<tr>
											<td>{{ $ac->id }}</td>
											<td>{{ $ac->merek }}</td>
											<td>{{ $ac->keterangan }}</td>
											<td>
												<div class="row">
													<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
														<a class="btn btn-warning btn-xs btn-block" href="{{ url('acs/'. $ac->id . '/edit') }}">Edit</a>
													</div>
													<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
														{!! Form::open(['url' => 'acs/' . $ac->id, 'method' => 'delete']) !!}
															<div class="form-group">
															  {!! Form::submit('Hapus', [
																  'class' => 'btn btn-danger btn-block btn-xs',
																  'onclick' => 'return confirm("Apa anda yakin mau menghapus '. $ac->id . ' - ' . $ac->merek . ' ?")'
															  ]) !!}
															</div> 
														{!! Form::close() !!}
													</div>
												</div>
											
											</td>
										</tr>
										<tr>
											<td colspan="4"> <img src="{{ \Storage::disk('s3')->url('img/ac/'. $ac->image) }}" class="img-rounded" alt="Responsive image">
											 </td>
										</tr>
									@endforeach
								@else
									<tr>
										<td class="text-center" colspan="4">Tidak Ada Data Untuk Ditampilkan :p</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
			
		</div>
	</div>
@stop
@section('footer') 
	
@stop

