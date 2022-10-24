@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Sertifikat

@stop
@section('head') 
    <style type="text/css" media="screen">
table th:first-child, table td:first-child {
    width:10%;
}

table th:nth-child(2), table th:nth-child(2){
    width:30%;
}

table th:nth-child(3), table th:nth-child(3){
    width:20%;
}
    
    </style>
@stop
@section('page-title') 
<h2>Sertifikat</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Sertifikat</strong>
    </li>
</ol>

@stop
@section('content') 

    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            {!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
                'class' => 'form-control',
                'onchange' => 'clearAndSelectPasien();return false;',
                'id'    => 'displayed_rows'
            ]) !!}
        </div>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div class="float-right pb-8">
                <a href="{{ url('sertifikats/create') }}" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Sertifikat</a>
            </div>
        </div>
    </div>

    <br></br>

    <div class="table-responsive">
        <table class="table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    <th>
                       ID<br>
                       {!! Form::text('id', null, [
                            'class'   => 'form-control-inline form-control',
                            'id'      => 'id',
                            'onkeyup' => 'documentKeyUp();return false;'
                       ])!!}
                    </th>
                    <th class="nama">
                        Nama Dokumen <br>
                        {!! Form::text('nama', null, [
                            'class'   => 'form-control-inline form-control',
                            'id'      => 'nama',
                            'onkeyup' => 'documentKeyUp();return false;'
                        ])!!}
                    </th>
                    <th class="staf_id">
                        Pemilik <br>
                        {!! Form::select('staf_id', \App\Models\Staf::pluck('nama', 'id'), null, [
                            'class'            => 'form-control-inline form-control selectpick',
                            'data-live-search' => 'true',
                            'id'               => 'staf_id',
                            'placeholder'      => 'Pilih',
                            'onchange'         => 'documentKeyUp();return false;'
                        ])!!}
                    </th>
                    <th class="tanggal_terbit">
                        Tanggal <br>
                       {!! Form::text('tanggal_terbit', null, [
                            'class'   => 'form-control-inline form-control',
                            'id'      => 'tanggal',
                            'onkeyup' => 'documentKeyUp();return false;'
                        ])!!}
                    </th>
                    <th class="expiry_date">
                        Berlaku Sampai <br>
                       {!! Form::text('expiry_date', null, [
                            'class'   => 'form-control-inline form-control',
                            'id'      => 'expiry_date',
                            'onkeyup' => 'documentKeyUp();return false;'
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
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="page-box">
                <nav class="text-right" aria-label="Page navigation" id="paging">
                
                </nav>
            </div>
        </div>
    </div>
</div>
@stop
@section('footer') 
    {!! HTML::script('js/sertifikat.js')!!}
@stop
