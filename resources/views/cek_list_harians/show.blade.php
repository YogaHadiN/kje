@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Cek List Harian Ruangan {{ $ruangan->nama }}
@stop
@section('page-title') 
<h2>Cek List Harian Ruangan {{ $ruangan->nama }}</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
        Klinik Jati Elok | Cek List Harian Ruangan {{ $ruangan->nama }}
    <li class="active">
        <strong>Cek List Harian Ruangan {{ $ruangan->nama }}</strong>
    </li>
</ol>
@stop
@section('content') 
<div>
        <!-- Nav tabs -->
    {{-- <ul class="nav nav-tabs" role="tablist"> --}}
    {{--     <li role="presentation" class="active"><a href="#anafilaktik_kit" aria-controls="anafilaktik_kit" role="tab" data-toggle="tab">Anafilaktik Kit</a></li> --}}
    {{--     <li role="presentation"><a href="#Temperatur" aria-controls="Temperatur" role="tab" data-toggle="tab">Temperatur</a></li> --}}
    {{-- </ul> --}}
    {{--     <!-- Tab panes --> --}}
    {{-- <div class="tab-content"> --}}
    {{--     <div role="tabpanel" class="tab-pane active" id="anafilaktik_kit"> --}}
    {{--         @include('cek_list_harians.tabel_anafilaktik_kit') --}}
    {{--     </div> --}}
    {{--     <div role="tabpanel" class="tab-pane" id="Temperatur"> --}}
    {{--         @include('cek_list_harians.tabel_temperatur') --}}
    {{--     </div> --}}
    {{-- </div> --}}

</div>
        
    
@stop
@section('footer') 
    
@stop
