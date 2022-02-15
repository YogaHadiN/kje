<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-body text-center">
                @include('fotoPasien', ['pasien' => $pasien])
            </div>
        </div>
    </div>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
       <div class="panel panel-info">
              <div class="panel-heading">
                <div class="panel-title">
                    <div class="row">
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
							@if($periksa != null)
								@if(!$pasien->periksa->count() == 0)
								<h4>
									Tanggal {!! App\Models\Classes\Yoga::updateDatePrep($periksa->tanggal) !!} 
									 |
								  Pemeriksa : 
									@if($periksa->staf)
										<strong>{!! $periksa->staf->nama !!}</strong> <br><br>
									@endif
								</h4>
								@endif
							@endif
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-right">

							@if($periksa != null)
								@if( $pasien->periksa->count() > 0 )
								   <a href="{!! url('pasiens/' . $antrianperiksa->pasien_id) !!} " class="btn btn-success" target="_blank">Semua Riwayat</a>
							   @else
								   <a href="#" class="btn btn-success" onclick="alert('Tidak ada riwayat untuk ditampilkan'); return false;">Semua Riwayat</a>
								@endif
						   @else
							   <a href="#" class="btn btn-success" onclick="alert('Tidak ada riwayat untuk ditampilkan'); return false;">Semua Riwayat</a>
							@endif
                        </div>
                    </div>
                </div>
              </div>
             <div class="panel-body text-small">
				 @if($periksa != null)
					@if($pasien->periksa->count() == 0)
						<p class="text-center">Tidak ada Riwayat untuk ditampilkan / Pasien adalah pasien baru</p>
					@else
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<table class="table table-condensed">
									<tbody>
										<tr>
											<td>
												Pembayaran : <br>
												<strong>{!! $periksa->asuransi->nama!!}</strong><br><br>
											</td>
											<td>
												Umur : <br> <strong>{!! App\Models\Classes\Yoga::datediff($periksa->pasien->tanggal_lahir->format('Y-m-d'), $periksa->tanggal);!!}</strong><br><br>
											</td>
										</tr>
										<tr>
											<td>
												<strong>Anamnesa :</strong> <br>
												{!! $periksa->anamnesa !!} <br>
												<strong>Pemeriksaan Fisik, Penunjang dan Tindakan :</strong> <br><br>
												@if($periksa->pemeriksaan_fisik != '')
													{!! $periksa->pemeriksaan_fisik !!} <br>
												@endif
												Tekanan Darah <br />
												{!! $periksa->sistolik !!}/{!! $periksa->diastolik !!}<br><br>
												@if($periksa->pemeriksaan_penunjang != '')
													{!! $periksa->pemeriksaan_penunjang !!}<br>
												@endif
												<strong>Diagnosa :</strong> <br>
												@if($periksa->diagnosa_id)
												{!! $periksa->diagnosa->diagnosa !!} - {!! $periksa->diagnosa->icd10->diagnosaICD !!}
												@endif

												<br>
												<br>
												{!! $periksa->id !!}

										@if($periksa->usg)
											<a href="{{ url('usgs/'.$periksa->id) }}">USG</a>
										@endif

										@if($periksa->ancs)
											<a href="{{ url('ancs/'.$periksa->id) }}">USG</a>
										@endif
										@if($periksa->rujukan)
										<hr>
											<div class="alert alert-warning">
											  dirujuk ke 
											  @if(isset($periksa->rujukan->tujuanRujuk))
												  {!! $periksa->rujukan->tujuanRujuk->tujuan_rujuk !!} <br>
											  @endif
											  karena {!!$periksa->rujukan->complication !!}
											</div>
											<a href="{{ url('rujukans/'.$periksa->id) }}">Show Rujukan</a>
										  @endif

										  @if($periksa->suratSakit)
											<div class="alert alert-success">
												{!! App\Models\Classes\Yoga::suratSakit($periksa) !!}
											</div>
											@endif
											</td>
											<td>{!! $periksa->terapi_html !!}</td>
										</tr>
									</tbody>
								</table>
								<textarea name="" id="terapiTemp" cols="30" rows="10" class="displayNone">{!! $periksa->terapi !!}</textarea>
							</div>
						</div>
						@if($periksa->gambars->count() > 0)
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								
									<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
									  <!-- Indicators -->
									  <ol class="carousel-indicators">
										  @foreach($periksa->gambars as $k => $gambar)
											<li data-target="#carousel-example-generic" data-slide-to="{{ $k }}"@if($k == 0) class="active"@endif></li>
										  @endforeach
									  </ol>
									
									  <!-- Wrapper for slides -->
									  <div class="carousel-inner" role="listbox">
										@foreach($periksa->gambars as $k => $gambar)
										<div class="item @if($k == 0) active @endif">
											<img src="{{ \Storage::disk('s3')->url('img/estetika/'.$gambar->nama ) }}" class="upload" alt="...">
										  <div class="carousel-caption">
											<h3>{{ $gambar->keterangan }}</h3>
										  </div>
										</div>
										@endforeach
									  </div>
									
									  <!-- Controls -->
									  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
										<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
										<span class="sr-only">Previous</span>
									  </a>
									  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
										<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
										<span class="sr-only">Next</span>
									  </a>
									</div>
								</div>
							</div>
						@endif
					@endif
				@else
					<p class="text-center">Tidak ada Riwayat untuk ditampilkan / Pasien adalah pasien baru</p>
				@endif
             </div>
       </div>
    </div>   
</div>   
