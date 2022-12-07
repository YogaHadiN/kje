@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Cek Harian Anafilaktik Kit {{ $ruangan->nama }}

@stop
@section('page-title') 
    <h2>Cek Harian Anafilaktik Kit {{ $ruangan->nama }}</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Cek Harian Anafilaktik Kit {{ $ruangan->nama }}</strong>
    </li>
</ol>

@stop
@section('content') 
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        {!! Form::model($cek_harian_anafilaktik_kit,[
            'url'    => 'cek_harian_anafilaktik_kits/' . $cek_harian_anafilaktik_kit->id,
            "class"  => "m-t",
            "role"   => "form",
            "method" => "put",
            "files"  => "true"
        ]) !!}
            @include('cek_harian_anafilaktik_kits.form')
        {!! Form::close() !!}
    </div>
</div>
@stop
@section('footer') 
    <script type="text/javascript" charset="utf-8">
        function dummySubmit(control){
            if(validatePass2(control)){
                $('#submit').click();
            }
        }
    </script>
@stop
