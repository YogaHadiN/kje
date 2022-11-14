@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Entri Beli Obat

@stop
@section('page-title') 
<h2>Riwayat Pembelian</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('pembelians.riwayat')}}">Riwayat</a>
      </li>
      <li class="active">
          <strong>Detail</strong>
      </li>
</ol>

@stop
@section('content') 
<div class="row">
	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Upload Bukti Transfer</h3>
			</div>
			<div class="panel-body">
				{!! Form::open([
					'url'    => 'faktur_belanjas/upload_bukti_transfer/' . $fakturbelanja->id,
					'method' => 'post',
					"class"  => "m-t",
					"role"   => "form",
					"files"  => "true"
				]) !!}
					<div class="form-group{{ $errors->has('bukti_transfer') ? ' has-error' : '' }}">
						{!! Form::file('bukti_transfer') !!}
                            @if (isset($fakturbelanja) && $fakturbelanja->bukti_transfer)
                                <p>
                                    <img src="{{ \Storage::disk('s3')->url( $fakturbelanja->bukti_transfer) }}" class="img-rounded upload" alt="Responsive image">
                                </p>
                            @else
                                <p>
                                    <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" class="img-rounded upload" alt="Responsive image">
                                </p>
                            @endif
						{!! $errors->first('bukti_transfer', '<p class="help-block">:message</p>') !!}
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
							{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
		<div class="alert alert-info">
		  <strong>Petunjuk Upload Bukti Transfer</strong>
		  <ul>
			  <li></li>
		  </ul>
		</div>
	</div>
</div>

	@if($fakturbelanja->belanja_id == '4')
		@include('pembelians.show_alat')
	@else
		@include('pembelians.show_obat')
	@endif

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Jurnal Umum</h3>
	</div>
	<div class="panel-body">
		@include('jurnal_umums.jurnal_template')
	</div>
</div>
@include('obat')
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		var base = '{{ url("/") }}';
	</script>
	{{ HTML::script('js/informasi_obat.js') }}
    <script type="text/javascript" charset="utf-8">
        function dummySubmit(control){
            if(validatePass2(control)){
                $('#submit').click();
            }
        }
    </script>
@stop
