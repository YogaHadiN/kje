@extends('layout.master')

@section('title') 
Klinik Jati Elok | Dokumen Penting

@stop
@section('head') 
<style type="text/css" media="screen">
th:first-child, td:first-child{
    width: 10%;
}

th:nth-child(2), td:nth-child(2){
    width: 60%;
}
th:nth-child(3), td:nth-child(3){
    width: 20%;
}

    
</style>
@stop

@section('page-title') 
<h2>Dokumen Penting</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Dokumen Penting</strong>
    </li>
</ol>
@stop
@section('content') 
<div class="table-responsive">
    <div class="float-right pb-8">
        <a href="{{ url( 'documents/create' ) }}" type="button" class="btn btn-success">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dokumen Baru
        </a>
    </div>
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>
                   ID<br>
                   {!! Form::text('id', null, [
                        'class'   => 'form-control-inline form-control',
                        'id'      => 'id',
                        'onkeyup' => 'documentKeyUp(this);return false;'
                   ])!!}
                </th>
                <th class="nama">
                    Nama Dokumen <br>
                    {!! Form::text('nama', null, [
                        'class'   => 'form-control-inline form-control',
                        'id'      => 'nama',
                        'onkeyup' => 'documentKeyUp(this);return false;'
                    ])!!}
                </th>
                <th class="tanggal">
                    Tanggal <br>
                   {!! Form::text('tanggal', null, [
                        'class'   => 'form-control-inline form-control',
                        'id'      => 'tanggal',
                        'onkeyup' => 'documentKeyUp(this);return false;'
                    ])!!}
                </th>
                <th class="action">
                    Action 
                </th>
            </tr>
        </thead>
        <tbody id="container">

        </tbody>
    </table>
</div>
@stop
@section('footer') 
    {!! HTML::script('js/document.js')!!}
@stop
