@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Peserta Bpjs Perusahaan {{ $perusahaan->nama }}

@stop
@section('page-title') 
<h2>Peserta Bpjs Perusahaan {{ $perusahaan->nama  }}</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Peserta Bpjs Perusahaan {{ $perusahaan->nama  }}</strong>
    </li>
</ol>

@stop
@section('content') 
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Nomor Bpjs</th>
                <th>Pasien Id</th>
            </tr>
        </thead>
        <tbody>
            @if(count($peserta) > 0)
                @foreach($peserta as $p)
                    <tr>
                        <td>{{ $p->nama_pasien }}</td>
                        <td>{{ $p->nomor_asuransi_bpjs }}</td>
                        <td>{{ $p->pasien_id }}</td>
                        <td nowrap class="autofit">
                            {!! Form::open(['url' => 'p_bpjs_perusahaans/' . $p->id, 'method' => 'delete']) !!}
                            <a class="btn btn-warning btn-sm" href="{{ url('p_bpjs_perusahaans' . $p->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $p->id }} - {{ $p->nama_pasien }} ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">
                        {!! Form::open(['url' => 'peserta_bpjs_perusahaans/' . $perusahaan->id. '/import', 'method' => 'post', 'files' => 'true']) !!}
                        <div class="form-group">
                            {!! Form::label('file', 'Data tidak ditemukan, upload data?') !!}
                            {!! Form::file('file') !!}
                            {!! Form::submit('Upload', ['class' => 'btn btn-primary', 'id' => 'submit']) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@stop
@section('footer') 
    
@stop
