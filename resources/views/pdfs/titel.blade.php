<div class="text-center kop-surat">
	<h1 class="min-margin">{{ \Auth::user()->tenant->name }}</h1>
	<h3 class="font-weight-normal">{{{ \Auth::user()->tenant->address_line1 }}}<br>
	{{-- <h3 class="font-weight-normal">{{ env("ALAMAT_KLINIK_LINE2") }}<br> --}}
	<h3 class="font-weight-normal">{{ \Auth::user()->tenant->address_line2 }}<br>
	<h3 class="font-weight-normal">{{ \Auth::user()->tenant->address_line3 }}<br>
	<hr>
</div>
