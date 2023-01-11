@extends('layout.master')

@section('title') 
Klinik Jati Elok | Jadwal Konsultasi

@stop
@section('page-title') 
<h2>Jadwal Konsultasi</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Jadwal Konsultasi</strong>
            </li>
</ol>

@stop
@section('content') 
    <div class="float-right mb-6">
       <a href="{{ url('jadwal_konsultasis/create') }}" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Jadwal Konsultasi</a> 
    </div>
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Nama </th>
                <th>Jam Mulai</th>
                <th>Jam Akhir</th>
                <th>Tipe Konsultasi</th>
                <th>Act</th>
            </tr>
        </thead>
        <tbody>
            @if($jadwal_konsultasis->count() > 0)
                @foreach($jadwal_konsultasis as $j)
                    <tr>
                        <td>{{ $j->hari->hari }}</td>
                        <td>{{ $j->staf->nama }}</td>
                        <td>{{ $j->jam_mulai }}</td>
                        <td>{{ $j->jam_akhir }}</td>
                        <td>{{ $j->tipeKonsultasi->tipe_konsultasi }}</td>
                        <td nowrap class="autofit">
                            {!! Form::open(['url' => 'jadwal_konsultasis/' . $j->id, 'method' => 'delete']) !!}
                                <a class="btn btn-warning btn-sm" href="{{ url('jadwal_konsultasis/' . $j->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $j->id }} ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data untuk ditampilkan</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@stop
@section('footer') 
    
@stop
