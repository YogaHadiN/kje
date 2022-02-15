@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Rumah Sakit

@stop
@section('page-title') 
<h2>List Semua Rumah Sakit</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Rumah Sakit</strong>
      </li>
</ol>
@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : </h3>
                </div>
                <div class="panelRight">
                   <a href='{{ url("rumahsakits/create") }}' type="button" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Rumah Sakit Baru</a>

                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover DT" id="tableRumahSakit">
					  <thead>
						<tr>
							<th>ID</th>
							<th>Nama Rumah Sakit</th>
							<th>Alamat</th>
							<th>PIC</th>
							<th>HP PIC</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						 @foreach ($rumahsakits as $rumahsakit)
						 <tr>
						   <td>
							 {!! $rumahsakit->id !!}
						   </td>
						   <td>
							 {!! $rumahsakit->nama !!}
						   </td>
						   <td>
							 {!! $rumahsakit->alamat !!}
						   </td>
						   <td>
							 {!! $rumahsakit->telepon !!}
						   </td>
						   <td nowrap>
							<ul>
								@foreach($rumahsakit->bpjsCenter as $pic)
									<li>{{ $pic->telp }} ({{ $pic->nama }})</li>
								@endforeach
							</ul>
							 {!! $rumahsakit->hp_pic !!}
						   </td>
						  <td>
							  <a href="{{ url('rumahsakits/'. $rumahsakit->id) }}" class="btn btn-success">Detail</a>                         
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
