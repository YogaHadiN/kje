 @extends('layout.master')

 @section('title') 
{{ env("NAMA_KLINIK") }} | Edit Supplier

 @stop
 @section('page-title') 
 <h2>Edit Supplier</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('suppliers')}}">Supplier</a>
      </li>
      <li class="active">
          <strong>Edit Supplier</strong>
      </li>
</ol>
 @stop
 @section('content') 

 {!! Form::model($supplier, array(
		 "url"   => "suppliers/". $supplier->id,
		"class"  => "m-t",
		"role"   => "form",
		"files"  => "true",
		 "method"=> "put"
	 ))!!}

	 @include('suppliers.form', ['submit' => 'UPDATE'])
	 {!! Form::close() !!}
	 {!! Form::open(array('url' => 'suppliers/' . $supplier->id,'method' => 'DELETE'))!!} 

	 {!! Form::submit('DELETE', array(
		 'class' => 'btn btn-danger btn-block',
		 'onclick' => "return confirm('Yakin Maun Menghapus supplier " . $supplier->nama . " ?')"
	 ))!!}
 {!! Form::close() !!}
 @stop
 @section('footer') 
	{!! HTML::script('js/asuransi_upload.js')!!}
	{!! HTML::script('js/create_supplier.js')!!} 

 @stop


       
