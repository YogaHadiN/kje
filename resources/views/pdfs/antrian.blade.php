<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk {{ $antrian->id }}</title>
		<link href="{!! asset('css/struk.css') !!}" rel="stylesheet">
		<style type="text/css" media="all">
h2{
	font-size : 20px;
}
h3{
	font-size : 10px;
}
.margin-top {
	margin-top: 10px;
}
.sheet {
	page-break-after: avoid !important;
}
.bold {
	font-weight: bold;
}
table {
	font-size: 13px;
	text-align: left !important;
}
.box-border{
	border: 1px solid black;
}
.underline{
	text-decoration: underline;
}
.paddingTop{
	margin-top: 20px;
}
		
</style>
    </head>
		<body>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box title-print text-center">
                    <h2 class="text-center border-top">
						Selamat Datang di
						<br />{{ env('NAMA_KLINIK') }}
					</h2>
                    <h3 class="text-center border-bottom border-top">{{ env('ALAMAT_KLINIK') }}
						 <br />{{ env('TELPON_KLINIK') }}
					</h3>
                </div>
				<h2 class="text-center">Nomor Antrian Anda Adalah :</h2>
                <table class="table table-condensed">
                    <tbody id="transaksi-print">
                        <tr>
							<td colspan="3" class="strong superbig text-center" id="biaya-print">{{ $antrian->jenis_antrian->prefix }}{{ $antrian->nomor }}</td>
                        </tr>
					</tbody>
                </table>
				<h2 class="text-center ">{{ ucwords( $antrian->jenis_antrian->jenis_antrian ) }}</h2>
				<h3 class="text-center ">{{ $antrian->created_at->format('d M y H:i:s') }}</h3>
				<br />
				{{-- <div class="title-print text-center"> --}}
                    {{-- <h3 class="text-center border-top"> --}}
				{{-- 		Mohon Untuk Dapat Dilingkari Dengan Benar --}}
				{{-- 	</h3> --}}
                    {{-- <h3 class="text-center border-bottom border-top"> --}}
				{{-- 	</h3> --}}

				{{-- 	<table> --}}
				{{-- 		<tbody> --}}
				{{-- 			<tr> --}}
				{{-- 				<td colspan="2">Apakah anda memiliki keluhan Demam ?</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr class="bold"> --}}
				{{-- 				<td>Ya  / Tidak</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr> --}}
				{{-- 				<td colspan="2">Apakah anda memiliki keluhan Nyeri Menelan ?</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr class="bold"> --}}
				{{-- 				<td>Ya  / Tidak</td> --}}
				{{-- 			</tr> --}}

				{{-- 			<tr> --}}
				{{-- 				<td colspan="2">Apakah anda memiliki keluhan Batuk ?</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr class="bold"> --}}
				{{-- 				<td>Ya  / Tidak</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr> --}}
				{{-- 				<td colspan="2">Apakah anda memiliki keluhan sulit mencium bau?</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr class="bold"> --}}
				{{-- 				<td>Ya  / Tidak</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr> --}}
				{{-- 				<td colspan="2">Apakah anda memiliki keluhan sesak nafas / nafas pendek / nafas terasa berat ?</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr class="bold"> --}}
				{{-- 				<td>Ya  / Tidak</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr> --}}
				{{-- 				<td colspan="2">Apakah anda memiliki keluhan sulit merasakan rasa pahit, manis, asin, atau rasa makanan / minuman ?</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr class="bold"> --}}
				{{-- 				<td>Ya  / Tidak</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr> --}}
				{{-- 				<td colspan="2">Apakah Anda sempat bepergian ke Luar Negeri dalam 14 hari terakhir</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr class="bold"> --}}
				{{-- 				<td>Ya  / Tidak</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr> --}}
				{{-- 				<td colspan="2">Apakah anda memiliki riwayat <strong>kontak</strong> dengan seseorang yang terkonfirmasi/ positif COVID 19 ?</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr class="bold"> --}}
				{{-- 				<td>Ya  / Tidak</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr> --}}
				{{-- 				<td class="box-border"> --}}
				{{-- 					<ul class="bold underline">Kontak berarti :</ul> --}}
				{{-- 					<ul>Tinggal serumah</ul> --}}
				{{-- 					<ul>Kontak tatap muka, misalnya : bercakap-cakap selama beberapa menit</ul> --}}
				{{-- 					<ul>Terkena batuk pasien terkonfirmasi</ul> --}}
				{{-- 					<ul>Berada dalam radius 2 meter selama lebih dari 15 menit dengan kasus terkonfirmasi</ul> --}}
				{{-- 					<ul>Kontak dengan cairan tubuh kasus terkonfirmasi</ul> --}}
				{{-- 				</td> --}}
				{{-- 			</tr> --}}
				{{-- 		</tbody> --}}
				{{-- 	</table> --}}
                {{-- </div> --}}
				{{-- <div class="title-print text-center"> --}}
                    {{-- <h3 class="text-center border-top"> --}}
				{{-- 		Pasien Yang Berobat : --}}
				{{-- 	</h3> --}}
				{{-- 	<table class="paddingTop"> --}}
				{{-- 		<tbody> --}}
				{{-- 			<tr> --}}
				{{-- 				<td colspan="">Nama Lengkap</td> --}}
				{{-- 				<td colspan="">:</td> --}}
				{{-- 				<td colspan=""> ..................................................</td> --}}
				{{-- 			</tr> --}}
				{{-- 			<tr> --}}
				{{-- 				<td colspan="">Tanggal Lahir</td> --}}
				{{-- 				<td colspan="">:</td> --}}
				{{-- 				<td colspan=""> ..................................................</td> --}}
				{{-- 			</tr> --}}
				{{-- 		</tbody> --}}
				{{-- 	</table> --}}
                {{-- </div> --}}
            </div>
			<h2 class="text-center border-top border-bottom margin-top">SEMOGA SEHAT SELALU</h2>
        <script src="{!! url('js/jquery-2.1.1.js') !!}"></script>
        <script type="text/javascript" charset="utf-8">
            window.print();
        </script>
	</body>
</html>
