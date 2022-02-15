              <table style="width:100%" class="table table-condensed">
                <tr>
                  <th>Anamnesa</th>
                  <th>Pemeriksaan Penunjang</th>
                  <th>Terapi</th>
                </tr>
                <tr>
                  <td>{!! $periksa->anamnesa !!}</td>
                  <td>{!! $periksa->pemeriksaan_penunjang!!}</td>
                  <td>{!! $periksa->terapi_inline !!}</td>
                </tr>
            </table>
            <div class="content1">
            Diagnosa dan diagnosa tambahan : {!! $periksa->diagnosa->diagnosa !!} - {!! $periksa->diagnosa->icd10->diagnosaICD !!} <strong>({!!$periksa->diagnosa->icd10_id!!})</strong> <br>
              {!! $periksa->keterangan_diagnosa!!}
          </div>
          <table class="table table-condensed">
            <tr>
              <td nowrap>
				  <div class="table-responsive">
					<table class="table table-condensed">
					  <tr>
						<td nowrap>Nama Suami</td>
						<td nowrap>{!! $periksa->registerAnc->registerHamil->nama_suami !!}</td>
					  </tr>
					  <tr>
						<td nowrap>Buku</td>
						<td nowrap>
						  @if(isset($periksa->registerAnc->registerHamil->buku->buku))
						  {!! $periksa->registerAnc->registerHamil->buku->buku !!}
						  @else
						  Tidak Ada Buku
						  @endif
						</td>
					  </tr>
					  <tr>
						<td nowrap>Golongan Darah</td>
						<td nowrap>{!! $periksa->registerAnc->registerHamil->golongan_darah !!}</td>
					  </tr>
					  <tr>
						<td nowrap>Tinggi Badan</td>
						<td nowrap>{!! $periksa->registerAnc->registerHamil->tinggi_badan !!} cm</td>
					  </tr>
					  <tr>
						<td nowrap>BB Sebelum Hamil</td>
						<td nowrap>{!! $periksa->registerAnc->registerHamil->bb_sebelum_hamil !!} kg</td>
					  </tr>
					  <tr>
						<td nowrap>Riwayat Obstetri</td>
						<td nowrap>G{!! $periksa->registerAnc->registerHamil->g !!}P{!! $periksa->registerAnc->registerHamil->p !!}A{!! $periksa->registerAnc->registerHamil->a !!}</td>
					  </tr>
					  <tr>
						<td nowrap colspan="2">Riwayat Persalinan Sebelumnya</td>
					  </tr>
					</table>
				  </div>
              </td>
              <td nowrap>
				  <div class="table-responsive">
					<table class="table table-condensed">
					  <tr>
						<td nowrap>HPHT</td>
						<td nowrap>{!! App\Models\Classes\Yoga::updateDatePrep($periksa->registerAnc->registerHamil->hpht) !!}</td>
					  </tr>
					  <tr>
						<td nowrap>Umur Kehamilan</td>
						<td nowrap>{!! App\Models\Classes\Yoga::umurKehamilan($periksa->registerAnc->registerHamil->hpht, $periksa->created_at->format('Y-m-d')) !!}</td>
					  </tr>
					  <tr>
						<td nowrap>Rencana Penolong</td>
						<td nowrap>{!! $periksa->registerAnc->registerHamil->rencana_penolong !!}</td>
					  </tr>
					  <tr>
						<td nowrap>Rencana Tempat</td>
						<td nowrap>{!! $periksa->registerAnc->registerHamil->rencana_tempat !!}</td>
					  </tr>
					  <tr>
						<td nowrap>Rencana Pendamping</td>
						<td nowrap>{!! $periksa->registerAnc->registerHamil->rencana_pendamping !!}</td>
					  </tr>
					  <tr>
						<td nowrap>Rencana Transportasi</td>
						<td nowrap>{!! $periksa->registerAnc->registerHamil->rencana_transportasi !!}</td>
					  </tr>
					  <tr>
						<td nowrap>Rencana Pendonor</td>
						<td nowrap>{!! $periksa->registerAnc->registerHamil->rencana_pendonor !!}</td>
					  </tr>
					  <tr>
						<td nowrap>Umur Anak Terakhir</td>
						<td nowrap>{!! App\Models\Classes\Yoga::datediff($periksa->registerAnc->registerHamil->tanggal_lahir_anak_terakhir, $periksa->tanggal) !!}</td>
					  </tr>
					  <tr>
						<td nowrap>Catat di Buku KIA</td>
						<td nowrap>{!!App\Models\Classes\Yoga::returnConfirm($periksa->registerAnc->catat_di_kia) !!}</td>
						{{-- <td nowrap>{!!$periksa->registerAnc->catat_di_kia !!}</td> --}}
					  </tr>
					</table>
				  </div>
              </td>
              <td nowrap>
				  <div class="table-responsive">
					<table class="table table-condensed">
					  <tr>
						<td nowrap>Tekanan Darah</td>
						<td nowrap>
						  {!! $periksa->registerAnc->td !!} mmHg
						</td>
					  </tr>
					  <tr>
						<td nowrap>TFU</td>
						<td nowrap>
						  {!! $periksa->registerAnc->tfu !!} cm
						</td>
					  </tr>
					  <tr>
						<td nowrap>LILA</td>
						<td nowrap>
						  {!! $periksa->registerAnc->lila !!}cm
						</td>
					  </tr>
					  <tr>
						<td nowrap>BB</td>
						<td nowrap>
						  {!! $periksa->registerAnc->bb !!} kg
						</td>
					  </tr>
					  <tr>
						<td nowrap>Refleks Patella</td>
						<td nowrap>
						  {!! $periksa->registerAnc->refleksPatela->refleks_patela !!}
						</td>
					  </tr>
					  <tr>
						<td nowrap>DJJ</td>
						<td nowrap>
						  {!! $periksa->registerAnc->djj !!} bpm
						</td>
					  </tr>
					  <tr>
						<td nowrap>Kepala Thd PAP</td>
						<td nowrap>
						  {!! $periksa->registerAnc->kepalaTerhadapPap->kepala_terhadap_pap !!}
						</td>
					  </tr>
					  <tr>
						<td nowrap>Presentasi</td>
						<td nowrap>
						  {!! $periksa->registerAnc->presentasi->presentasi !!}
						</td>
					  </tr>
					  <tr>
						<td nowrap>Status Gizi</td>
						<td nowrap>
						  {!! App\Models\Classes\Yoga::statusGizi($periksa->registerAnc->lila) !!}
						</td>
					  </tr>
					</table>
				  </div>
              </td>
            </tr>
          </table>
		  <h2>Riwayat Obstetri</h2>
		  <hr />
          {!! $periksa->registerAnc->registerHamil->riwobs !!}
