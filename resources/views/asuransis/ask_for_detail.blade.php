@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
			<img src="{{ \Storage::disk('s3')->url('img/logo.png') }}" style="width:300px;">
        @endcomponent
    @endslot

		<p>Selamat siang</p>
		<p>Terima kasih atas kerja sama yang baik selama ini. Semoga dapat terjalin kerja sama yang lebih baik untuk ke depan nya. </p>
		<p> Mohon untuk dapat diinfokan detil pembayaran pelayanan peserta kepada {{ \Auth::user()->tenant->name }} dengan rekening </p>
		<strong>
		<p>Bank Mandiri </p>
		<p>atas nama Yoga Hadi Nugroho </p>
		<p>dengan nomor rekening 0060006265940.</p> 
		</strong>
		<p>Deskripsi pembayaran tersebut adalah sebagai berikut : </p>
		<strong>
			<p>Tanggal : {{ $tanggal->format('d-m-Y') }}</p>
		<p>Deskripsi : <br>{{$deskripsi}}</p>
		<p>Nominal : {{ \App\Models\Classes\Yoga::buatrp($nilai) }}</p> 
		</strong>
		<p>
		Informasi pembayaran yang kami minta meliputi 
		</p>
		<strong>
			<ul>
				<li>Nama peserta</li>
				<li>Tanggal berobat</li>
				<li>Besaran tagihan yang dibayarkan</li>
			</ul>
		</strong>
		<br></br>
		<p>
		Apabila informasi tersebut memungkinkan.
		</p>
		<p>
		Atas perhatian dan kerja sama nya kami ucapkan terimakasih
		</p>
		<br></br>
    <!-- Body here -->
	<small>
		<p> <strong>Halida Gustina </strong></p>
		<p> Finance Division</p>
		<p> 085778915500 </p>
	</small>
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
			&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
