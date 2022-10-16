@extends('layout.master')

@section('title') 
Klinik Jati Elok | Follow up Tunggakan

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
                        @foreach($followup_tunggakans as $f)
                            <tr>
                                <td>{{ $f->asuransi->nama }}</td>
                                <td>{{ $f->tanggal }}</td>
                                <td>{{ $f->staf->nama }}</td>
                                <td nowrap class="autofit">
                                    {!! Form::open(['url' => 'followup_tunggakans/' . $->id, 'method' => 'delete']) !!}
                                        <a class="btn btn-warning btn-sm" href="{{ url('followup_tunggakans/' . $f->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
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
