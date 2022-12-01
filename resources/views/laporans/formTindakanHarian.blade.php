<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Jenis Tarif</th>
                <th>Jumlah</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_biaya = 0;
            @endphp
            @if(count($data))
                @foreach($data as $k => $d)
                    @php
                        $total_biaya += $d['biaya'];
                    @endphp
                    @if( $d['biaya'] )
                    <tr>
                        <td>{{ $k }}</td>
                        <td class="text-right">{{ $d['jumlah'] }}</td>
                        <td class="text-right">{{ rupiah( $d['biaya'] ) }}</td>
                    </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td class="text-center">Tidak ada data untuk Ditampilkan</td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total Pemasukan</th>
                <th class="uang">
                    {{ rupiah( $total_biaya ) }}
                </th>
            </tr>
        </tfoot>
    </table>
</div>
