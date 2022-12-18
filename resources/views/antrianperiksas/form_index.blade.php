@foreach ($postperiksa as $periksa)
    @if( !$periksa->periksa )
        {{ $periksa }}
    @else
        <tr>
            <td class="hide antrian_periksa_id">{!! $periksa->periksa_id !!}</td>
            
            @if( \Auth::user()->tenant->nursestation_availability )
                <td>
                    @if( !is_null($periksa->antrian ) )
                        {!! $periksa->antrian->nomor_antrian !!}
                    @endif
                </td>
            @endif
     
            <td>{!! $periksa->periksa->pasien->nama !!}</td>
            <td>{!! $periksa->periksa->staf_id !!}</td> 
            <td>{!! $periksa->periksa->asuransi->nama !!}</td>
            <td>
                @if(!$periksa->periksa->suratSakit)
                    --
                @else 
                    {!!App\Models\Classes\Yoga::updateDatePrep($periksa->periksa->suratSakit->tanggal_mulai)!!} selama {!!$periksa->periksa->suratSakit->hari!!} hari
                @endif
            </td>
            <td>
                @if(!$periksa->periksa->rujukan)
                    --
                @else 
                    {!! $periksa->periksa->rujukan->tujuanRujuk->tujuan_rujuk!!} <br>
                    {!! $periksa->periksa->rujukan->complication!!}
                @endif
            </td>
            <td nowrap>
                {!! Form::open(['url' => 'periksas/kembali/' . $periksa->periksa->id, 'method' => 'post'])!!}
                @if(!$periksa->periksa->suratSakit)
                    <span>
                        <button type="button" onclick="cekMasihAda(this, {{$periksa->periksa->id}});return false;" class="btn btn-success btn-sm">Buat Surat Sakit</button>
                        <a href="{{ url('suratsakits/create/' . $periksa->periksa->id . '/' . $periksa->periksa->poli_id ) }}" class="btn btn-success btn-sm rujukan hide">Buat Surat Sakit2</a>
                    </span>
                @else
                    <span>
                        <button type="button" onclick="cekMasihAda(this, {{$periksa->periksa->id}});return false;" class="btn btn-warning btn-sm">Edit Surat Sakit</button>
                        <a href="{{ url('suratsakits/' . $periksa->periksa->suratSakit->id . '/edit'. '/' . $periksa->periksa->poli_id) }}" class="btn btn-warning btn-sm rujukan hide">Edit Surat Sakit2</a>
                    </span>
                @endif
                @if(!$periksa->periksa->rujukan)
                    <span>
                        <button type="button" onclick="cekMasihAda(this, {{$periksa->periksa->id}});return false;" class="btn btn-success btn-sm">Buat Rujukan</button>
                        <a href="{{ url('rujukans/create/' . $periksa->periksa->id. '/' . $periksa->periksa->poli_id) }}" class="btn btn-success btn-sm rujukan hide">Buat Rujukan2</a>
                    </span>
                @else
                    <span>
                        <button type="button" onclick="cekMasihAda(this, {{$periksa->periksa->id}});return false;" class="btn btn-warning btn-sm">Edit Rujukan</button>
                        <a href="{{ url('rujukans/' . $periksa->periksa->rujukan->id . '/edit'. '/' . $periksa->periksa->poli_id) }}" class="btn btn-warning btn-sm rujukan hide">Edit Rujukan2</a>
                    </span>
                @endif
                @if(!$periksa->periksa->kontrol)
                    <span>
                        <button type="button" onclick="cekMasihAda(this, {{$periksa->periksa->id}});return false;" class="btn btn-success btn-sm">Buat Janji Kontrol</button>
                        <a href="{{ url('kontrols/create/' . $periksa->periksa->id. '/' . $periksa->periksa->poli_id) }}" class="btn btn-success btn-sm rujukan hide">Buat Rujukan2</a>
                    </span>
                @else
                    <span>
                        <button type="button" onclick="cekMasihAda(this, {{$periksa->periksa->id}});return false;" class="btn btn-warning btn-sm">Edit Janji Kontrol</button>
                        <a href="{{ url('kontrols/' . $periksa->periksa->kontrol->id . '/edit'. '/' . $periksa->periksa->poli_id) }}" class="btn btn-warning btn-sm rujukan hide">Edit Rujukan2</a>
                    </span>
                @endif
                    <span>
                        <button type="button" onclick="cekMasihAda(this, {{$periksa->periksa->id}});return false;" class="btn btn-danger btn-sm">Periksa Lagi</button>
                        {!! Form::submit('Periksa Lagi2', ['class' => 'btn btn-danger btn-sm periksa hide', 'onclick' => 'return confirm("Anda Yakin mau mengembalikan ' . $periksa->periksa->pasien_id . ' - ' . $periksa->periksa->pasien->nama. ' ke ruang periksa?")']) !!}
                    </span>
              {!! Form::close() !!}
            </td>
        </tr>
    @endif
@endforeach

