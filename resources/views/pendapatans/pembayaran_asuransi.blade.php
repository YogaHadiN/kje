@extends('layout.master')

@section('title') 
Klinik Jati Elok | Pembayaran Asuransi

@stop
@section('page-title') 
<h2>Pilih Asuransi Yang Mau Dilihat Pembayarannya</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Pilih Asuransi</strong>
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
                </div>
            </div>
      </div>
      <div class="panel-body">
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
                          {!! HTML::link('laporans/payment/' . $asuransi['id'], 'Payment', ['class' => 'btn btn-sm btn-primary'])!!}
                       </td>
                     </tr>
                     {{-- expr --}}
                   @endforeach
                </tbody>
            </table>
      </div>
</div>


@stop
@section('footer') 
	
@stop

