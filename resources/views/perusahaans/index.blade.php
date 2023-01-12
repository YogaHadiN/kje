@extends('layout.master')

@section('title') 
Klinik Jati Elok | Daftar Perusahaan

@stop
@section('page-title') 
<h2>Daftar Perusahaan</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Perusahaan</strong>
            </li>
</ol>

@stop
@section('content') 
    <div class="float-right">
        <a href="{{ url('perusahaans/create') }}" class="btn btn-primary btn-sm">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            Create</a>
    </div>
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>PIC</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($perusahaans->count() > 0)
                @foreach($perusahaans as $p)
                    <tr>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->nama_pic }}</td>
                        <td>{{ $p->no_telp }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td nowrap class="autofit">
                            {!! Form::open(['url' => 'perusahaans/' . $p->id, 'method' => 'delete']) !!}
                                <a class="btn btn-warning btn-sm" href="{{ url('perusahaans/' . $p->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                                <a class="btn btn-info btn-sm" href="{{ url('peserta_bpjs_perusahaans/perusahaan/' . $p->id ) }}"> Peserta</a>
                                <a class="btn btn-success btn-sm" href="{{ url('pemeriksaan/perusahaan/' . $p->id ) }}"> Pemeriksaan</a>
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $p->id }} ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@stop
@section('footer') 
    
@stop
