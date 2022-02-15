@extends('layout.master')
@section('title') 
{{ env("NAMA_KLINIK") }} | Coa belum di set
@stop
@section('page-title') 
 <h2>Jurnal Umum</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
         <strong>Coa belum di set</strong>
      </li>
</ol>
@stop
@section('head') 
	<style type="text/css" media="all">
		.nowrap {
			white-space : nowrap;
		}
		.padding {
			padding-bottom : 14px;
		}
		.margin-top{
			margin-top:20px;
		}
		#content th:nth-child(7), #content td:nth-child(7){
			width:15%;
		}
		#content th:nth-child(1), #content td:nth-child(7){
			width:1%;
			white-space : nowrap;
		}
		#content{
			table-layout:fixed;
		}
	</style>
@stop
@section('content')

<div class="alert alert-warning">
	<h3>Mohon Perhatikan</h3>
	<p>Jangan sampai salah memasukkan COA berikut ini</p>
	<ul>
		<li>Belanja Peralatan</li>
		<li>Peralatan Bahan Bangunan</li>
		<li>Biaya Operasional Service Ac</li>
	</ul>
</div>

<div class="modal fade" id="coa_baru" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Coa Baru</h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('kelompok_coa_id'))has-error @endif">
				      {!! Form::label('kelompok_coa_id', 'Kelompok Coa', ['class' => 'control-label']) !!}
                      {!! Form::select('kelompok_coa_id', $kelompokCoaList , null, ['class' => 'form-control form-coa', 'id'=>'kelompok_coa_id']) !!}
				      @if($errors->has('kelompok_coa_id'))<code>{{ $errors->first('kelompok_coa_id') }}</code>@endif
				  </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="form-group @if($errors->has('coa_id'))has-error @endif">
				    {!! Form::label('coa_id', 'Kode COA', ['class' => 'control-label']) !!}
                      {!! Form::text('coa_id' , null, ['class' => 'form-control form-coa', 'id'=>'kode_coa', 'disabled' => 'disabled']) !!}
				    @if($errors->has('coa_id'))<code>{{ $errors->first('coa_id') }}</code>@endif
				  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				  <div class="form-group @if($errors->has('coa'))has-error @endif">
				    {!! Form::label('coa', 'Keterangan Coa', ['class' => 'control-label']) !!}
                      {!! Form::text('coa' , null, ['class' => 'form-control form-coa', 'id'=>'keterangan_coa', 'disabled' => 'disabled']) !!}
				    @if($errors->has('coa'))<code>{{ $errors->first('coa') }}</code>@endif
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
      <div class="modal-footer">
		  <div class="table-responsive">
				<table class="table table-bordered table-condensed">
				 <thead>
					 <tr>
						 <th>Coa</th>
						 <th>Keterangan Coa</th>
					 </tr>
				 </thead>
				 <tbody id="coa_list">
				 </tbody>
			 </table>
		  </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                  <h3>Coa Pengeluaran</h3>
                </div>
                <div class="panelRight">
                    <button class="btn btn-success" type="button" onclick=" $('#coa_baru').modal('show');return false;">Coa Baru</button>
                </div>
            </div>
      </div>
  <div class="panel-body">
	  <div class="table-responsive">
		<table id="content" class="table table-condensed table-bordered">
			<thead>
				<tr>
					<th class="key hide">Key</th>
					<th class="hide key">Id</th>
					<th>Tanggal</th>
					<th>Petugas</th>
					<th>Akun </th>
					<th>Nilai</th>
					<th>Chart Of Account</th>
				</tr>
			</thead>
			<tbody>
				@foreach($pengeluarans as $k=>$ju)
					@include('jurnal_umums.row', ['coa_list' => $bebanCoaList])
				@endforeach
			</tbody>
		</table>
	  </div>
  </div>
</div>
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class="panel panel-info hide">
			<div class="panel-heading">
				<div class="panel-title">Daftar AC</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Merek</th>
								<th>Keterangan Penempatan AC</th>
								<th colspan="3" class="hide"> Daftar AC</th>
							</tr>
						</thead>
						<tbody id="daftar_ac">
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@if(count( $pendapatans ) > 0)
	<div class="panel panel-primary">
		  <div class="panel-heading">
				<div class="panel-title">
					<div class="panelLeft">
					  <h3>Coa Pendapatan Lain</h3>
					</div>
				</div>
		  </div>
		  <div class="panel-body">
			  <div class="table-responsive">
				<table class="table borderless table-condensed">
					<thead>
						<tr>
							<th class="hide field_id">id</th>
							<th class="hide key">key</th>
							<th>Pendapatan</th>
							<th>Petugas</th>
							<th>Keterangan</th>
							<th>Nilai</th>
							<th>Chart Of Account</th>
							
						</tr>
					</thead>
					<tbody>
						@if(count($pendapatans) > 0)
							@foreach($pendapatans as $k=>$ju)
								@include('jurnal_umums.row', ['coa_list' => $pendapatanCoaList])
							@endforeach
						@else
							<td class="text-center" colspan="7">Tidak ada data untuk ditampilkan :p</td>
						@endif
					</tbody>
				</table>
			  </div>
		  </div>
	</div>
@endif
<div id="serviceAc">
	@include('jurnal_umums.serviceAc')
</div>
<div id="serviceAc2">
	@include('jurnal_umums.serviceAc', ['kedua' => true])
</div>

{!! Form::open(['url' => 'jurnal_umums/coa']) !!}
	{!! Form::text('route', $route, ['class' => 'form-control hide']) !!}
	{!! Form::textarea('temp', $jurnalumums, [
		'class' => 'form-control hide',
		'id'    => 'temp'
	]) !!}
	{!! Form::textarea('peralatanTemp', '[]', ['class' => 'hide form-control', 'id' => 'peralatanTemp']) !!} 
	{!! Form::textarea('serviceAcTemp', '[]', ['class' => 'hide form-control', 'id' => 'serviceAcTemp']) !!}
  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <button class="btn btn-success btn-lg btn-block" type="button" onclick="dummySubmit();return false;">Submit</button>
      <button class="btn btn-success btn-lg btn-block hide" id="submit" type="submit">Submit</button>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <a href="{{ url('jurnal_umums') }}" class="btn btn-danger btn-lg btn-block">Cancel</a>
    </div>
  </div>

{!! Form::close() !!}
<div id="formPeralatan2" class="hide">
	@include('jurnal_umums.formCoa', ['kedua' => true ])
</div>
<div id="formPeralatan" class="hide">
	@include('jurnal_umums.formCoa', ['kedua' => false ])
</div>
<div id="formAc" class="hide">
	@include('jurnal_umums.formAc')
</div>
<div id="formAc2" class="hide">
	@include('jurnal_umums.formAc', ['kedua' => true])
</div>
{!! Form::textarea('formAcInput', null, ['class' => 'form-control hide' , 'id' => 'formAcInput']) !!}	
{!! Form::textarea('formAcInput2', null, ['class' => 'form-control hide' , 'id' => 'formAcInput2']) !!}	
{!! Form::textarea('formPeralatan2', null, ['class' => 'form-control hide' , 'id' => 'formInputPeralatan2']) !!}	
{!! Form::textarea('formServiceAcInput', null, ['class' => 'form-control hide' , 'id' => 'formServiceAcInput']) !!}	
{!! Form::textarea('formServiceAcInput2', null, ['class' => 'form-control hide' , 'id' => 'formServiceAcInput2']) !!}	
@stop
@section('footer') 
{!! HTML::script('js/jurnal_umum_coa.js')!!}

@stop
