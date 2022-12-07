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
                                <td>
                                    @if( \Auth::user()->role_id == 6 )
                                        {!! Form::open(['url' => 'bayar_gajis/'. $b->id, 'method' => 'delete']) !!}
                                            @include('pengeluarans.struk_bayar_dokter')
                                            {!! Form::submit('Delete', [
                                                'class'   => 'btn btn-danger btn-xs',
                                                'onclick' => 'return confirm("Anda yakin mau menghapus gaji ' . $b->id . '-' . $b->nama_staf.'?");return false;'
                                            ]) !!}
                                        {!! Form::close() !!}
                                    @else
                                        @include('pengeluarans.struk_bayar_dokter')
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        
    </div>
    
</div>
