<div class="panel panel-default">
      <div class="panel-body">
            @include('fotoPasien', ['pasien' => $periksa->pasien])
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>Periksa ID : </td>
                            <td>{!! $periksa->id !!}</td>
                        </tr>
                        <tr>
                            <td>Pembayaran</td>
                            <td>{!! $periksa->asuransi->nama !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
      </div>
</div>
