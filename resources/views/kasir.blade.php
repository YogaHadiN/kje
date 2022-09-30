@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Kasir
@stop
@section('page-title') 
 <h2>Kasir</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Kasir</strong>
      </li>
</ol>
@stop
@section('content') 
    
<input type="hidden" id="asuransi_id" value="{{ $periksa->asuransi_id }}">
<div class="row">
    <div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Pemeriksaan <strong>{!!$pasien->id!!} - {!!$pasien->nama!!}</strong> Saat Ini</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-wrench"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#">Config option 1</a>
                    </li>
                    <li><a href="#">Config option 2</a>
                    </li>
                </ul>
                <a class="close-link">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            @if($pasien->periksa->count() == 0)
                <p class="text-center">Tidak ada Riwayat untuk ditampilkan / Pasien adalah pasien baru</p>
            @else
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Terapi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    {!! $periksa->tanggal !!} <br><br>
                                    <strong>Pemeriksa :</strong><br>
                                    {!! $periksa->staf->nama !!} <br>
                                    <strong>ID Periksa : </strong>
                                    <span id="periksa_id">{!!$periksa->id!!}</span><br>
                                    <strong>Pembayaran : </strong>
                                    <span id="periksa_id">{!!$periksa->asuransi->nama !!}</span>
                                </td>
                                <td>
                                    <strong>Anamnesa :</strong> <br>
                                    {!! $periksa->anamnesa !!} <br>
                                    <strong>Pemeriksaan Fisik, Penunjang dan Tindakan :</strong> <br>
                                    {!! $periksa->pemeriksaan_fisik !!} <br>
                                    {!! $periksa->pemeriksaan_penunjang !!}<br>
                                    <strong>Diagnosa :</strong> <br>
                                    {!! $periksa->diagnosa->diagnosa !!} - {!! $periksa->diagnosa->icd10->diagnosaICD !!}
                                </td>
                                <td id='terapih'>{!! $periksa->terapi_html !!}
                                   @if (!empty($periksa->resepluar))
                                       <hr>
                                       <p>Resep ditebut di apotek di Luar :</p>
                                       {!! $periksa->resepluar !!}
                                   @endif
                                   
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
</div>
            {!! Form::open(['url' => 'kasir/submit', 'method' => 'post', 'autocomplete' => 'off'])!!}
                {!! Form::text('periksa_id', $periksa->id, ['class' => 'hide'])!!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-info">
                          <div class="panel-heading">
                                <h3 class="panel-title">Petunjuk : </h3>
                          </div>
                          <div class="panel-body">
                                Pada Halaman ini tugas Anda adalah menyesuaikan merek dengan asuransi / cara pembayaran, dan sesuai dengan plafon / maksimal pembayaran asuransi. <br /><strong>Khusus untuk Asuransi BPJS </strong>, pilih obat yang paling murah harganya..
                                <br />Sesuaikan juga jumlah dengan asuransi yang dimiliki. Merubah jumlah obat dalam bentuk puyer dan add sirup tidak diperbolehkan
                                <br />
                                Klik tombol <strong>Lihat Resep</strong> untuk melihat dan mencetak resep yang telah disesuaikan dengan pembayaran. <br />
                                Setelah obat disesuaikan dan status telah dicetak, klik tombol <strong>Stubmit</strong> langkah selanjutnya adalah halaman <strong> qualiy control dan survey </strong> sebelum pasien selesai.
                          </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-warning">
                      <div class="panel-heading">
                           <div class="panelLeft">
                                <h3>Edit Resep</h3>
                          </div>
                      </div>
                          <div class="panel-body">
							  <div class="table-responsive">
								<table class="table table-condensed table-hover" id="antrian_apotek">
									<thead>
										<tr>
											<th class="hide">key/th>
											<th>Merek Obat</th>
											<th>Signa</th>
											<th>Jumlah</th>
											<th>Cunam</th>
											<th>Satuan</th>
											<th>Biaya</th>
											<th class="hide">jumlah</th>
											<th class="hide">id</th>
										</tr>
									</thead>
									<tbody id="tblResep">
										@foreach ($terapis as $key => $terapi)
											<tr>
												<td class="hide key">{!! $key !!}</td>
												<td>
													<select name="" id="ddlMerekChange" class="form-control merek_jual" onchange="ddlOnChange(this);return false;">
														@foreach ($terapi->merek->rak->formula->merek_banyak as $ky => $mrk_id)
															@if ($mrk_id == $terapi['merek_id'])
                                                                <option value='{!! $mereks->find($mrk_id)->merek_jual !!}' selected>{!!$mereks->find($mrk_id)->merek !!}</option>
															@else
																<option value='{!! $mereks->find($mrk_id)->merek_jual !!}'>{!!$mereks->find($mrk_id)->merek !!}</option>
															@endif
														@endforeach
													</select>
												</td>
												<td>
												   {!! $terapi->signa !!} 
												</td>
												<td>
													<input type="text" class="form-control angka jumlah" onkeyup="jumalhEdit(this);return false;" value="{!! $terapi->jumlah !!}">
												</td>
                                                <td>
                                                    {!! Form::select('cunam',\App\Models\Cunam::pluck('cunam', 'id'), $terapi['cunam_id'], [
                                                        'class' => 'form-control rq',
                                                        'onchange' => 'cunamEdit(this);return false',
                                                        'placeholder' => '- Pilih Cunam -'
                                                    ]) !!}
												</td>
												<td class='uang harga_satuan'>
                                                    @if($periksa->asuransi->tipe_asuransi_id == '5')
														@if($terapi->merek->rak->fornas == '0')
															{!! App\Models\Classes\Yoga::kasirHargaJual($terapi, $periksa)!!}
														@else
															0     
														@endif      
													@else
														{!! App\Models\Classes\Yoga::kasirHargaJual($terapi, $periksa)!!}
													@endif
												</td>
												<td class='uang totalItem total_satuan'>
													@if($periksa->asuransi->tipe_asuransi_id == 5)
														@if($terapi->merek->rak->fornas == '0')
														{!! App\Models\Classes\Yoga::kasirHargaJualItem($terapi, $periksa)!!}
														@else
															0    
														@endif      
													@else
														{!! App\Models\Classes\Yoga::kasirHargaJualItem($terapi, $periksa)!!}
													@endif      
												</td>
												<td class="hide jumlah">{!! $terapi->jumlah !!}</td>
												<td class="hide terapi_id">{!! $terapi->id !!}</td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr>
											@if($periksa->asuransi->tipe_asuransi_id == 4)
												@if($plafon < 0)
													<td class="red"> Plafon kurang <br> : {{ $plafon }}</td>
													<td class="text-right" colspan='4'><strong><h2>Total Biaya Obat : <span class="uang" id='biaya'>{!!$biayatotal !!}</span></h2></strong></td>
												@else
													  <td class="text-right" colspan='5'><strong><h2>Total Biaya Obat : <span class="uang" id='biaya'>{!!$biayatotal !!}</span></h2></strong></td>
												@endif
											@else 
												<td class="text-right" colspan='5'><strong><h2>Total Biaya Obat : <span class="uang" id='biaya'>{!!$biayatotal !!}</span></h2></strong></td>
											@endif
										</tr>
									</tfoot>
								</table>
							  </div>
                                @if (!empty($periksa->resepluar))
                                <hr>
                                <p>Resep ditebut di apotek di Luar :</p>
                                {!! $periksa->resepluar !!}
                                @endif
                          </div>
                    </div>
                   <div class="row">
                       <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						   {!! Form::textarea('terapi1', $periksa->terapii, ['class' => 'form-control hide', 'id' => 'terapi1']) !!}
                       </div>
                       <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                           {!! Form::textarea('terapi2', null, ['class' => 'form-control hide', 'id' => 'terapi2'])!!} 
                       </div>
                   </div>
                   {!! Form::text('kali_obat', $periksa->asuransi->kali_obat, [
                        'class' => 'form-control',
                        'id' => 'kali_obat'
                   ]) !!}

                   {!! Form::text('nama_poli', $periksa->poli->poli, [
                        'class' => 'form-control hide',
                        'id'    => 'nama_poli'
                   ]) !!}

                   {!! Form::text('tipe_asuransi_id', $periksa->asuransi->tipe_asuransi_id, [
                        'class' => 'form-control hide',
                        'id'    => 'tipe_asuransi_id'
                   ]) !!}

                   @if( $periksa->asuransi->tipe_asuransi_id == '5' && isset( $periksa->rujukan ) )
					   <div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="panel panel-success">
								<div class="panel-heading">
									<div class="panel-title">TACC</div>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group @if($errors->has('tacc'))has-error @endif">
											  {!! Form::label('tacc', 'Apakah Pilihan TACC keluar di rujukan Pcare?', ['class' => 'control-label']) !!}
											  {!! Form::select('tacc', [ 
												  null => ' - Pilih - ' , 
												  0    => 'Bukan Diagnosa TACC',
												  1    => 'Diagnosa adalah golongan TACC'
											  ],  $periksa->rujukan->tacc , ['class' => 'form-control', 'id' => 'tacc_muncul', 'onchange' => 'inputTaccChange();return false;']) !!}
											  @if($errors->has('tacc'))<code>{{ $errors->first('tacc') }}</code>@endif
											</div>
										</div>
									</div>
									<div class="row hide" id="inputTacc">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<h2>TACC</h2>
													<hr />
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group @if($errors->has('Time'))has-error @endif">
													  {!! Form::label('time_tacc', 'Time ( Alasan dari lama pennyakit yang mengharuskan pasien dirujuk )', ['class' => 'control-label']) !!}
													  {!! Form::textarea('time_tacc' , $periksa->rujukan->time, ['class' => 'form-control textareacustom', 'id' => 'time_tacc' ]) !!}
													  @if($errors->has('time_tacc'))<code>{{ $errors->first('Time') }}</code>@endif
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group @if($errors->has('Age'))has-error @endif">
													{!! Form::label('age_tacc', 'Age ( Alasan dari usia pasien yang mengharuskan pasien dirujuk )', ['class' => 'control-label' ]) !!}
													  {!! Form::textarea('age_tacc' , $periksa->rujukan->age, ['class' => 'form-control textareacustom', 'id' => 'age_tacc']) !!}
													  @if($errors->has('age_tacc'))<code>{{ $errors->first('Age') }}</code>@endif
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group @if($errors->has('complication_tacc'))has-error @endif">
													  {!! Form::label('complication_tacc', 'Complication ( Alasan dari faktor pemberat atau komplikasi yang mengharuskan pasien dirujuk )', ['class' => 'control-label']) !!}
													  {!! Form::textarea('complication_tacc' , $periksa->rujukan->complication, ['class' => 'form-control textareacustom', 'id' => 'complication_tacc' ]) !!}
													  @if($errors->has('complication_tacc'))<code>{{ $errors->first('compolication_tacc') }}</code>@endif
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group @if($errors->has('comorbidity_tacc'))has-error @endif">
													  {!! Form::label('comorbidity_tacc', 'Comorbidity ( Alasan dari Penyakit Penyerta yang mengharuskan pasien dirujuk )', ['class' => 'control-label']) !!}
													  {!! Form::textarea('comorbidity_tacc' , $periksa->rujukan->comorbidity, ['class' => 'form-control textareacustom', 'id' => 'comorbidity_tacc' ]) !!}
													  @if($errors->has('comorbidity_tacc'))<code>{{ $errors->first('comorbidity_tacc') }}</code>@endif
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					   </div>
				   @endif
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <button class="btn btn-success btn-block btn-lg" type="button" onclick="dummyClick(this);return false;">Submit</button>
                            {!! Form::submit('Submit', [
                                'class' => 'btn btn-success btn-block btn-lg hide',
                                'id' => 'submit',
                            ])!!}
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <a href="{!! url('antriankasirs') !!}"  class="btn btn-danger btn-block btn-lg">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close()!!}
@include('obat')
@stop
@section('footer') 
<script>
  var base = "{!! url('/') !!}";
</script>
<script src="{!! url('js/fotozoom.js') !!}" type="text/javascript"></script>
{!! HTML::script('js/informasi_obat.js')!!} 
{!! HTML::script('js/kasir_base.js')!!} 
@stop
