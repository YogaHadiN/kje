<tr>
	<td colspan="2">	
		{{ $kelompok }}
	</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
@if(count($peralatans) > 0)
	@foreach($peralatans as $p)
	<tr>
		<td class="border-right-none"></td>
		<td class="border-left-none">{{ $p->peralatan }} {{ $p->jumlah }} unit</td>
		<td>{{ $p->tanggal_perolehan }}</td>
		<td nowrap class="text-right">{{$p->jumlah * $p->harga_satuan }}</td>
		<td nowrap class="text-right">{{$p->jumlah * $p->harga_satuan - $p->susut_fiskal_tahun_lalu }}</td>
		<td nowrap class="text-center">GL</td>
		<td nowrap class="text-center">GL</td>
		<td nowrap class="text-right">{{$p->total_penyusutan - $p->susut_fiskal_tahun_lalu }}</td>
		<td nowrap class="text-right"></td>
	</tr>
	@endforeach
@else
<tr>
	<td colspan="2" class="text-center">---</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
@endif
