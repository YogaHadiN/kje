@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Point

@stop
@section('page-title') 
<h2>Laporan Point</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Point</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! count($points)!!}</h3>
                </div>
                <div class="panelRight">
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					  <thead>
						<tr>
							<th>Nama Staf</th>
							<th>Jumlah Tensi</th>
							<th>Jumlah BB</th>
							<th>Jumlah Suhu</th>
						  <th>Jumlah TB</th>
						</tr>
					</thead>
					<tbody>
						 @foreach ($points as $p)
						 <tr>
						   <td>
							 {!! $p->nama !!}
						   </td>
						   <td>
							 {!! $p->tekanan_darah !!}
						   </td>
						   <td>
							 {!! $p->berat_badan !!}
						   </td>
						   <td>
							 {!! $p->suhu !!}
						   </td>
						   <td>
							 {!! $p->tinggi_badan !!}
						   </td>

						 </tr>
						 {{-- expr --}}
					   @endforeach
					</tbody>
				</table>
		  </div>
      </div>
</div>


@stop
@section('footer') 
	
@stop
