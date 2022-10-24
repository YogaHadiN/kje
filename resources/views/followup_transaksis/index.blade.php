@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Follwup Transaksi

@stop
@section('page-title') 
<h2>Follwup Transaksi</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Follwup Transaksi</strong>
            </li>
</ol>

@stop
@section('content') 
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Email</th>
                        <th>Asuransi</th>
                        <th>Nama staf</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($followup_transaksis->count() > 0)
                        @foreach($followup_transaksis as $followup_transaksi)
                            <tr>
                                <td>{{ $followup_transaksi->rekening_id }}</td>
                                <td>{{ $followup_transaksi->tanggal }}</td>
                                <td>{{ $followup_transaksi->email }}</td>
                                <td>{{ $followup_transaksi->asuransi->nama }}</td>
                                <td>{{ $followup_transaksi->staf->nama }}</td>
                                <td nowrap class="autofit">
                                    {!! Form::open(['url' => 'followup_transaksis/' . $ft->id, 'method' => 'delete']) !!}
                                        <a class="btn btn-warning btn-sm" href="{{ url('followup_transaksis/' . $ft->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus follow up transaksi ini?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">
                                Tidak ada data ditemuan
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
@stop
@section('footer') 
    
@stop
