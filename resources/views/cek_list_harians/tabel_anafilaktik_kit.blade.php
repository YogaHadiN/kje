<div class="float-right">
    <a href="{{ url('cek_harian_anafilaktik_kits/' . $ruangan->id . '/create') }}" class="btn btn-info" target="_blank"> 
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        Buat Baru
    </a>
</div>
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Epinefrin</th>
                <th>Dexa</th>
                <th>Ranitidin</th>
                <th>Difenhidramin</th>
                <th>Spuit 3 cc</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
                @if($cek_harian_anafilaktik_kits->count() > 0)
                    @foreach($cek_harian_anafilaktik_kits as $cek)
                        <tr>
                            <td nowrap>{{ $cek->created_at->format('Y M d') }}</td>
                            <td class="text-right">{{ $cek->jumlah_epinefrin_inj }}</td>
                            <td class="text-right">{{ $cek->jumlah_dexamethasone_inj }}</td>
                            <td class="text-right">{{ $cek->jumlah_ranitidine_inj }}</td>
                            <td class="text-right">{{ $cek->jumlah_diphenhydramine_inj }}</td>
                            <td class="text-right">{{ $cek->jumlah_spuit_3cc }}</td>
                            <td nowrap class="autofit">
                                {!! Form::open(['url' => 'cek_harian_anafilaktik_kits/' . $cek->id, 'method' => 'delete']) !!}
                                    <a class="btn btn-warning btn-sm" href="{{ url('cek_harian_anafilaktik_kits/' . $cek->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $cek->id }}  ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="16" class="text-center">Tidak ada data untuk ditampilkan</td>
                    </tr>
                @endif
            
        </tbody>
    </table>
</div>
