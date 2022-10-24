@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Follow up Tunggakan

@stop
@section('page-title') 
<h2>Follow up Tunggakan</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Follow up Tunggakan</strong>
    </li>
</ol>

@stop
@section('content') 
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="float-right">
                    <a href="{{ url('followup_tunggakans/create') }}" class="btn btn-primary "><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Followup Tunggakan</a>
                </div>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Asuransi</th>
                        <th>Tanggal</th>
                        <th>Nama Staf</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($followup_tunggakans->count() > 0)
                        @foreach($followup_tunggakans as $ft)
                            <tr>
                                <td>{{ $ft->asuransi->nama }}</td>
                                <td>{{ $ft->tanggal }}</td>
                                <td>{{ $ft->staf->nama }}</td>
                                <td nowrap class="autofit">
                                    {!! Form::open(['url' => 'followup_tunggakans/' . $ft->id, 'method' => 'delete']) !!}
                                        <a class="btn btn-warning btn-sm" href="{{ url('followup_tunggakans/' . $ft->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus follow up tunggakan ini?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="4">
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
