 @extends('layout.master')

 @section('title') 
 {{ env("NAMA_KLINIK") }} | Formula Baru

 @stop
 @section('page-title') 
 <h2>Formula Baru</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans') }}">Home</a>
      </li>
      <li>
          <a href="{{ url('mereks') }}">Merek</a>
      </li>
      <li class="active">
          <strong>Formula Baru</strong>
      </li>
</ol>
 @stop
 @section('content') 
 <input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
  {!! Form::model($template, array(
        "url"   => "formulas",
        "class" => "m-t", 
        "role"  => "form",
        "method"=> "post"
        )) !!}

	@include('formulas.createForm', ['readonly' => null, 'modal' => false])
{!! Form::close()  !!}
  
       
        <div id="notif"></div>
        <div id="tabelNotif"></div>
 
    @stop
    @section('footer') 
  <script>
  var base = "{{ url('/')  }}"
console.log(base);
    </script>
<script src="{{ url('js/createForm.js')  }}"></script>
    @stop
