@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buat Ruangan Baru

@stop
@section('page-title') 
<h2>Buat Ruangan Baru</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Buat Ruangan Baru</strong>
            </li>
</ol>

@stop
@section('content') 
{!! Form::open(['url' => 'ruangans', 'method' => 'post']) !!}
@include('ruangans.form')
{!! Form::close() !!}
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

