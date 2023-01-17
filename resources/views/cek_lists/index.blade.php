@extends('layout.master')

@section('title') 
Klinik Jati Elok | Daftar Cek List

@stop
@section('page-title') 
<h2>Daftar Cek List</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Daftar Cek List</strong>
            </li>
</ol>

@stop
@section('content') 
    <div class="float-right">
        <a href="{{ url('cek_lists/create') }}" target="_blank" class="btn btn-info btn-sm">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            Create Cek List
        </a>
    </div>
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Cek List</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if($cek_lists->count() > 0)
                @foreach($cek_lists as $cek_list)
                    <tr>
                        <td>{{ $cek_list->cek_list }}</td>
                        <td nowrap class="autofit">
                            {!! Form::open(['url' => 'cek_lists/' . $cek_list->id, 'method' => 'delete']) !!}
                                <a class="btn btn-warning btn-sm" href="{{ url('cek_lists/' . $cek_list->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $cek_list->id }} - {{ $cek_list->cek_list }} ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">
                        Tidak ada data untuk ditampilkan
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
        
@stop
@section('footer') 
    
@stop
