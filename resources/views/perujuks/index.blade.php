@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Perujuk
@stop
@section('page-title') 
 <h2>Perujuk</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Perujuk</strong>
      </li>
</ol>
@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! App\Perujuk::all()->count() !!}</h3>
                </div>
                <div class="panelRight">
                    <a href="{{ url('perujuks/create') }}" class="btn btn-success"><span><i class="fa fa-plus"></i></span> Perujuk Baru</a>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>id</th>
							<th>nama</th>
							<th>alamat</th>
							<th>telp</th>
							<th>action</th>
						</tr>
					</thead>
					<tbody>
					  @if (count($perujuks) > 0)
						{{-- expr --}}
						@foreach($perujuks as $user)
							<tr>
								<td>{!!$user->id!!}</td>
								<td>{!!$user->nama!!}</td>
								<td>{!!$user->alamat!!}</td>
								<td>{!!$user->no_telp!!}</td>
								<td>
								  <a href="perujuks/{!!$user->id!!}/edit" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Edit</a>
								</td>

							</tr>
					   @endforeach
					  @else
						<tr>
						  
						  <td colspan="7" class="text-center">Tidak ada Data Untuk Ditampilkan :p</td>
						</tr>
					  @endif
						</tr>
					</tbody>
				</table>
		  </div>
      </div>
</div>


@stop
@section('footer') 
<script>
</script>

@stop
