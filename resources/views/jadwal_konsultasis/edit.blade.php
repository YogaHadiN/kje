@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Jadwal Konsultasi

@stop
@section('page-title') 
<h2>Edit Jadwal Konsultasi</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Edit Jadwal Konsultasi</strong>
            </li>
</ol>

@stop
@section('content') 
{!! Form::model($jadwal_konsultasi,['url' => 'jadwal_konsultasis', 'method' => 'post']) !!}
    @include('jadwal_konsultasis.form')
{!! Form::close() !!}
@stop
@section('footer') 
    
@stop
