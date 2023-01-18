@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Ruangan

@stop
@section('page-title') 
<h2>Edit Ruangan</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Edit Ruangan</strong>
    </li>
</ol>

@stop
@section('content') 
    {!! Form::model($ruangan,['url' => 'ruangans/' . $ruangan->id, 'method' => 'put']) !!}
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

