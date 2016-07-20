 @extends('layout.master')

 @section('title') 
Klinik Jati Elok | Daftarkan Supplier

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

 <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
     
            {!! Form::open(array(
                "url"   => "suppliers",
                "class" => "m-t", 
                "role"  => "form",
                "method"=> "post"
            ))!!}
              @include('suppliers.form', ['submit' => 'SUBMIT'])
            {!! Form::close() !!}


 </div>

 @stop
 @section('footer') 
	 <script src="{{ url('js/create_supplier.js') }}"></script>
 @stop


       
