<div class="table-responsive">
    <table class="full-width small table table-condensed table-bordered">
        <tbody>
            @if (
                    !is_null($antrian->whatsapp_registration) &&
                    $antrian->whatsapp_registration->registering_confirmation
                )
                <tr>
                    <td nowrap>Status</td>
                    <td nowrap>
                        <i class="fa fa-cogs fa-spin" aria-hidden="true"></i> 
                        Pasien sedang mengisi Form</td>
                </tr>
            @endif
            @if (!empty($antrian->no_telp))
                <tr>
                    <td nowrap>Nomor Telepon</td>
                    <td nowrap>{{ $antrian->no_telp }}</td>
                </tr>
            @endif
            @if (!empty($antrian->nama))
                <tr>
                    <td nowrap>Nama</td>
                    <td nowrap>{{ $antrian->nama }}</td>
                </tr>
            @endif
            @if (!empty($antrian->tanggal_lahir))
                <tr>
                    <td nowrap>Tanggal Lahir</td>
                    <td nowrap>{{ $antrian->tanggal_lahir->format('Y-m-d') }}</td>
                </tr>
            @endif
            @if (!empty($antrian->alamat))
                <tr>
                    <td nowrap>Alamat</td>
                    <td nowrap>{{ $antrian->alamat }}</td>
                </tr>
            @endif
            @if (!empty($antrian->registrasi_pembayaran_id))
                <tr>
                    <td nowrap>Pembayaran</td>
                    <td nowrap>{{ $antrian->registrasi_pembayaran->pembayaran }}</td>
                </tr>
            @endif
            @if (
                    !is_null($antrian->pasien) &&
                    $antrian->registrasi_pembayaran_id == 2
                )
                <tr>
                    <td nowrap><strong>Nomor BPJS</strong></td>
                    <td nowrap><strong>{{ $antrian->pasien->nomor_asuransi_bpjs }}</strong></td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <a href="{{ url('antrians/' . $antrian->id . '/edit') }}" class="btn btn-info btn-block" target="_blank" >Edit</a>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            @if( $antrian->pasien_id )
                <a href="{{ url('antrianpolis/' . $antrian->id . '/daftarkan') }}" class="btn btn-primary btn-block" target="_blank" >Proses</a>
            @endif
        </div>
    </div>
    @if(count( $antrian->registrasi_sebelumnya ))
        <h2>Pendaftaran Pasien Sebelumnya</h2>
        <table class="full-width small table table-condensed table-bordered">
            <tbody>
                @foreach ($antrian->registrasi_sebelumnya as $reg)
                    <tr>
                        <td>
                            {{ ucwords( strtolower( $reg->nama_pasien ) ) }}
                        </td>
                        <td style="width: 1%; white-space: nowrap;" >
                            <a href="{{ url('antrianpolis/antrian/' . $antrian->id. '/pasien/' . $reg->id_pasien) }}" class="btn btn-primary btn-sm" target="_blank" ><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
