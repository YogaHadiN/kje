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
            @if (isset($antrian->no_telp))
                <tr>
                    <td nowrap>Nomor Telepon</td>
                    <td nowrap>{{ $antrian->no_telp }}</td>
                </tr>
            @endif
            @if (isset($antrian->nama))
                <tr>
                    <td nowrap>Nama</td>
                    <td nowrap>{{ $antrian->nama }}</td>
                </tr>
            @endif
            @if (isset($antrian->tanggal_lahir))
                <tr>
                    <td nowrap>Tanggal Lahir</td>
                    <td nowrap>{{ $antrian->tanggal_lahir->format('Y-m-d') }}</td>
                </tr>
            @endif
            @if (isset($antrian->alamat))
                <tr>
                    <td nowrap>Alamat</td>
                    <td nowrap>{{ $antrian->alamat }}</td>
                </tr>
            @endif
            @if (isset($antrian->registrasi_pembayaran_id))
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
</div>
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <a href="{{ url('antrians/' . $antrian->id . '/edit') }}" class="btn btn-info btn-block" target="_blank" >Edit</a>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            @if( $antrian->pasien_id )
                <button  class="btn btn-primary btn-block">Proses</a>
            @endif
        </div>
    </div>
