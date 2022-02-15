@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Edit Discount

@stop
@section('page-title') 
<h2>Edit Discount</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Discount</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Buat Diskon Baru</div>
				</div>
				<div class="panel-body">
				{!! Form::model($discount, ['url' => 'discounts/' . $discount->id, 'method' => 'put']) !!}
						@include('discounts.form', [
							'dimulai' => $discount->dimulai->format('d-m-Y'),
							'edit' => true,
							'berakhir' => $discount->berakhir->format('d-m-Y'),
							'asuransis' => $asuransis
						])
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(){
			if(validatePass()){
				$('#submit').click();
			}
		}
	</script>
@stop

