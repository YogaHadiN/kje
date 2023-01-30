@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Checkout Kasir
@stop
@section('head') 
@stop
@section('page-title') 
 <h2>Cehckout Kasir (Nota Z)</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Cehckout Kasir (Nota Z)</strong>
      </li>
</ol>
@stop
@section('content') 
@if (Session::has('print'))
    <div id="print">
    </div>
@endif
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
          <div class="panel panel-success">
              <div class="panel-heading">
                  <div class="panel-title">Informasi Kasir</div>
              </div>
              <div class="panel-body">
                  <div class="table-responsive">
                      <table class="table table-hover table-condensed">
                          <tbody>
                              <tr>
                                  <td>Modal Awal</td>
                                  <td class="uang">{{ $modal_awal }}</td>
                              </tr>
                              <tr>
                                  <td>Uang di Kasir</td>
                                  <td class="uang">{{ $uang_di_kasir }}</td>
                              </tr>
                              <tr>
                                  <td>Uang Masuk</td>
                                  <td class="uang">{{ $total_uang_masuk }}</td>
                              </tr>
                              <tr>
                                  <td>Uang Keluar</td>
                                  <td class="uang">{{ $total_uang_keluar }}</td>
                              </tr>
								<tr>
                                  <td>Tanggal Buka Kasir</td>
								  <td class="text-right">{{ $checkout->tanggal }}</td>
                              </tr>
                          </tbody>
                      </table>
                        <button class="btn btn-primary btn-lg btn-block" type="button" onclick="validate();return false;"> Checkout </button>
                       {!! Form::open(['url'=>'pengeluarans/nota_z', 'method'=> 'post']) !!} 
                           <div class="form-group">
                               {!! Form::submit('Submit', ['class' => 'hide', 'id'=>'submit']) !!}
                           </div>
                       {!! Form::close() !!}
              </div>
          </div>
      </div>
</div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        
    </div>
</div>
  <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
          <div class="panel panel-warning">
              <div class="panel-heading">
                  <div class="panel-title">Pengeluaran Kas di Kasir</div>
              </div>
              <div class="panel-body">
                  <div class="table-responsive">
                      <table class="table table-hover table-condensed table-bordered" id="pengeluarans">
                          <thead>
                              <tr>
                                  <th>Tanggal</th>
                                  <th nowrap>Nama Penerima</th>
                                  <th nowrap>Jumlah Pengeluaran</th>
                                  <th nowrap>Details</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($pengeluarans as $plr)
                              <tr>
                                  <td nowrap>{{ $plr->created_at->format('d-m-Y') }}</td>
                                  <td>
									  @if ($plr->jurnalable_type == 'App\Models\FakturBelanja')
										  @if (isset($plr->jurnalable->supplier['nama']))
										  {{ $plr->jurnalable->supplier['nama'] }}
										 @endif
									  @elseif ($plr->jurnalable_type == 'App\Models\BayarDokter')
										  {{ $plr->jurnalable->staf->nama }}
									  @elseif ($plr->jurnalable_type == 'App\Models\Pengeluaran')
										  {{ $plr->jurnalable->supplier['nama'] }}
									  @elseif ($plr->jurnalable_type == 'App\Models\BayarGaji')
										  {{ $plr->jurnalable->staf->nama }}
									  @endif
                                      
                                  </td>
                                  <td class="uang">{{ $plr->nilai }}</td>
								  <td> <a class="btn btn-info btn-xs" href=
										  @if($plr->jurnalable['belanja_id'] == 1 && $plr->jurnalable_type = 'App\Models\FakturBelanja')
											  "{{ url('pembelians/show/' . $plr->jurnalable_id) }}"
										  @else
											  "{{ url('pengeluarans/show/' . $plr->jurnalable_id) }}"
										  @endif
									  >details</a> 
								  </td>
                              </tr>
                              @endforeach
                          </tbody>
                          <tfoot>
                              <tr>
                                  <td colspan="2"><h3>Total Pengeluaran</h3></td>
                                  <td colspan="2"><h3 class="uang">{{ $totalPengeluarans }}</h1></td>
                              </tr>
                          </tfoot>
                      </table>
                  </div>
              </div>
          </div>
      </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Penerimaan</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<tbody>
							<tr>
								<td>Penerimaan Periksa Dokter</td>
								<td class="uang">{{ $tunai_periksa }}</td>
							</tr>
							<tr>
								<td>Penjualan Obat</td>
								<td class="uang">{{ $tunai_beli_obat}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Pendapatan Lain</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Sumber Uang</th>
								<th>Keterangan</th>
								<th>Nilai</th>
							</tr>
						</thead>
						<tbody>
							@if($pendapatans->count() > 0)
								@foreach($pendapatans as $p)
									<tr>
										<td>{{ $p->created_at->format('d-m-Y') }}</td>
										<td>{{ $p->sumber_uang }}</td>
										<td>{{ $p->keterangan }}</td>
										<td class="uang">{{ $p->nilai }}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td class="text-center" colspan="4">Tidak Ada Data Untuk Ditampilkan :p</td>
								</tr>
							@endif
						</tbody>
						@if($pendapatans->count() > 0)
							<tfoot>
								<tr>
									<td colspan="2"><h3>Total Pendapatan Lain</h3></td>
									<td colspan="2"><h3 class="uang">{{ $total_pendapatan_lain }}</h3></td>
								</tr>
							</tfoot>
						@endif
					</table>
				</div>
				
			</div>
		</div>
		
		
		<div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Pemasukan Modal</div>
            </div>
            <div class="panel-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Tanggal</th> 
                                <th>Nilai</th>
                                <th>Sumber Uang</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modals as $trx)
                                <tr>
									<td>{!! $trx->created_at->format('d-m-Y') !!}</td>        
									<td class="uang">{!! $trx->modal !!}</td>        
									<td>{!! $trx->coa->coa !!}</td>        
                                    <td> <a href='#' class="btn btn-info btn-xs">Detail</a> </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"><h3>Semua Modal Masuk</h3></td>        
                                <td><h3 class="uang">{{ $totalModal }}</h3></td>
                                <td> <a href='#' class="btn btn-info btn-xs">Detail</a> </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Pembayaran Asuransi</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Created At</th>
								<th>Nama Asuransi</th>
								<th>Tujuan Uang</th>
								<th>Nilai</th>
							</tr>
						</thead>
						<tbody>
							@if($pembayaran_asuransis->count() > 0)
								@foreach($pembayaran_asuransis as $pemb)
									<tr>
									<td>{{ $pemb->created_at->format('d-m-Y') }}</td>
										<td>{{ $pemb->asuransi->nama }}</td>
										<td>{{ $pemb->coa->coa }}</td>
										<td class="uang">{{ $pemb->pembayaran }}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td class="text-center" colspan="">Tidak Ada Data Untuk Ditampilkan :p</td>
								</tr>
							@endif
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"><h3>Total Pembayaran Asuransi</h3></td>
								<td colspan="2"><h3 class="uang">{{ $total_pembayaran_asuransi }}</h3></td>
							</tr>
						</tfoot>
					</table>
				</div>
				
			</div>
		</div>
		
    </div>
  </div>
  <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">List Checkout (Nota Z)</div>
                </div>
                <div class="panel-body">
                    <?php echo $checkouts->appends(Input::except('page'))->links(); ?>
                    <div class-"table-responsive">
                        <table class="table table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
									<th>Modal Awal</th>
                                    <th>Uang Keluar</th>
                                    <th>Uang Masuk</th>
                                    <th>Uang di Kasir</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkouts as $checkout)
                                <tr>
                                    <td>{{  $checkout->created_at->format('d-m-Y')  }}</td>
                                    <td>{{ $checkout->created_at->format('H:i:s') }}</td>
                                    <td class="uang">{{  $checkout->modal_awal  }}</td>
                                    <td class="uang">{{  $checkout->uang_keluar  }}</td>
                                    <td class="uang">{{  $checkout->uang_masuk  }}</td>
                                    <td class="uang">{{  $checkout->uang_di_kasir  }}</td>
                                    <td> 
                                        <a href="{{ url('pengeluarans/checkout/' . $checkout->id) }}" class="btn btn-primary btn-xs">Details</a> 
                                        <a href='{!! url("pdfs/notaz/" . $checkout->id )!!}' class="btn btn-info btn-xs">Struk</a> 
                                        <a href='{!! url("pdfs/notaz/keluar_masuk/" . $checkout->id )!!}' class="btn btn-success btn-xs">Keluar Masuk</a> 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <?php echo $checkouts->appends(Input::except('page'))->links(); ?>
                </div>
            </div>
      </div>
  </div>
 <div class="modal fade" tabindex="-1" role="dialog" id="confirm_staf">
  <div class="modal-dialog">
<input style="display:none"><input type="password" style="display:none">
    <input type="hidden" name="pasien_id" id="pasien_id_stafs" value=""> 
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Konfirmasi Staf</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger">
            <h4>Akses Terbatas</h4>
            <p>Hanya Super Administrator yang berhak mengklik</p>
        </div> 
		<div class="form-group @if($errors->has('email'))has-error @endif">
		  {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
          {!! Form::text('email' , null, ['class' => 'form-control rq', 'autocomplete' => 'off', 'id'=>'email_staf']) !!}
		  @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
		</div>
		<div class="form-group @if($errors->has('password'))has-error @endif">
		  {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
          {!! Form::password('password',  array('placeholder' => 'password', 'class'=>'form-control rq', 'autocomplete' => 'false', 'id'=>'password_staf'))!!}
		  @if($errors->has('password'))<code>{{ $errors->first('password') }}</code>@endif
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="confirmStaf();return false;">Submit</button>
        {!! Form::submit('Submit', ['class' => 'hide', 'id' => 'submit_confirm_staf', 'onclick' => 'clickThis();return false;']) !!}
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>   

@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
    $(function () {
          if( $('#print').length > 0 ){
            window.open("{{ url('pdfs/notaz/' . Session::get('print')) }}", '_blank');
          }
    });

    $('#confirm_staf').on('show.bs.modal', function(){
        $('#confirm_staf input[type!="hidden"]').val('');
    });
    $('#confirm_staf').on('shown.bs.modal', function(){
        $('#email_staf').focus();
    });

    function validate(){
       $('#confirm_staf').modal('show'); 
    }
    function confirmStaf(){
        if(validatePass()){
             $('#submit_confirm_staf').click();
        }
    }
    function clickThis(){
        $.post('{{ url("pengeluarans/confirm_staf") }}',
                { 'email' : $('#email_staf').val(), 'password' : $('#password_staf').val() },
            function (data, textStatus, jqXHR) {
                if(data == '1'){
                    $('#submit').click();
                } else if (data == '0'){
                     alert('User Belum Terdaftar');
                } else if (data == '2') {
                    alert('User tidak punya wewenang');
                } else if(data == '3'){
                    alert('kombinasi email / password salah');
                }
            }
        );
    }
</script>
@stop


