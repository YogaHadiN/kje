
@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Edit Prolanis

@stop
@section('page-title') 
<h2>Edit Prolanis</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Prolanis</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Edit Prolanis</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							{!! Form::model($prolanis, ['url' => 'prolanis/' . $prolanis->id , 'method' => 'put']) !!}
								@include('prolanis.form')
							{!! Form::close() !!}
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							{!! Form::open(['url' => 'prolanis/destroy/' . $prolanis->id, 'method' => 'post']) !!}
								<div class="form-group">
									{!! Form::submit('Delete', [
										'class' => 'btn btn-warning btn-block btn-lg',
										'onclick' => 'return confirm("Anda yakin mau menghapus Prolanis untuk pasien ini ");'
									]) !!}
								</div> 
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
	function dummySubmit(control){
		if( validatePass() ){
			$('#submit').click();
		}
	}
</script>
	
@stop

