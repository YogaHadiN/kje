
 @extends('layout.master')

 @section('title') 
{{ env("NAMA_KLINIK") }} | Buat Coa Baru

 @stop
 @section('head')
    <style>
        .nav-tabs li {
          width:50%;
        }
    </style>
 @stop
 @section('page-title') 
 <h2>Buat Coa Baru</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('coas')}}">Supplier</a>
      </li>
      <li class="active">
          <strong>Buat Akun Coa Baru</strong>
      </li>
</ol>
 @stop
 @section('content') 
 {!! Form::open(['url' => 'coas', 'method' => 'post']) !!}
	 @include('coas.form', [
		 'coa_id' => null,
		 'create' => true
	 ])
 {!! Form::close() !!}
 @stop
 @section('footer') 
	 <script type="text/javascript" charset="utf-8">
		var base = "{{ url('/') }}";
	 </script>
	 <script src="{{ url('js/create_supplier.js') }}"> </script>
	 <script src="{{ url('js/coas.js') }}"></script>
 @stop


       
