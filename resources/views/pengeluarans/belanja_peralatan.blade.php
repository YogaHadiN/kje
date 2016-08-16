@extends('layout.master')

@section('title') 
Klinik Jati Elok | Belanja Peralatan

@stop
@section('page-title') 
<h2>Belanja Peralatan</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Belanja Peralatan</strong>
      </li>
</ol>
@stop
@section('content') 
{!! Form::open(['url' => 'pengeluarans/belanja/peralatan/bayar', 'method' => 'post']) !!}
<div class="row">
	<div class="col-xs12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group" @if($errors->has('staf_id')) class="has-error" @endif>
						  {!! Form::label('staf_id', 'Petugas') !!}
						  {!! Form::select('staf_id' , App\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true']) !!}
						  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group" @if($errors->has('tanggal_pembelian')) class="has-error" @endif>
						  {!! Form::label('tanggal_pembelian', 'Tanggal Pembelian') !!}
						  {!! Form::text('tanggal_pembelian' , date('d-m-Y'), ['class' => 'form-control tanggal rq']) !!}
						  @if($errors->has('tanggal_pembelian'))<code>{{ $errors->first('tanggal_pembelian') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group" @if($errors->has('nomor_faktur')) class="has-error" @endif>
						  {!! Form::label('nomor_faktur', 'Nomor Faktur') !!}
						  {!! Form::text('nomor_faktur' , null, ['class' => 'form-control rq']) !!}
						  @if($errors->has('nomor_faktur'))<code>{{ $errors->first('nomor_faktur') }}</code>@endif
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group" @if($errors->has('supplier_id')) class="has-error" @endif>
						  {!! Form::label('supplier_id', 'Nama Supplier') !!}
						  {!! Form::select('supplier_id' , App\Classes\Yoga::supplierList(), null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true']) !!}
						  @if($errors->has('supplier_id'))<code>{{ $errors->first('supplier_id') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group" @if($errors->has('sumber_uang')) class="has-error" @endif>
						  {!! Form::label('sumber_uang', 'Sumber Uang') !!}
						  {!! Form::select('sumber_uang' , App\Classes\Yoga::sumberuang(), null, ['class' => 'form-control rq']) !!}
						  @if($errors->has('sumber_uang'))<code>{{ $errors->first('sumber_uang') }}</code>@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Input Peralatan</div>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<table class="table table-bordered table-condensed">
							<thead>
								<th>Peralatan</th>
								<th>Nilai</th>
								<th>Masa Pakai</th>
								<th>Action</th>
							</thead>
							<tbody id="tbody_table"></tbody>
							<tfoot>
								<td>
									<input class="form-control" type="text" name="" id="peralatan" value="" />	
								</td>
								<td>
									<div class="input-group">
										<span class="input-group-addon">Rp. </span>
										<input type="text" class="form-control " id="nilai" placeholder="" autocomplete='off' value=""/>
										<span class="input-group-addon">,00</span>
									</div>
								</td>
								<td>
									<div class="input-group">
										<input type="text" class="form-control text-right " id="masa_pakai" placeholder="" autocomplete='off' value=""/>
										<span class="input-group-addon">tahun</span>
									</div>
								</td>
								<td>
									<button class="btn btn-primary btn-sm btn-block" type="button" onclick="dummyInsert(); return false" id="dInsert">insert</button>
								</td>
							</tfoot>
						</table>
							<div class="form-group hide " @if($errors->has('temp')) class="has-error" @endif>
							  {!! Form::label('temp', 'Daftar Belanja') !!}
							  {!! Form::textarea('temp', '[]', ['class' => 'form-control rq', 'id'=>'temp']) !!}
							  @if($errors->has('temp'))<code>{{ $errors->first('temp') }}</code>@endif
							</div>
							<button class="hide" type="submit" id="submit">Submit</button>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<button class="btn btn-primary btn-block btn-lg" type="button" onclick="dummySubmit();return false">Submit</button>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<button class="btn btn-danger btn-block btn-lg" type="button" id="insert">Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@stop
@section('footer') 
	
<script type="text/javascript" charset="utf-8">
	$(function () {
		view();
		$('#dInsert').keypress(function(e){
			 var key = e.keyCode || e.which;
			 if(key == '9'){
			 	$(this).click();
				return false;
			 }
		});
	});

	function dummyInsert(){
		var peralatan = $('#peralatan').val();
		var nilai = $('#nilai').val();
		var masa_pakai = $('#masa_pakai').val();
		if(
				peralatan == '' ||
				nilai == '' ||
				masa_pakai == '' 
		  ){
			if(peralatan == ''){
				validasi('#peralatan', 'Harus Diisi');
			}

			if(nilai == ''){
				validasi('#nilai', 'harus diisi');
			}

			if(masa_pakai == ''){
				validasi('#masa_pakai', 'Harus Diisi');
			}
		}else {
			 insert();
		}
	}

	function insert(){
		var peralatan = $('#peralatan').val();
		var nilai = $('#nilai').val();
		var masa_pakai = $('#masa_pakai').val();

		var data = {
			'peralatan' : peralatan,
			'nilai' : nilai,
			'masa_pakai' : masa_pakai
		};
		var temp = $('#temp').val();
		temp = $.parseJSON(temp);
		temp.push(data);
		$('#temp').val(JSON.stringify(temp));
		view();

	}

	function view(){
		 var temp = $('#temp').val();
		 var MyArray = $.parseJSON(temp);
		 console.log('MyArray');
		 console.log(MyArray);
		 var tabel = '';
		 for (var i = 0; i < MyArray.length; i++) {
			 tabel += '<tr>';
			 tabel += '<td>' + MyArray[i].peralatan + '</td>';
			 tabel += '<td class="uang">' + MyArray[i].nilai + '</td>';
			 tabel += '<td class="text-right">' + MyArray[i].masa_pakai + ' tahun </td>';
			 tabel += '<td> <button class="btn btn-danger btn-xs btn-block" type="button" onclick="rowDel(this);return false" value="' + i + '">delete</button> </td>';
			 tabel += '</tr>'
		 }
		 $('#tbody_table').html(tabel);
		 $('#peralatan').val('');
		 $('#nilai').val('');
		 $('#masa_pakai').val('');
		 formatUang();
		 $('#peralatan').focus();
	}

	function rowDel(control){
		var i = $(control).val()
		var temp = $('#temp').val()
		temp = $.parseJSON(temp);
		temp.splice(i, 1);
		$('#temp').val(JSON.stringify(temp));
		view();
	}

	function dummySubmit(){
		 if(validatePass()){
			 $('#submit').click();
		 }
	}


	
	
	
</script>
@stop
