@extends('layout.master')

@section('title') 
    Klinik Jati Elok | Konsultasi Online {{ $konsultasi_estetik_online->nama }}

@stop
@section('page-title') 
<h2>Konsultasi Online {{ $konsultasi_estetik_online->nama }}</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Konsultasi Online {{ $konsultasi_estetik_online->nama }}</strong>
    </li>
</ol>

@stop
@section('content') 
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>{{ $konsultasi_estetik_online->nama }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>{{ $konsultasi_estetik_online->alamat }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>{{ $konsultasi_estetik_online->tanggal_lahir }}</td>
                    </tr>
                    @if ( $konsultasi_estetik_online->gambarPeriksa->count() )
                    <tr>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                  <!-- Indicators -->
                                  <ol class="carousel-indicators">
                                      @foreach ($konsultasi_estetik_online->gambarPeriksa as $k => $gambar)
                                        <li data-target="#carousel-example-generic" data-slide-to="{{ $k }}" {{ $k == 0 ? 'class="active"' : '' }}></li>
                                      @endforeach
                                  </ol>

                                  <!-- Wrapper for slides -->
                                  <div class="carousel-inner" role="listbox">
                                      @foreach ($konsultasi_estetik_online->gambarPeriksa as $k => $gambar)
                                        <div class="item {{ $k == 0 ? 'active' : '' }}">
                                            <img src="{{ \Storage::disk('s3')->url($gambar->nama) }}" alt="" class="img-rounded upload"> 
                                        </div>
                                      @endforeach
                                  </div>

                                  <!-- Controls -->
                                  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                  </a>
                                </div>
                            </div>
                        </div>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
@stop
@section('footer') 
    
@stop
