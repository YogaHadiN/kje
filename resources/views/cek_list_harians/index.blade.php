@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Cek List Harian

@stop
@section('page-title') 
<h2>Cek List Harian</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Cek List Harian</strong>
            </li>
</ol>

@stop
@section('content') 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="float-right">
                <a href="{{ url('cek_list_harians/create') }}" target="_blank" class="btn btn-primary">Buat Baru</a>
            </div>
        </div>
    </div>

    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#hari_ini" aria-controls="hari_ini" role="tab" data-toggle="tab">Hari Ini</a></li>
            <li role="presentation"><a href="#perTanggal" aria-controls="perTanggal" role="tab" data-toggle="tab">Per Tanggal</a></li>
        </ul>

            <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="hari_ini">
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Ruangan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($ruangans->count() > 0)
                                @foreach($ruangans as $ruangan)
                                    <tr>
                                        <td>{{ $ruangan->nama }}</td>
                                        <td>{{ $ruangan->status }}</td>
                                        <td nowrap class="autofit">
                                            <a href="{{ url('cek_list_harians/' . $ruangan->id) }}" target="_blank" class="btn btn-primary btn-xs">Buka</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="">
                                        {!! Form::open(['url' => 'ruangans/imports', 'method' => 'post', 'files' => 'true']) !!}
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
            </div>
            <div role="tabpanel" class="tab-pane" id="perTanggal">
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($cek_list_dikerjakans_by_tanggal) > 0)
                                    @foreach($cek_list_dikerjakans_by_tanggal as $cek)
                                        <tr>
                                            <td>
                                                <a href="{{ url('cek_list_dikerjakans/byTanggal/' . $cek->tanggal) }}" target="_blank">
                                                    {{ $cek->tanggal }}
                                                </a>
                                            </td>
                                            <td nowrap class="autofit">

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
                    

            </div>
        </div>
    </div>
@stop
@section('footer') 
    
@stop
