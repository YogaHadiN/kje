@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan PPh21 Tahunan

@stop
@section('page-title') 
<h2>Laporan PPh21 Tahunan</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Laporan PPh21 Tahunan</strong>
            </li>
</ol>

@stop
@section('content') 
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
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>
                Nama
                {!! Form::select('staf_id', \App\Models\Staf::pluck('nama', 'id'), null, [
                    'class' => 'form-control-inline form-control',
                    'onchange' => 'clearAndSearch();return false;',
                    'placeholder' => '- Pilih -',
                    'id'    => 'staf_id'
                ])!!}
                </th>
                <th>
                Periode
                {!! Form::text('bulanTahun', null, [
                    'class' => 'form-control-inline bulanTahun form-control ajaxsearchrekening',
                    'onkeyup' => 'clearAndSearch();return false;',
                    'id'    => 'bulan_tahun'
                ])!!}
                </th>
                <th>
                Gaji Pokok
                    {!! Form::text('gaji_pokok', null, [
                        'class' => 'form-control-inline form-control',
                        'onkeyup' => 'clearAndSearch();return false;',
                        'id'    => 'gaji_pokok'
                    ])!!}
                </th>
                <th>
                    Pph21
                    {!! Form::text('pph21', null, [
                        'class' => 'form-control-inline form-control',
                        'onkeyup' => 'clearAndSearch();return false;',
                        'id'    => 'pph21'
                    ])!!}
                </th>
                <th>
                    Pph21 Terbaru
                    {!! Form::text('pph21_terbaru', null, [
                        'class' => 'form-control-inline form-control',
                        'onkeyup' => 'clearAndSearch();return false;',
                        'id'    => 'pph21_terbaru'
                    ])!!}
                </th>
                <th>Selisih</th>
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
	<script src="{!! url('js/twbs-pagination/jquery.twbsPagination.min.js') !!}"></script>
	{!! HTML::script('js/pph21tahunan.js')!!}
@stop
