
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
	 <div class="panel panel-success">
	 	<div class="panel-heading">
	 		<div class="panel-title">Buat Coa Baru</div>
	 	</div>
	 	<div class="panel-body">
			 <div class="row">
				 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					 <div class="form-group">
						 {!! Form::label('kelompok_coa_id', 'Kelompok Coa') !!}
						 {!! Form::select('kelompok_coa_id', $kelompokCoaList , null, ['class' => 'form-control form-coa', 'id'=>'kelompok_coa_id']) !!}
					 </div>
				 </div>
				 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					 <div class="form-group">
						 {!! Form::label('coa_id', 'Kode Coa') !!}
						 {!! Form::text('coa_id' , null, ['class' => 'form-control form-coa', 'id'=>'kode_coa', 'disabled' => 'disabled']) !!}
					 </div>
				 </div>
			 </div>
			 <div class="row">
				 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					 <div class="form-group">
						 {!! Form::label('coa', 'Keterangan Coa') !!}
						 {!! Form::text('coa' , null, ['class' => 'form-control form-coa', 'id'=>'keterangan_coa', 'disabled' => 'disabled']) !!}
					 </div>
				 </div>
			 </div>
			 <div class="row">
				 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					 <button class="btn btn-success btn-block" type="button" id="submit_coa" onclick="submitCoa();return false;">Submit</button>
				 </div>
				 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					 <button class="btn btn-danger btn-block" type="button" id="cancel_coa" onclick=" $('#coa_baru').modal('hide');return false;">Cancel</button>
				 </div>
			 </div>
	 	</div>
	 </div>
	 


 @stop
 @section('footer') 
	 <script src="{{ url('js/create_supplier.js') }}"></script>
 @stop


       
