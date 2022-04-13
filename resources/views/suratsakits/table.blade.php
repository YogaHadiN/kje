<div class="table-responsive">
    <table class="table table-bordered table-hover table-condensed">
        <thead>
            <tr>
                <th>Tanggal Izin</th>
                <th>Berapa Hari</th>
                <th>Pemeriksa</th>
                <th>Diagnosa</th>
                <th>Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @if(count($ss) > 0)
                @foreach($ss as $s)
                    <tr>
                        <td>{{ App\Models\Classes\Yoga::updateDatePrep(  $s->tanggal )}}</td>
                        <td>{{ $s->jumlah_hari }} hari</td>
                        <td>{{ $s->nama_dokter }}</td>
                        <td>{{ $s->diagnosa }} - {{ $s->icd }}</td>
                        <td>{{ $s->pembayaran }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="5">Tidak Ada Data Untuk Ditampilkan :p</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
