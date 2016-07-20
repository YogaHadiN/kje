 @extends('layout.master')

 @section('title') 
Klinik Jati Elok | Edit Supplier

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

	 <div class="row">
		 <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
			 {!! Form::model($supplier, array(
					 "url"   => "suppliers/". $supplier->id,
					 "class" => "m-t", 
					 "role"  => "form",
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
		 </div>
	 </div>

 @stop
 @section('footer') 
{!! HTML::script('js/create_supplier.js')!!} 

 @stop


       
