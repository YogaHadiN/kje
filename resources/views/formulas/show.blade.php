@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Pasien

@stop
@section('page-title') 
Formula

@stop
@section('content') 
<div class="row">
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<div class="panel panel-primary">
		      <div class="panel-heading">
		            <div class="panel-title">
		            	<div class="panelLeft">
			                Formula ID : {!! $formula->id !!}
		            	</div>
		            	<div class="panelRight">
		  			  		{!! HTML::link('create/raks/' . $formula->id, 'Rak Baru', ['class' => 'btn btn-success'])!!}
		            	</div>
			        </div>
		      </div>
		      <div class="panel-body">
				  <div class="table-responsive">
						<table class="table table-bordered table-hover" id="tableAsuransi">
							<tbody>
								<tr>
									<th nowrap>Dijual Bebas</th>
									<td>

										@if($formula->dijual_bebas == '1')
											Ya
										@else
											Tidak
										@endif

									</td> 
								</tr>
								<tr>
									<th nowrap>Efek Samping</th>
									<td>{!! $formula->efek_samping !!}</td> 
								</tr>
								<tr>
									<th nowrap>Golongan Obat</th>
									<td>{!! $formula->golongan_obat !!}</td> 
								</tr>
								<tr>
									<th nowrap>Sediaan</th>
                                    <td>{!! $formula->sediaan->sediaan !!}</td> 
								</tr>
								<tr>
									<th nowrap>Indikasi</th>
									<td>{!! $formula->indikasi !!}</td> 
								</tr>
								<tr>
									<th nowrap>Kontraindikasi</th>
									<td>{!! $formula->kontraindikasi !!}</td> 
								</tr>
									<th nowrap>Aturan Minum</th>
									<td>{!! $formula->aturanMinum->aturan_minum !!}</td> 
								</tr>
								<tr>
									<th nowrap>Komposisi</th>
									<td>
										@foreach($formula->komposisi as $komp)
											{!!$komp->generik->generik!!} {!!$komp->bobot!!}, <br>
										@endforeach

									</td>
								</tr>
							</tbody>
						</table>
				  </div>
		            <div class="row">
		            	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		            		{!! HTML::link("formulas/". $formula->id ."/edit", 'Edit', ['class' => 'btn btn-info btn-block'])!!}
		            	</div>
	            		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		            		{!! HTML::link("mereks", 'Cancel', ['class' => 'btn btn-danger btn-block'])!!}

		            	</div>
		            </div>
		      </div>
		  </div>
  </div>
  <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
  	<div class="row">
  		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	  		<div class="panel panel-primary">
	  			  <div class="panel-heading">
	  			  	<div class="panelLeft">
	  					Rak
	  			  	</div>
	  			  	<div class="panelRight">
	  			  	</div>
	  			  </div>
	  			  <div class="panel-body">
					  <div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Rak</th>
										<th>Merek</th>
										<th>harga_beli</th>
										<th>harga_jual</th>
										<th>stok</th>
										<th>exp_date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($raks as $rk)
										@foreach ($rk->merek as $merek)
											<tr>
												<td>
												{!! HTML::link("raks/" . $rk->id, $rk->kode_rak, ['class' => 'btn btn-primary btn-xs'])!!} 
												</td>
												<td>{!! $merek->merek !!}</td>
												<td>{!! $rk->harga_beli !!}</td>
												<td>{!! $rk->harga_jual !!}</td>
												<td>{!! $rk->stok !!}</td>
												<td>{!! App\Models\Classes\Yoga::updateDatePrep($rk->exp_date) !!}</td>
												<td>
													{!! HTML::link("mereks/" . $rk->id, 'Merek Baru di ' . $rk->id, ['class' => 'btn btn-success btn-xs'])!!} 
												</td>
											</tr>
										@endforeach
									@endforeach
								</tbody>
							</table>
					  </div>
	  			  </div>
	  		</div>
  		</div>
  		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	  		<div class="panel panel-info">
	  			  <div class="panel-heading">
	  			  	<div class="panelLeft">
	  					DOSES
	  			  	</div>
	  			  	<div class="panelRight">
	  			  	</div>
	  			  </div>
	  			  <div class="panel-body">
					  <div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Berat-Badan</th>
									<th>Signa</th>
									<th>Jumlah</th>
									<th>Jumlah BPJS</th>
									<th>Jumlah Puyer Add</th>
								</tr>
							</thead>
							<tbody>
								@foreach($formula->dose as $dose)
									<tr>
										<th>{!!$dose->beratBadan->berat_badan!!}</th>
										@if (!is_null( $dose->signa_id ))
											<td>{!!$dose->signa->signa!!}</td>
										@else
											<td>Null</td>
										@endif
										<td>{!!$dose->jumlah!!}</td>
										<td>{!!$dose->jumlah_bpjs!!}</td>
										<td>{!!$dose->jumlah_puyer_add!!}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					  </div>
	  			  </div>
	  		</div>
  		</div>
  	</div>
  </div>
</div>
@include('formulas.temp')
@stop
@section('footer') 
	
@stop
