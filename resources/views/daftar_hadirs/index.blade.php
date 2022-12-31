@extends('layout.master')

@section('title') 
Klinik Jati Elok | Daftar Hadir
@stop
@section('page-title') 
<h2>Daftar Hadir</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Daftar Hadir</strong>
    </li>
</ol>

@stop
@section('content') 
    <div class="float-right">
        <a href="{{ url('daftar_hadirs/create') }}" type="button" class="btn btn-success">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Daftar Hadir Baru</a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pagi</th>
                    <th>Siang</th>
                    <th>Sore</th>
                    <th>Malam</th>
                    <th>Estetik</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($daftar_hadirs->count() > 0)
                    @foreach($daftar_hadirs as $k => $d)
                        <tr>
                            <td>{{ $k }}</td>
                            <td>
                                <ul>
                                    @foreach( $d[1] as $h )
                                        <li>
                                            {{ $h['nama'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach( $d[2] as $h )
                                        <li>
                                            {{ $h['nama'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach( $d[3] as $h )
                                        <li>
                                            {{ $h['nama'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach( $d[4] as $h )
                                        <li>
                                            {{ $h['nama'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach( $d[5] as $h )
                                        <li>
                                            {{ $h['nama'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td nowrap class="autofit">
                                {!! Form::open(['url' => 'daftar_hadirs/' . $d->id, 'method' => 'delete']) !!}
                                    <a class="btn btn-warning btn-sm" href="{{ url('daftar_hadirs/' . $d->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $d->id }} - {{ $d->tanggal }} ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data untuk ditampilkan</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@stop
@section('footer') 
    
@stop
