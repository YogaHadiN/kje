 @extends('layout.master')

 @section('title') 
{{ env("NAMA_KLINIK") }} | Edit Coa
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
          <strong>Buat Akun Coa Baru</strong>
      </li>
</ol>
 @stop
 @section('content') 
	 {!! Form::model( $coa, ['url' => 'coas/'.$coa->id, 'method' => 'put']) !!}
	 @include('coas.form', [
		 'coa_id'=> $coa->id,
		 'create' => false
	 ])
 {!! Form::close() !!}

 @stop
 @section('footer') 
	 <script type="text/javascript" charset="utf-8">
		var base = "{{ url('/') }}";
	 </script>
	 <script src="{{ url('js/create_supplier.js') }}"> </script>
	 <script src="{{ url('js/coas_edit.js') }}"></script>
 @stop


       
