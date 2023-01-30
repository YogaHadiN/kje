@extends('layout.master')

@section('title') 
Klinik Jati Elok | Pemeriksaan Hilang Tahun {{$year}}

@stop
@section('page-title') 
<h2>Pemeriksaan Hilang Tahun {{$year}}</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Pemeriksaan Hilang Tahun {{$year}}</strong>
            </li>
</ol>

@stop
@section('content') 
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Periksa ID</th>
                        <th>Tanggal sebelum</th>
                        <th>Tanggal sesudah</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($periksa_hilang) > 0)
                        @foreach($periksa_hilang as $k => $p)
                            <tr>
                                <td>{{ $k + 1 }}</td>
                                <td>{{ $p }}</td>
                                <td>{{ \App\Models\Periksa::find($p -1)?->created_at->format('d-m-Y') }}</td>
                                <td>{{ \App\Models\Periksa::find($p +1)?->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="">
                                {!! Form::open(['url' => 'model/imports', 'method' => 'post', 'files' => 'true']) !!}
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
