 @extends('layout.master')

 @section('title') 
 Klinik Jati Elok | Asuransi Baru

 @stop
 @section('head')
    <style>
        .w{
            overflow: hidden;
        }

        .w input{
            width:100%;
        }
    </style>
 @stop
 @section('page-title') 
<h2>Asuransi Baru</h2> 
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('asuransis')}}">Asuransi</a>
      </li>
      <li class="active">
          <strong>Buat Baru</strong>
      </li>
</ol>
 @stop
 @section('content') 
  {!! Form::open(array(
        "url"   => "asuransis",
        "class" => "m-t", 
        "role"  => "form",
        "method"=> "post"
        ))!!}
@include('asuransis/form', [
'tanggal' => null, 
'submit' => 'Submit', 
'tarifs' => $tarifs, 
'umumstring' => null,
'gigistring' => null,
'rujukanstring' => null,
'hapus' => false,
'penagihanstring' => null


])
    {!! Form::close() !!}

    <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>

{{-- <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        
    </div>
</div> --}}

    @stop
    @section('footer') 
            @include('asuransis/footer', ['tarifs' => $tarifs])

    @stop
