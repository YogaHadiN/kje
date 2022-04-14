@extends('layout.master')

@section('title') 
  Klinik Jati Elok | Jumlah Pasien {{ $staf->nama }}

@stop
@section('page-title') 
  <h2>Jumlah Pasien {{ $staf->nama }}</h2>
<ol class="breadcrumb">
      <li>
        <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
        <strong>Jumlah Pasien {{ $staf->nama }}</strong>
      </li>
</ol>

@stop
@section('content') 
  <h1>Jumlah Pasien {{ $staf->nama }}</h1>
  <hr>
    <div class="table-responsive">
      <table class="table table-hover table-condensed table-bordered">
        <thead>
          <tr>
            <th>Tahun</th>
            <th>Jumlah Pasien</th>
            <th>Detil</th>
          </tr>
        </thead>
        <tbody>
          @if(count($jumlah) > 0)
            @foreach($jumlah as $j)
              <tr>
                <td>{{ $j->jumlah }}</td>
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
