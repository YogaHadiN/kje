@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Terapi Pasien

@stop
@section('page-title') 
<h2>Terapi Pasien</h2>
<ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Terapi Pasien</strong>
      </li>
</ol>

@stop
@section('content') 


<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-info">
      <div class="panel-heading">
        <div class="panelLeft">
          <h3>Informasi Pasien</h3>
        </div>
        <div class="panelRight">
          <h3>{!! $periksa_id !!}</h3>
        </div>

      </div>
      <div class="panel-body">
		  <div class="table-responsive">
			<table class="table table-condensed">
			  <tbody>
				<tr>
				  <td>Nama</td>
				  <td>{!! $terapis->first()->periksa->pasien->nama !!}</td>
				</tr>
				<tr>
				  <td>Pembayaran</td>
				  <td>{!! $terapis->first()->periksa->asuransi->nama !!}</td>
				</tr>
				<tr>
				  <td>Pembayaran tunai</td>
				  <td class="uang">{!! $terapis->first()->periksa->tunai !!}</td>
				</tr>
				<tr>
				  <td>Pembayaran Piutang</td>
				  <td class="uang">{!! $terapis->first()->periksa->piutang !!}</td>
				</tr>
				<tr>
				  <td>Dokter</td>
				  <td>{!! $terapis->first()->periksa->staf->nama !!}</td>
				</tr>
			  </tbody>
			</table>
		  </div>
      </div>
    </div>
  </div>
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4>Transaksi</h4>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
			<table class="table table-condensed">
			  <thead>
				  <th>Jenis Tarif</th>
				  <th>Biaya</th>
			  </thead>
			  <tbody>
				  @foreach($terapis->first()->periksa->transaksii as $tr)
				  <tr>
					<td> {!! $tr->jenisTarif->jenis_tarif !!} </td>
					<td class="uang">{!! $tr->biaya!!}</td>
				  </tr>
				  @endforeach
			  </tbody>
			</table>
		  </div>
      </div>
    </div>
  </div>
</div>
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $terapis->count() !!} </h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-striped table-bordered table-hover DTi" id="tableAsuransi">
					  <thead>
						<tr>
							<th>ID</th>
							<th>Merek Obat</th>
							<th>harga beli</th>
						  <th>jumlah</th>
							<th>Biaya Item</th>
						</tr>
					</thead>
					<tbody>
						 @foreach ($terapis as $terapi)
						 <tr>
							<td>
							  {!! $terapi->id !!}
							</td>
							<td>
							 {!! $terapi->merek_id !!} - {!! $terapi->merek->merek !!}
							</td>
							<td class="uang">
							  {!! $terapi->harga_beli_satuan !!}
							</td>
							<td>
							  {!! $terapi->jumlah !!}
							</td>
							<td class="uang">
							  {!! $terapi->jumlah * $terapi->harga_beli_satuan !!}
							</td>
						 </tr>
					   @endforeach
					</tbody>
					<tfoot>
					  <tr>
						<th colspan="4">Total :</th>
						<td class="uang">{!! App\Models\Classes\Yoga::totalBiayaTerapi($terapis) !!}</td>
					  </tr>
					</tfoot>
				</table>
		  </div>
      </div>
</div>





@stop
@section('footer') 
	
@stop
