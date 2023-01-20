@extends('layout.master')

@section('title') 
Klinik Jati Elok | Ruangan Yang Tersedia

@stop
@section('page-title') 
<h2>Ruangan Yang Tersedia</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Ruangan Yang Tersedia</strong>
    </li>
</ol>

@stop
@section('content') 
<div class="float-right">
    <a href="{{ url('ruangans/create') }}" type="button" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ruangan</a>
</div>
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Cek Harian</th>
                <th>Cek Bulanan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($ruangans->count() > 0)
                @foreach($ruangans as $ruangan)
                    <tr>
                        <td>{{ $ruangan->nama }}</td>
                        <td>{{ $ruangan->jumlah_cek_list_harian }}</td>
                        <td>{{ $ruangan->jumlah_cek_list_bulanan }}</td>
                        <td> 
                            {!! Form::open(['url' => 'ruangans/' . $ruangan->id, 'method' => 'delete']) !!}
                                <a href="{{ url('cek_list_ruangans/' . $ruangan->id) }}" class="btn btn-primary btn-sm">Ceklist</a> 
                                <a class="btn btn-warning btn-sm" href="{{ url('ruangans/' . $ruangan->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $ruangan->id }} - {{ $ruangan->nama }} ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">Tidak ada data untuk ditampilkan</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@stop
@section('footer') 
    
@stop
