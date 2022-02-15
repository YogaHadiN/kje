@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Laporan Prolanis HT Berobat {{ $bulanThn->format('Y-m') }}

@stop
@section('page-title') 
    <h2>Laporan Prolanis HT Berobat {{ $bulanThn->format('Y-m') }}</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Laporan Prolanis HT Berobat {{ $bulanThn->format('Y-m') }}</strong>
            </li>
</ol>

@stop
@section('content') 
    @include('pasiens.prolanis_perbulan_template', ['prolanis' => 'prolanis_ht', 'bukan_pdf' => true])
@stop
@section('footer') 
    
@stop
