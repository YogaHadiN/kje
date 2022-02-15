@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Stok Minimal

@stop
@section('page-title') 
<h2>Target Pembelian Obat dalam 1 Minggu</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans') }}">Home</a>
      </li>
      <li class="active">
          <strong>Stok Minimal</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft"> 
                    <h3>Total : {!! count($raks)  !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
					<table class="table table-striped table-bordered table-hover DT" id="tableAsuransi">
					  <thead>
						<tr>
							<th>Rak</th>
							<th>Nama Merek</th>
							<th>Stok Minimal</th>
						</tr>
					</thead>
					<tbody>
						 @foreach ($raks as $rak)
						 <tr>
						   <td>
							 {!! $rak->id  !!}
						   </td>
						   <td>
							 @foreach($rak->merek as $merek)
								{!! $merek->merek  !!} /
							 @endforeach
						   </td>
						   <td>
							 {!! $rak->stok_minimal  !!}
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
