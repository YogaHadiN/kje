@extends('layout.master')

@section('title') 
Klinik Jati Elok | Lapora Recovery Index
@stop
@section('head') 
<style type="text/css" media="screen">
th:first-child, td:first-child, th:nth-child(2), td:nth-child(2) {
    width: 15%;
}
th:nth-child(3), td:nth-child(3) {
    width: 10%;
}
th:nth-child(4), td:nth-child(4) {
    width: 15%;
}
th:nth-child(5), td:nth-child(5) {
    width: 30%;
}
</style>
@stop

@section('page-title') 
<h2>Lapora Recovery Index</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Lapora Recovery Index</strong>
    </li>
</ol>

@stop
@section('content') 
{!! Form::text('recovery_index_id', $recovery_index_id, ['class' => 'form-control hide', 'id' => 'recovery_index_id']) !!}
<div class="table-responsive">
    <div class="row">
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            Menampilkan <span id="rows"></span> hasil
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding-bottom">
            {!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
                'class'    => 'form-control',
                'onchange' => 'clearAndSearch();return false;',
                'id'       => 'displayed_rows'
            ]) !!}
        </div>
      </div>
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th nowrap class="kolom_tanggal">
                    Tanggal
                    {!! Form::text('tanggal', null, [
                        'class' => 'form-control-inline tgl form-control ajaxsearchrekening',
                        'onkeyup' => 'clearAndSearch();return false;',
                        'id'    => 'tanggal'
                    ])!!}
                </th>
                <th nowrap class="kolom_nama">
                    Nama <br>
                    {!! Form::text('nama', null, [
                        'class' => 'form-control-inline tgl form-control ajaxsearchrekening',
                        'onkeyup' => 'clearAndSearch();return false;',
                        'id'    => 'nama'
                    ])!!}
                </th>
                <th nowrap class="kolom_dokter">
                    Dokter</br>
                    {!! Form::select('staf_id', \App\Models\Staf::pluck('nama','id'), null, [
                        'class'            => 'form-control-inline tgl form-control ajaxsearchrekening selectpick',
                        'data-live-search' => 'true',
                        'placeholder' => '- Pilih -',
                        'onchange'         => 'clearAndSearch();return false;',
                        'id'               => 'staf_id'
                    ])!!}
                </th>
                <th nowrap class="kolom_diagnosa">
                    Diagnosa</br>
                    <select id="diagnosa_id" onchange="clearAndSearch();return false;">
                        
                    </select>
                </th>
                <th nowrap class="kolom_keluhan">
                    Current Condition
                    {!! Form::text('keluhan', null, [
                        'class' => 'form-control-inline tgl form-control ajaxsearchrekening',
                        'onkeyup' => 'clearAndSearch();return false;',
                        'id'    => 'keluhan'
                    ])!!}
                </th>
            </tr>
        </thead>
        <tbody id="rek_container">

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
	<script src="{!! url('js/twbs-pagination/jquery.twbsPagination.min.js') !!}"></script>
	{!! HTML::script('js/recoveryIndexReport.js')!!}
@stop
