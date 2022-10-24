<div class="text-center kop-surat">
	<h1 class="min-margin">{{ \Auth::user()->tenant->name }}</h1>
	<h3 class="font-weight-normal">{{ env("ALAMAT_KLINIK_LINE1") }}<br>
	{{-- <h3 class="font-weight-normal">{{ env("ALAMAT_KLINIK_LINE2") }}<br> --}}
	<h3 class="font-weight-normal">{{ env("ALAMAT_KLINIK_LINE3") }}<br>
	<h3 class="font-weight-normal">{{ env("ALAMAT_KLINIK_LINE4") }}<br>
	<hr>
</div>
