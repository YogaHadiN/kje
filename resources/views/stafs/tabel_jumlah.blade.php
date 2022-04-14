<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>{{ !isset($tahun) ? 'Tahun' : 'Tanggal' }}</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @if(count($jumlah) > 0)
                @foreach($jumlah as $j)
                    <tr>
                        <td>
                          @if (!isset($tahun))
                            <a href="{{ url('stafs/' . $staf->id. '/jumlah_pasien/pertahun/' . $j->tahun) }}" target="_blank">
                                {{ $j->tahun }}
                            </a>
                          @else
                            {{ $j->tanggal }}
                          @endif
                        </td>
                        <td>{{ $j->jumlah }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">Tidak ada data untuk ditampilkan</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
