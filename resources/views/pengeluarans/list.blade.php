@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | List Belanja

@stop
@section('page-title') 
<h2>List Pengeluaran</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>List Pengeluaran</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>List Pengeluaran tanggal {!! App\Models\Classes\Yoga::updateDatePrep($mulai) !!} - {!! App\Models\Classes\Yoga::updateDatePrep($akhir) !!}</h3>
                </div>
                <div class="panelRight">

                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-striped table-bordered table-hover" id="tableAsuransi">
                  <thead>
                    <tr>
                    	<th>faktur</th>
                    	<th>Tanggal</th>
                    	<th>Supplier</th>
                      <th>Total</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	 @foreach ($notas as $nota)
                     <tr>
                       <td>
                         {!! $nota->nomor_faktur !!}
                       </td>
                       <td>
                         {!! App\Models\Classes\Yoga::updateDatePrep($nota->tanggal) !!}
                       </td>
                       <td>
                         {!! $nota->supplier->nama !!}
                       </td>
                       <td class='uang'>
                         {!! $nota->jumlah_pengeluaran !!}
                       </td>
                       <td>
                         <a href="{{ url('pengeluarans/show/' . $nota->id) }}" class="btn btn-primary btn-xs">Details</a>
                       </td>
                       
                     </tr>
                   @endforeach
                </tbody>
            </table>
      </div>
</div>


@stop
@section('footer') 
	
@stop
