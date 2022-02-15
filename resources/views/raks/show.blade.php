@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Pasien

@stop
@section('page-title') 
rak
 <h2>Rak</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('mereks')}}">Merek</a>
      </li>
      <li class="active">
          <strong>Rak</strong>
      </li>
</ol>

@stop
@section('content') 
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="panel panel-primary">
		      <div class="panel-heading">
		            <div class="panel-title">
		            	<div class="panelLeft">
			                <h3>Rak ID : {!! $rak->id !!}</h3>
		            	</div>
		            	<div class="panelRight">
		  			  		{!! HTML::link('create/mereks/' . $rak->id, 'Merek Baru', ['class' => 'btn btn-success'])!!}
		            	</div>
			        </div>
		      </div>
		      <div class="panel-body">
				  <div class="table-responsive">
						<table class="table table-bordered table-hover" id="tableAsuransi">
							<tbody>
								<tr>
									<th>alternatif_fornas</th>
									<td> {!! $rak->alternatif_fornas !!} </td>
								</tr> 
								<tr>
									<th>exp_date</th>
									<td> {!! App\Models\Classes\Yoga::updateDatePrep($rak->exp_date) !!} </td>
								</tr> 
								<tr>
									<th>fornas</th>
									<td> 
										@if ($rak->fornas == '1')
											Ya
										@else
											Tidak
										@endif
									</td>
								</tr> 
								<tr>
									<th>harga_beli</th>
									<td>Rp. {!! $rak->harga_beli !!},- </td>
								</tr> 
								<tr>
									<th>harga_jual</th>
									<td>Rp.  {!! $rak->harga_jual !!},- </td>
								</tr> 
								<tr>
									<th>formula_id</th>
									<td> {!! $rak->formula_id !!} </td>
								</tr> 
								<tr>
									<th>stok</th>
									<td> {!! $rak->stok !!} </td>
								</tr> 
								<tr>
									<th>stok_minimal</th>
									<td> {!! $rak->stok_minimal !!} </td>
								</tr>  
								<tr>
									<th>Kelas Obat</th>
									<td> {!! $rak->kelasObat->kelas_obat !!} </td>
								</tr>
								<tr>
									<th>merek</th>
									<td> 

										@foreach ($rak->merek as $mrk)
											{!! $mrk->merek !!}, 
										 @endforeach 

									</td>
								</tr> 
							</tbody>
						</table>
				  </div>
		            <div class="row">
		            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		            		{!! HTML::link("raks/". $rak->id ."/edit", 'Edit', ['class' => 'btn btn-info btn-block'])!!}
		            	</div>
		            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		            		{!! HTML::link("mereks", 'Cancel', ['class' => 'btn btn-warning btn-block'])!!}
		            	</div>
		            </div>
		      </div>
		  </div>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-primary">
		      <div class="panel-heading">
		            <div class="panel-title">
		                <h3>Formula ID : {!! $formula->id !!}</h3>
			        </div>
		      </div>
		      <div class="panel-body">
				  <div class="table-responsive">
						<table class="table table-bordered table-hover" id="tableAsuransi">
							<tbody>
								<tr>
									<th>dijual_bebas</th>
									<td>

										@if($formula->dijual_bebas == '1')
											Ya
										@else
											Tidak
										@endif

									</td> 
								</tr>
								<tr>
									<th>efek_samping</th>
									<td>{!! $formula->efek_samping !!}</td> 
								</tr>
								<tr>
									<th>golongan_obat</th>
									<td>{!! $formula->golongan_obat !!}</td> 
								</tr>
								<tr>
									<th>sediaan</th>
									<td>{!! $formula->sediaan !!}</td> 
								</tr>
								<tr>
									<th>indikasi</th>
									<td>{!! $formula->indikasi !!}</td> 
								</tr>
								<tr>
									<th>kontraindikasi</th>
									<td>{!! $formula->kontraindikasi !!}</td> 
								</tr>
								<tr>
									<th>Komposisi</th>
									<td>
										@foreach($formula->komposisi as $komp)
											{!!$komp->generik->generik!!} {!!$komp->bobot!!}, 
										@endforeach

									</td>
								</tr>
							</tbody>
						</table>
				  </div>
		      </div>
		  </div>
  </div>
</div>

@include('formulas.temp')
@stop
@section('footer') 
	
@stop
