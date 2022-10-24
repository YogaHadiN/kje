@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Setor Tunai

@stop
@section('page-title') 
<h2>Setor Tunai</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Setor Tunai</strong>
            </li>
</ol>

@stop
@section('content') 
    <div class="float-right mb-6">
        <a href="{{ url('setor_tunais/create') }}" class="btn btn-success"><span><i class="fa fa-plus"></i></span> Setor Tunai</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Staf</th>
                    <th>Nominal</th>
                    <th>Tujuan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($setor_tunais->count() > 0)
                    @foreach($setor_tunais as $setor)
                        <tr>
                            <td>{{ $setor->tanggal }}</td>
                            <td>{{ $setor->staf->nama }}</td>
                            <td>{{ $setor->nominal }}</td>
                            <td>{{ $setor->coa->coa }}</td>
                            <td nowrap class="autofit">
                                {!! Form::open(['url' => 'setor_tunais/' . $setor->id, 'method' => 'delete']) !!}
                                    <a class="btn btn-warning btn-sm" href="{{ url('setor_tunais/' . $setor->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $setor->id }} - {{ $setor->id }} ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">Data tidak ditemukan</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
        

@stop
@section('footer') 
    
@stop
