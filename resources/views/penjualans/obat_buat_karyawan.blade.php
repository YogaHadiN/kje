@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Obat Buat Karyawan

@stop
@section('page-title') 
<h2>Obat Buat Karyawan</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Obat Buat Karyawan</strong>
      </li>
</ol>

@stop
@section('content') 
<div class="row">
{!! Form::open(['url' => 'penjualans/obat_buat_karyawan', 'method' =>'post', 'autocomplete' => 'off'])!!}
<input style="display:none"><input type="password" style="display:none">
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <div class="form-group @if($errors->has('email')) has-error @endif">
		  {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
          {!! Form::email('email' , null, ['class' => 'form-control rq']) !!}
          @if($errors->has('email')) <code> {{ $errors->first('email') }} </code> @endif
      </div>
  </div>
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <div class="form-group @if($errors->has('password')) has-error @endif">
		  {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
          {!! Form::password('password',  array('placeholder' => 'password', 'class'=>'form-control rq', 'autocomplete' => 'false'))!!}
          @if($errors->has('password')) <code> {{ $errors->first('password') }} </code> @endif
      </div>
  </div>
  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <div class="form-group @if($errors->has('tanggal')) has-error @endif">
		  {!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
          {!! Form::text('tanggal' , date('d-m-Y'), ['class' => 'form-control tanggal rq']) !!}
          @if($errors->has('tanggal')) <code> {{ $errors->first('tanggal') }} </code> @endif
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
                  <span class="">Total : </span><span class="uang " id="totalHargaObat">0</span>
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
<!-- /.modal -->
<div class="panel panel-info">
	  <div class="panel-heading">
			<div class="panel-title">
				<div class="panelLeft">
					<h3>Daftar Penjualan Obat Tanpa Resep</h3>
				</div>
			</div>
		</div>
		<div class="panel-body">
				<div class="table-responsive">
					<?php echo $nota_juals->appends(Input::except('page'))->links(); ?>
					<table class="table table-bordered table-hover" id="tabel_faktur_beli">
						<thead>
							<tr>
								<th>Nomor Faktur</th>
								<th>tanggal</th>
								<th>Nama Staf</th>
								<th>Items</th>
								<th>Total Biaya</th>
								<th colspan="2">Action</th>
							</tr>
						</thead>
						<tbody>
							@if($nota_juals->count())
								@foreach ($nota_juals as $nj)
									<tr>
										<td><div>{!!$nj->id !!}</div></td>
										<td><div>{!!App\Models\Classes\Yoga::updateDatePrep($nj->tanggal)!!}</div></td>
										<td><div>{!!$nj->staf->nama !!}</div></td>
										<td><div>{!!$nj->items !!}</div></td>
										<td class="text-right"><div>{!! App\Models\Classes\Yoga::buatrp( $nj->total ) !!}</div></td>
										<td><a class="btn btn-success btn-xs btn-block" href="{{ url('nota_juals/' . $nj->id) }}">Detail</a> </td>
										<td><a target="_blank" class="btn btn-info btn-xs btn-block" href="{{ url('pdfs/penjualan/' . $nj->id) }}">Print Struk</a> </td>
									</tr>
								@endforeach
							@else 
								<td colspan="6" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>
							@endif
						</tbody>
					</table>
					<?php echo $nota_juals->appends(Input::except('page'))->links(); ?>
				</div>
		</div>
</div>
@stop

@section('footer') 
    <script src="{{  url( 'js/penjualans2.js'   )}}" type="text/javascript" charset="utf-8"></script>
@stop

