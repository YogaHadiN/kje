						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="alert alert-info">
									<h2>
										Hari Ini Tanggal {{ date('d-m-Y') }}
									</h2>
									<div class="alert alert-info">
										Pasien akan diberikan notifikasi SMS satu hari sebelum jadwal kontrol
									</div>
								</div>
							</div>
						</div>
						{!! Form::text('periksa_id', $periksa->id, ['class' => 'form-control hide']) !!}
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('tanggal'))has-error @endif">
								  {!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
								  @if( !isset($tanggal) )
									  {!! Form::text('tanggal' , null, ['class' => 'form-control tanggal rq']) !!}
								  @else
									  {!! Form::text('tanggal' , $tanggal, ['class' => 'form-control tanggal rq']) !!}
								  @endif

								  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
								@if(isset($tanggal))
									<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit();return false;">Update</button>
								@else
									<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit();return false;">Submit</button>
								@endif
									{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
								</div> 
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<a class="btn btn-warning btn-block btn-lg" href="{{ url('ruangperiksa/' . $periksa->poli) }}">Cancel</a>
							</div>
						</div>
						
