@extends('layout.master')

@section('title') 
Klinik Jati Elok | Fast Moving Drug

@stop
@section('page-title') 
<h2>Fast Moving Drug</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Fast Moving Drug</strong>
            </li>
</ol>

@stop
@section('content') 
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group @if($errors->has('bulanTahun')) has-error @endif">
                  {!! Form::label('bulanTahun', 'Bulan Tahun', ['class' => 'control-label']) !!}
                {!! Form::text('bulanTahun', date('m-Y'), [
                    'id'    => 'bulanTahun',
                    'class'    => 'form-control bulanTahun',
                    'onChange' => 'refreshLaporan();return false;',
                ]) !!}
              @if($errors->has('bulanTahun'))<code>{{ $errors->first('bulanTahun') }}</code>@endif
            </div>
        </div>
    </div>
    <br></br>
    <div class="table-responsive">
        <table class="table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Merek</th>
                    <th>Kode Rak</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody id="container">

            </tbody>
        </table>
    </div>
@stop
@section('footer') 
    {!! HTML::script('js/fast_moving.js')!!}
@stop
