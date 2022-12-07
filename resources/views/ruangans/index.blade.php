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
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($ruangans->count() > 0)
                @foreach($ruangans as $ruangan)
                    <tr>
                        <td>{{ $ruangan->nama }}</td>
                        <td> <a href="{{ url('cek_list_ruangans/' . $ruangan->id) }}" class="btn btn-primary btn-sm">Ceklist</a> </td>
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
