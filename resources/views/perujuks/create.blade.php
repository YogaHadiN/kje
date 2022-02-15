 @extends('layout.master')

 @section('title') 
{{ env("NAMA_KLINIK") }} | Daftarkan Perujuk

 @stop
 @section('head')
    <style>
        .nav-tabs li {
          width:50%;
        }
    </style>
 @stop
 @section('page-title') 
 <h2>Daftarkan Perujuk</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('perujuks')}}">Perujuk</a>
      </li>
      <li class="active">
          <strong>Daftarkan Perujuk</strong>
      </li>
</ol>
 @stop
 @section('content') 

 <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
     
            {!! Form::open(array(
                "url"   => "perujuks",
                "class" => "m-t", 
                "role"  => "form",
                "method"=> "post"
            ))!!}
                
              @include('perujuks.form', ['submit' => 'Submit'])

            {!! Form::close() !!}

        <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>

 </div>

 @stop
 @section('footer') 


 @stop


       
