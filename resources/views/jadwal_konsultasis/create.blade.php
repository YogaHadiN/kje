@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buat Jadwal Konsultasi Baru

@stop
@section('page-title') 
<h2>Buat Jadwal Konsultasi Baru</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Buat Jadwal Konsultasi Baru</strong>
            </li>
</ol>

@stop
@section('content') 
{!! Form::open(['url' => 'jadwal_konsultasis', 'method' => 'post']) !!}
    @include('jadwal_konsultasis.form')
{!! Form::close() !!}
@stop
@section('footer') 
    
@stop
