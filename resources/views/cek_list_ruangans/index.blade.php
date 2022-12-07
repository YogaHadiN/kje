@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Cek List Ruang {{ $ruangan->nama }}

@stop
@section('page-title') 
    <h2>Cek List Ruang {{ $ruangan->nama }}</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li>
        <a href="{{ url('ruangans')}}">Ruangan</a>
    </li>
    <li class="active">
        <strong>Cek List</strong>
    </li>
</ol>

@stop
@section('content') 
    <div class="float-right">
        <a href="{{ url('cek_list_ruangans/' . $ruangan->id . '/create') }}" class="btn btn-primary btn-sm">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            Create</a>
    </div>
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Cek List</th>
                <th>Limit</th>
                <th>Jumlah Normal</th>
                <th>Frekuensi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($cek_list_ruangans->count() > 0)
                @foreach($cek_list_ruangans as $cek_list)
                    <tr>
                        <td>{{ $cek_list->cek_list->cek_list }}</td>
                        <td>{{ $cek_list->limit->limit }}</td>
                        <td>{{ $cek_list->jumlah_normal }}</td>
                        <td>{{ $cek_list->frekuensi_cek->frekuensi_cek }}</td>
                        <td nowrap class="autofit">
                            {!! Form::open(['url' => 'cek_list_ruangans/' . $cek_list->id, 'method' => 'delete']) !!}
                                <a class="btn btn-warning btn-sm" href="{{ url('cek_list_ruangans/' .  $cek_list->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $cek_list->id }} ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data untuk ditampilkan</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@stop
@section('footer') 
    
@stop
