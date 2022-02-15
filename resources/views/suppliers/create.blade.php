 @extends('layout.master')

 @section('title') 
{{ env("NAMA_KLINIK") }} | Daftarkan Supplier

 @stop
 @section('head')
    <style>
        .nav-tabs li {
          width:50%;
        }
    </style>
 @stop
 @section('page-title') 
 <h2>Daftarkan Supplier</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('suppliers')}}">Supplier</a>
      </li>
      <li class="active">
          <strong>Daftarkan Supplier</strong>
      </li>
</ol>
 @stop
 @section('content') 
{!! Form::open(array(
	"url"   => "suppliers",
	"class" => "m-t", 
	"files"  => "true",
	"role"  => "form",
	"method"=> "post"
))!!}
  @include('suppliers.form', ['submit' => 'SUBMIT'])
{!! Form::close() !!}
 @stop
 @section('footer') 
	 <script src="{{ url('js/create_supplier.js') }}"></script>
 @stop


       
