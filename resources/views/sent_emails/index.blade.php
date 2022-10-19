@extends('layout.master')

@section('title') 
Klinik Jati Elok | Sent Email

@stop
@section('page-title') 
<h2>Sent Email</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Sent Email</strong>
            </li>
</ol>

@stop
@section('content') 
    <div class="float-right">
        <a href="{{ url('sent_emails/create') }}" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Email</a>
    </div>
    <br></br>
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Nama Staf</th>
                        <th>Tanggal</th>
                        <th>Subject</th>
                        <th>Body</th>
                    </tr>
                </thead>
                <tbody>
                    @if($sent_emails->count() > 0)
                        @foreach($sent_emails as $sent_email)
                            <tr>
                                <td>{{ $sent_email->email }}</td>
                                <td>{{ $sent_email->staf->nama }}</td>
                                <td>{{ $sent_email->tanggal }}</td>
                                <td>{{ $sent_email->subject }}</td>
                                <td>{{ $sent_email->body }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data untuk ditampilkan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
@stop
@section('footer') 
    
@stop
