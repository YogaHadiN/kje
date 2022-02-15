@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Entri Jual Obat

@stop
@section('head') 
	<style type="text/css" media="all">
		.input-group {
			color:#676A8B;
		}
	</style>

@stop
@section('page-title') 
<h2>Penjualan Obat Tanpa Resep</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Penjualan Tanpa Resep</strong>
      </li>
</ol>

@stop
@section('content') 
@if (Session::has('print'))
<div id="print-struk" class="hide">
    <a target="_blank" id="print_button" class="btn btn-primary" href="{{ url('pdfs/penjualan/' . Session::get('print')) }}">Print Struk</a>
</div>
@endif
<div class="row">
  {!! Form::open(['url' => 'penjualans', 'method' =>'post'])!!}
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <div class="form-group @if($errors->has('staf_id')) has-error @endif">
	  {!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
      {!! Form::select('staf_id', $stafs, null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true'])!!}
      @if($errors->has('staf_id'))
          <code>
              {{ $errors->first('staf_id') }}
          </code>
      @endif
    </div>
  </div>
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
	  <div class="form-group @if($errors->has('tanggal'))has-error @endif">
	    {!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
        {!! Form::text('tanggal', date('d-m-Y'), ['class' => 'form-control tanggal rq']) !!}
	    @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
	  </div>
  </div>
  
</div>
<br>
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                </div>
                <div class="panelRight bold">
					<div class="row">
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
							  <span class="">Total : </span>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
						  <div class="input-group">
							<span class="input-group-addon">Rp. </span>
							<input type="text" class="form-control" name="total_harga"  id="totalHargaObat">
							<span class="input-group-addon">Bisa Diedit</span>
						  </div>
						</div>
					</div>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered table-hover" id="tableEntriBeli" nowrap>
					  <thead>
						<tr>
						   <th>No</th>
						   <th>Merek Obat</th>
						   <th class="displayNone">Harga Beli</th>
						   <th>Harga Jual</th>
						   <th>Exp Date</th>
						   <th>Jumlah</th>
						   <th nowrap>Harga Item</th>
						   <th>Action</th>
						</tr>
					</thead>
					<tbody>
					  
					</tbody>
					  <tfoot>
						<tr>
						  <td colspan="2">{!! Form::select('merek_id', $mereks, null, ['class' => 'form-control selectpick', 'data-live-search' => 'true', 'id' => 'ddl_merek_id', 'onchange' => 'ddlChange(this)'])!!}</td>
						   <td class="displayNone"><input type="text" id="txt_harga_beli" class="form-control" placeholder="harga beli"/></td>
						   <td><input type="text" id="txt_harga_jual" class="form-control" placeholder="harga jual" disabled/></td>
						   <td><input type="text" id="txt_exp_date" class="form-control tanggal" placeholder="exp date" disabled/></td>
						   <td><input type="text" id="txt_jumlah" class="form-control" placeholder="jumlah"/></td>
						   <td colspan="2"><button type="button" id="btn_Action" class="btn btn-primary btn-sm btn-block" onclick="input(this);return false;">input</buttomn></td>
						</tr>
					</tfoot>
				</table>
		  </div>
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <button class="btn btn-primary btn-lg btn-block" type="button" onclick="dummySubmit();return false;">Submit</button>
                  {!! Form::submit('Submit', ['class' => 'btn btn-lg btn-block btn-primary hide', 'id'=>'submit'])!!} 
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="" class="btn btn-lg btn-block btn-danger">Cancel</a>
              </div>
            </div>
            <div class="hide form-group @if($errors->has('tempBeli')) has-error @endif">
			{!! Form::label('tempBeli', 'Barang Belanjaan', ['class' => 'control-label']) !!}
                {!! Form::textarea('tempBeli' , null, ['class' => 'form-control rq', 'id' => 'tempBeli']) !!}
                @if($errors->has('tempBeli'))
                  <code>
                      {{ $errors->first('tempBeli') }}
                  </code>
                @endif
            </div>
          {!! Form::close()!!}
      </div>
</div>
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Penjualan Tanpa Resep</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<?php echo $nota_juals->appends(Input::except('page'))->links(); ?>
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Jam</th>
								<th>Petugas</th>
								<th>Items</th>
								<th>Nilai</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($nota_juals as $nj)
								<tr>
									<td>{{ $nj->created_at->format('d-m-Y') }}</td>
									<td>{{ $nj->created_at->format('H:i:s') }}</td>
									<td>{{ $nj->staf->nama }}</td>
									<td>{{ $nj->items }}</td>
									<td class="uang">{{ $nj->nilai }}</td>
									<td> 
									<a class="btn btn-success btn-xs" href="{{ url('nota_juals/'. $nj->id ) }}">Details</a>
										 <a class="btn btn-info btn-xs" href="{{ url("pdfs/penjualan/" . $nj->id) }}" target="_blank">Print Struk</a> 
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<?php echo $nota_juals->appends(Input::except('page'))->links(); ?>
				</div>
			</div>
		</div>
		
	</div>
	
</div>

@stop
@section('footer') 
    <script src="{{  url( 'js/penjualans.js'   )}}" type="text/javascript" charset="utf-8"></script>
	<script>

       $(function () {
            if( $('#print-struk').length > 0 ){
                window.open("{{ url('pdfs/penjualan/' . Session::get('print')) }}", '_blank');
            }
       }); 
	</script>
@stop
