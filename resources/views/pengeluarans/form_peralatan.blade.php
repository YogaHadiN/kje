				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('staf_id'))has-error @endif">
						  {!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
						  {!! Form::select('staf_id' , App\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true']) !!}
						  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('tanggal_pembelian'))has-error @endif">
						  {!! Form::label('tanggal_pembelian', 'Tanggal Pembelian', ['class' => 'control-label']) !!}
						  {!! Form::text('tanggal_pembelian' , date('d-m-Y'), ['class' => 'form-control tanggal rq']) !!}
						  @if($errors->has('tanggal_pembelian'))<code>{{ $errors->first('tanggal_pembelian') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('nomor_faktur'))has-error @endif">
						  {!! Form::label('nomor_faktur', 'Nomor Faktur', ['class' => 'control-label']) !!}
						  {!! Form::text('nomor_faktur' , null, ['class' => 'form-control rq']) !!}
						  @if($errors->has('nomor_faktur'))<code>{{ $errors->first('nomor_faktur') }}</code>@endif
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('supplier_id'))has-error @endif">
						  {!! Form::label('supplier_id', 'Nama Supplier', ['class' => 'control-label']) !!}
						  {!! Form::select('supplier_id' , App\Classes\Yoga::supplierList(), null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true']) !!}
						  @if($errors->has('supplier_id'))<code>{{ $errors->first('supplier_id') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('sumber_uang'))has-error @endif">
						  {!! Form::label('sumber_uang', 'Sumber Uang', ['class' => 'control-label']) !!}
						  {!! Form::select('sumber_uang' , App\Classes\Yoga::sumberuang(), null, ['class' => 'form-control rq']) !!}
						  @if($errors->has('sumber_uang'))<code>{{ $errors->first('sumber_uang') }}</code>@endif
						</div>
					</div>
				</div>
			
