@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Tarif {{ $asuransi->nama }}

@stop
@section('page-title') 
    <h2>Tarif {{ $asuransi->nama }}</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Tarif {{ $asuransi->nama }}</strong>
            </li>
</ol>

@stop
@section('content') 
    {!! Form::text('asuransi_id', $asuransi->id, [
        'class' => 'form-control hide',
        'id' => 'asuransi_id'
    ]) !!}
    <div class="table-responsive">
        <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                Menampilkan <span id="rows"></span> hasil
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding-bottom">
                {!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
                    'class' => 'form-control',
                    'onchange' => 'clearAndSelectPasien();return false;',
                    'id'    => 'displayed_rows'
                ]) !!}
            </div>
          </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                       Jenis Tarif<br>
                       {!! Form::select('jenis_tarif_id', \App\Models\JenisTarif::pluck('jenis_tarif', 'id'), null, [
                            'class'            => 'form-control-inline form-control selectpick',
                            'placeholder'      => '- Pilih -',
                            'id'               => 'sp_jenis_tarif_id',
                            'data-live-search' => 'true',
                            'onchange'         => 'clearAndSearch(); return false;'
                       ])!!}
                    </th>
                    <th>
                       Biaya<br>
                       {!! Form::text('biaya', null, [
                            'class'   => 'form-control-inline form-control',
                            'id'      => 'sp_biaya',
                            'onkeyup' => 'clearAndSearch(); return false;'
                       ])!!}
                    </th>
                    <th>
                       Jasa Dokter<br>
                       {!! Form::text('jasa_dokter', null, [
                            'class'    => 'form-control-inline form-control',
                            'id'       => 'sp_jasa_dokter',
                            'onchange' => 'clearAndSearch(); return false;'
                       ])!!}
                    </th>
                    <th>
                       Tipe Tindakan<br>
                       {!! Form::select('tipe_tindakan_id', \App\Models\TipeTindakan::pluck('tipe_tindakan', 'id'), null, [
                            'class'       => 'form-control-inline form-control selectpick',
                            'placeholder' => '- Pilih -',
                            'id'          => 'sp_tipe_tindakan_id',
                            'onchange'    => 'clearAndSearch(); return false;'
                       ])!!}
                    </th>
                    <th>Action</th>
                    <th class="hide">id</th>
                    <th class="hide key">id</th>
                    <th class="hide">tipe_tindakan_id</th>
                </tr>
            </thead>
            <tbody id="tarifContainer">
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
	{!! HTML::script('js/tarif_asuransi.js')!!}
@stop
