@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Perusahaan

@stop
@section('page-title') 
<h2>Edit Perusahaan</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Edit Perusahaan</strong>
    </li>
</ol>
@stop
@section('content') 
    <div>
                <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#data_perusahaan" aria-controls="data_perusahaan" role="tab" data-toggle="tab">Data Perusahaan</a></li>
            <li role="presentation"><a href="#peserta_perusahaan" aria-controls="peserta_perusahaan" role="tab" data-toggle="tab">Peserta Perusahaan</a></li>
        </ul>
                <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="data_perusahaan">
                {!! Form::model($perusahaan, ['url' => 'perusahaans/' . $perusahaan->id, 'method' => 'put']) !!}
                    @include('perusahaans.form')
                {!! Form::close() !!}    
            </div>
            <div role="tabpanel" class="tab-pane" id="peserta_perusahaan">
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nomor Bpjs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($perusahaan->peserta->count() > 0)
                                @foreach($perusahaan->peserta as $peserta)
                                    <tr>
                                        <td>{{ $peserta->nama }}</td>
                                        <td>{{ $peserta->nomor_asuransi_bpjs }}</td>
                                        <td nowrap class="autofit">
                                            {!! Form::open(['url' => 'peserta_bpjs_perusahaans/' . $peserta->id, 'method' => 'delete']) !!}
                                                <a class="btn btn-warning btn-sm" href="{{ url('peserta_bpjs_perusahaans' . $peserta->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $peserta->id }} - {{ $peserta->nama }} ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">
                                        {!! Form::open(['url' => 'peserta_bpjs_perusahaans/' . $perusahaan->id. '/import', 'method' => 'post', 'files' => 'true']) !!}
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
        </div>
    </div>
    
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
    function dummySubmit(control){
        if(validatePass2(control)){
            $('#submit').click();
        }
    }
</script>
@stop
