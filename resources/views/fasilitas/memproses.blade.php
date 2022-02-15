<div class="row" id="memproses_antrian">
	<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
		<div class="widget style1 yellow-bg">
			<div class="row">
				<div class="col-xs-4">
					<i class="fa fa-cogs fa-spin fa-5x"></i>
				</div>
				<div class="col-xs-8 text-right">
					<span>Memproses antrian</span>
					<h2 class="font-bold">{{ $antrian->nomor_antrian }}</h2>
					<div class="hide" id="antrian_id">
						{{ $antrian->id }}
					</div>
				</div>
			</div>
		</div>
	</div>
	@if (!empty( $antrian->nomor_bpjs ))
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<div class="widget style1 blue-bg">
				<div class="row">
					<div class="col-xs-4">
						<i class="fa fa-cogs fa-spin fa-5x"></i>
					</div>
					<div class="col-xs-8 text-right">
						<span>Nomor BPJS</span>
						<h2 class="font-bold">{{ $antrian->nomor_bpjs }}</h2>
						@if( isset($nama_pasien_bpjs) )
							<h3 class="font-bold">
								{{ $nama_pasien_bpjs }}, {{ App\Models\Classes\Yoga::umur($tanggal_lahir_pasien_bpjs) }} tahun <button class="btn btn-info btn-xs" onclick="chosenEntry(this);return false;">proses</button>
							</h3>
							<div class="hide nama">{{ $nama_pasien_bpjs }}</div>
							<div class="hide pasien_id">{{ $pasien_id_bpjs }}</div>
							<div class="hide image">{{ $image_bpjs }}</div>
							<div class="hide nama_asuransi">{{ $nama_asuransi_bpjs }}</div>
							<div class="hide asuransi_id">{{ $asuransi_id_bpjs }}</div>
							<div class="hide tanggal_lahir_pasien">{{ $tanggal_lahir_pasien_bpjs }}</div>
							<div class="hide prolanis_dm">{{ $prolanis_dm_bpjs }}</div>
							<div class="hide prolanis_ht">{{ $prolanis_ht_bpjs }}</div>
						@endif
						<div class="hide" class="antrian_id">
							{{ $antrian->id }}
						</div>
						<div class="hide" id="antrian_id">
							{{ $antrian->id }}
						</div>
					</div>
				</div>
			</div>
		</div>
		
	@endif
	{{-- @if( isset( $antrian->whatsapp_registration ) ) --}}
	{{-- 	<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9"> --}}
	{{-- 		<div class="table-responsive"> --}}
	{{-- 			<table class="table table-hover table-condensed table-bordered"> --}}
	{{-- 				<thead> --}}
	{{-- 					<tr> --}}
	{{-- 						<th>Nama</th> --}}
	{{-- 						<th>Tanggal Lahir</th> --}}
	{{-- 						<th>No Telp</th> --}}
	{{-- 						<th>Pembayaran</th> --}}
	{{-- 						@if( $antrian->whatsapp_registration->pembayaran == 'b' ) --}}
	{{-- 							<td>Nomor Asuransi</td> --}}
	{{-- 						@endif --}}
	{{-- 					</tr> --}}
	{{-- 				</thead> --}}
	{{-- 				<tbody> --}}
	{{-- 					<tr> --}}
	{{-- 						<td>{{ $antrian->whatsapp_registration->nama }}</td> --}}
	{{-- 						<td>{{ $antrian->whatsapp_registration->tanggal_lahir }}</td> --}}
	{{-- 						<td>{{ $antrian->whatsapp_registration->no_telp }}</td> --}}
	{{-- 						<td>{{ $antrian->whatsapp_registration->nama_pembayaran }}</td> --}}
	{{-- 						@if( $antrian->whatsapp_registration->pembayaran == 'b' ) --}}
	{{-- 							<td>{{ $antrian->whatsapp_registration->nomor_bpjs }}</td> --}}
	{{-- 						@endif --}}
	{{-- 					</tr> --}}
	{{-- 				</tbody> --}}
	{{-- 			</table> --}}
	{{-- 		</div> --}}
	{{-- 		<div class="alert alert-danger"> --}}
	{{-- 			<h3>Keluhan Peringatan COVID</h3> --}}
	{{-- 			<ul> --}}
	{{-- 				@if ( $antrian->whatsapp_registration->demam  ) --}}
	{{-- 					<li>Demam</li> --}}		
	{{-- 				@endif --}}
	{{-- 				@if ( $antrian->whatsapp_registration->batuk_pilek  ) --}}
	{{-- 					<li>Batuk Pilek</li> --}}		
	{{-- 				@endif --}}
	{{-- 				@if ( $antrian->whatsapp_registration->nyeri_menelan  ) --}}
	{{-- 					<li>Nyeri Menelan</li> --}}		
	{{-- 				@endif --}}
	{{-- 				@if ( $antrian->whatsapp_registration->sesak_nafas  ) --}}
	{{-- 					<li>Sesak Nafas</li> --}}		
	{{-- 				@endif --}}
	{{-- 				@if ( $antrian->whatsapp_registration->kontak_covid  ) --}}
	{{-- 					<li>Kontak COVID +</li> --}}		
	{{-- 				@endif --}}
	{{-- 			</ul> --}}
	{{-- 		</div> --}}
	{{-- 	</div> --}}
	{{-- @endif --}}
</div>
