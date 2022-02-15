@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Asuransi

@stop
@section('page-title') 
<h2>List Semua Asuransi</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Asuransi</strong>
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
                   <a href='{{ url("asuransis/create") }}' type="button" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ASURANSI Baru</a>

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
						<th>Email</th>
					  <th>Riwayat Hutan / Pembayaran</th>
					  <th>Edit</th>
						<th>Pembayaran</th>
					</tr>
				</thead>
				<tbody>
					 @foreach ($asuransis as $asuransi)
					 <tr>
					   <td>
						   {!! $asuransi->id !!}
					   </td>
					   <td>
						   {!! $asuransi->nama !!}
					   </td>
					   <td>
						   {!! $asuransi->alamat !!}
					   </td>
					   <td>
						   <ul>
							   @foreach($asuransi->pic as $pic)	
								  <li> {!! $pic->nama !!} ({{ $pic->nomor_telepon }})</li>
							   @endforeach
						   </ul>
					   </td>
						<td>
							<ul>
							   @foreach($asuransi->emails as $email)	
								   <li>
									   {!! $email->email !!}
									</li>
							   @endforeach
							</ul>
					   </td>
					   <td>
						   {!! HTML::link('asuransis/' . $asuransi->id . '/hutang/pembayaran', 'Riwayat', ['class' => 'btn btn-sm btn-success'])!!}
					   </td>
					   <td>
						   {!! HTML::link('asuransis/' . $asuransi->id . '/edit', 'Edit', ['class' => 'btn btn-sm btn-info'])!!}
					   </td>
					   <td>
						   {!! HTML::link('laporans/payment/' . $asuransi->id, 'Payment', ['class' => 'btn btn-sm btn-primary'])!!}
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
