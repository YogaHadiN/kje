@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Tindakan Harian

@stop
@section('page-title') 
<h2>Laporan Tindakan Harian</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Laporan Tindakan Harian</strong>
            </li>
</ol>

@stop
@section('content') 
    <div class="mb-6 pb-6">
        <a href="{{ url('pdfs/tindakanHarian/' . $tanggal. '/' . $asuransi_id_25) }}" target="_blank" class="float-right btn btn-success btn-sm">PDF</a>
    </div>
    @include('laporans.formTindakanHarian')
        
@stop
@section('footer') 
    
@stop
