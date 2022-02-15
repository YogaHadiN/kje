<div class="table-responsive">
	  <table class="table table-condensed table-hover">
		  <thead>
			  <tr>
				  <th>Nama Asuransi</th>
				  <th>Jumlah</th>
				  @foreach($polis as $k => $poli)	
					  <th>{{ $k }}</th>
				  @endforeach
			  </tr>
		  </thead>
		  <tbody>
			  @if (count($hariinis) > 0)
				  @foreach ($hariinis as $hariini)
					  <tr>
						  <td>{!! $hariini['nama_asuransi'] !!}</td>
						  <th>{!! $hariini['jumlah_hari_ini'] !!}</th>
						  @foreach($hariini['by_poli'] as $k => $poli)	
							  <td class="text-center">{{ $poli }}</td>
						  @endforeach
					  </tr>
				  @endforeach
			  @else
				  <tr>
					  <td colspan="2" class="text-center">Tidak ada data untuk ditampilkan :p</td>
				  </tr>
			  @endif
		  </tbody>
		  <tfoot>
			  <th> Jumlah </th>
			  <th>{!! count($periksa_hari_ini) !!}</th>
				  @foreach ($polis as $poli)
					  <th class="text-center">{{ $poli }}</th>
				  @endforeach
		  </tfoot>
	  </table>
  </div>
