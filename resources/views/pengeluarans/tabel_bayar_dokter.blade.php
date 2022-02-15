<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Pembayaran Dokter</div>
            </div>
            <div class="panel-body">
                <div class-"table-responsive">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Tanggal Dibayar</th>
                                <th>Nama Dokter</th>
                                <th>Periode</th>
                                <th>Nilai</th>
                                <th>Pph21</th>
                                <th>Gaji Yang Dibayarkan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bayar as $b)
                            <tr>
                                <td>{{  $b->tanggal_dibayar }}</td>
                                <td>{{  $b->nama_staf }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $b->mulai   )->format('d M') }} s/d {{ \Carbon\Carbon::createFromFormat('Y-m-d', $b->akhir   )->format('d M Y') }}</td>
                                <td class="uang">{{  $b->nilai }}</td>
                                <td class="uang">
                                  @if ( empty( $b->pph21 ) )
                                    0
                                  @else
                                   {{  $b->pph21 }} 
                                  @endif
                                </td>
                                <td class="uang"> {{ $b->nilai - $b->pph21 }} </td>
                                <td> <a class="btn btn-info btn-xs" href="{{ url("pdfs/bayar_gaji_karyawan/" . $b->id) }}" target="_blank">Struk</a> </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        
    </div>
    
</div>
