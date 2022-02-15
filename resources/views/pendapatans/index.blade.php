@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Pendapatan Lain

@stop
@section('page-title') 
<h2>Pendapatan Lain</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Pendapatan Lain</strong>
      </li>
</ol>

@stop
@section('content') 
<div class="alert alert-info">
	<h3>Perhatian !!</h3>
	<p>Untuk menginput pembayaran tagihan untuk asuransi harus dilakukan di <a href="{{ url('pembayaran/asuransi') }}">Pembayaran Asuransi</a></p>
</div>
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : </h3>
                </div>
                <div class="panelRight">
                   <a href="{{ url('asuransis/create')}}" type="button" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ASURANSI Baru</a>

                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover DTi" id="tableAsuransi">
					  <thead>
						<tr>
							<th>ID</th>
							<th>Nama Asuransi</th>
							<th>Alamat</th>
							<th>PIC</th>
						  <th>HP PIC</th>
						  <th>Belum Dibayar</th>
						  <th>Jatuh Tempo</th>
						  <th>Edit</th>
							<th>Pembayaran</th>
						</tr>
					</thead>
					<tbody>
						 @foreach ($asuransis as $asuransi)
						 <tr>
						   <td>
							 {!! $asuransi['id'] !!}
						   </td>
						   <td>
							 {!! $asuransi['nama'] !!}
						   </td>
						   <td>
							 {!! $asuransi['alamat'] !!}
						   </td>
						   <td>
							 {!! $asuransi['pic'] !!}
						   </td>
						   <td>
							 {!! $asuransi['hp_pic'] !!}
						   </td>
						   <td>
							 {!! $asuransi['belum'] !!}
						   </td>
						   <td>
							  
						   </td>
						   <td>
							  {!! HTML::link('asuransis/' . $asuransi['id'] . '/edit', 'Edit', ['class' => 'btn btn-sm btn-info'])!!}
						   </td>
						   <td>
							  {!! HTML::link('laporans/payment/' . $asuransi['id'], 'Payment', ['class' => 'btn btn-sm btn-primary'])!!}
						   </td>
						 </tr>
						 
					   @endforeach
					</tbody>
				</table>
		  </div>
      </div>
</div>


@stop
@section('footer') 
	
@stop
