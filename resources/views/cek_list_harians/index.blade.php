@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Cek List Harian

@stop
@section('page-title') 
<h2>Cek List Harian</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Cek List Harian</strong>
            </li>
</ol>

@stop
@section('content') 
<div class="float-right">
    <a href="{{ url('cek_list_harians/create') }}" target="_blank" class="btn btn-primary">Buat Baru</a>
</div>
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Ruangan</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($ruangans->count() > 0)
                @foreach($ruangans as $ruangan)
                    <tr>
                        <td>{{ $ruangan->nama }}</td>
                        <td>status</td>
                        <td nowrap class="autofit">
                            <a href="{{ url('cek_list_harians/' . $ruangan->id) }}" target="_blank" class="btn btn-primary btn-xs">Buka</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="">
                        {!! Form::open(['url' => 'ruangans/imports', 'method' => 'post', 'files' => 'true']) !!}
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
