@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Belanja Peralatan

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
	{!! Form::open(['url' => 'pengeluarans/belanja/peralatan/bayar', 'method' => 'post', 'files' => 'true']) !!}
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class="panel panel-default">
			<div class="panel-body">
				@include('pengeluarans.form_peralatan')
			</div>
		</div>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<div class="alert alert-info">
			<h2>Panduan Mengisi Masa Pakai</h2>
			<ul>
				<li>Alat-alat medis non elektronik biasanya masa pakai 1 tahun</li>
				<li>Alat elektronik Masa Pakai biasanya 3 tahun</li>
				<li>Furnitur sekitar 5 tahun</li>
				<li>Bahan Bangunan sekitar 5 tahun</li>
			</ul>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-info">
			<div class="panel-body">
				<div class="form-group{{ $errors->has('faktur_image') ? ' has-error' : '' }}">
					{!! Form::label('faktur_image', 'Upload Gambar Faktur') !!}
					{!! Form::file('faktur_image') !!}
						@if (isset($belanja) && $belanja->faktur_image)
							<p> <img src="{{ \Storage::disk('s3')->url('img/belanja/alat/'.$belanja->faktur_image) }}" alt="" class="img-rounded upload"> </p>
						@else
							<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
						@endif
					{!! $errors->first('faktur_image', '<p class="help-block">:message</p>') !!}
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
						<div class="table-responsive">
							<table class="table table-bordered table-condensed" id='formInput'>
								<thead>
									<th>Peralatan</th>
									<th>Harga Satuan</th>
									<th>Jumlah</th>
									<th>Kategori Peralatan</th>
									<th>Action</th>
								</thead>
								<tbody id="tbody_table"></tbody>
								<tfoot>
										<tr>
											<td>
												<input class="form-control" type="text" name="" id="peralatan" value="" />	
											</td>
											<td>
												<input type="text" class="form-control uangInput" id="nilai" placeholder="" autocomplete='off' value=""/>
											</td>
											<td>
												<input type="text" class="form-control " id="jumlah" placeholder="" autocomplete='off' value=""/>
											</td>
											<td>
											{!! Form::select('masa_pakai', $masa_pakai, null, [
												'onchange' => 'masaPakaiChange(this);return false;', 
												'class' => 'form-control', 
												'id' => 'masa_pakai'
											]) !!}
											</td>
											<td class="action">
												<button class="btn btn-primary btn-sm btn-block" type="button" onclick="dummyInsert(this); return false" id="dInsert">insert</button>
											</td>
										</tr>
								</tfoot>
							</table>
						</div>
						<div class="alert alert-danger" style="display:none;" id="peringatan_barang_kosong">
							Mungkin belum menekan tombol <strong>Insert</strong> jadi barang belanjaan masih kosong. 
						</div>
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
<div id="tableAc" class="row" style="display:none">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Input Pendingin Ruangan / AC</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Merek AC</th>
								<th>Keterangan Lokasi</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
		
	</div>
</div>
{!! Form::textarea('tempTr', null, ['class' => 'form-control hide', 'id' => 'tempTr']) !!}
{!! Form::textarea('tempAc', '[]', ['class' => 'form-control hide', 'id' => 'tempAc']) !!}
{!! Form::close() !!}
@stop
@section('footer') 
	
<script type="text/javascript" charset="utf-8">
	$(function () {
		$('#tempTr').val( $('#formInput').find('tfoot').html()  );
		view();
		$('#dInsert').keypress(function(e){
			 var key = e.keyCode || e.which;
			 if(key == '9'){
			 	$(this).click();
				return false;
			 }
		});
	});
	function dummyInsert(control){
		var peralatan = $('#peralatan').val();
		var nilai = $('#nilai').val();
		var jumlah = $('#jumlah').val();
		var masa_pakai = $('#masa_pakai').val();
		if(
				peralatan == '' ||
				nilai == '' ||
				jumlah == '' ||
				masa_pakai == '' 
		  ){
			if(peralatan == ''){
				validasi('#peralatan', 'Harus Diisi');
			}

			if(jumlah == ''){
				validasi('#jumlah', 'Harus Diisi');
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
		$('#peringatan_barang_kosong').fadeOut(300);
		var peralatan = $('#peralatan').val();
		var nilai = $('#nilai').val();
		var jumlah = $('#jumlah').val();
		var masa_pakai = $('#masa_pakai').val();

		// buat object baru

		var ac = [];
		// jika jenis peralatan adalah Pendingin Udara, maka buat array object baru ac
		 if($('#masa_pakai option:selected').text() =='AC / Pendingin Ruangan' ){
			$('.keterangan_lokasi').each(function(){
				ac[ac.length] = {
					'merek':             peralatan,
					'keterangan_lokasi': $(this).val()
				};
			});
		 }

		 //buat object baru untuk dimasukkan ke data
		var data = {
			'peralatan' : peralatan,
			'nilai' : cleanUang( nilai ),
			'jumlah' : jumlah,
			'masa_pakai' : masa_pakai,
			'ac' : ac,
		};
		// parse JSON temp yang sudah ada
		var temp = $('#temp').val();
		temp = $.parseJSON(temp);
		var length = temp.length;
		// masukkan object baru ke JSON temp yang sudah ada
		temp.push(data);
		$('#temp').val(JSON.stringify(temp));
		view();
	}

	function view(){
		 var temp = $('#temp').val();
		 var MyArray = $.parseJSON(temp);
		 var tabel = '';
		 var tableAc = '';
		 for (var i = 0; i < MyArray.length; i++) {
			 var kategori = ''
			 if(MyArray[i].masa_pakai == '1'){
			 	kategori = 'Alat medis non elektronik';
			 } else if(MyArray[i].masa_pakai == '3'){
			 	kategori = 'Alat Elektronik';
			 } else if(MyArray[i].masa_pakai == '5'){
			 	kategori = 'Furnitur dan Bahan Bangunan';
			 }
			 tabel += '<tr>';
			 tabel += '<td>' + MyArray[i].peralatan + '</td>';
			 tabel += '<td class="uang">' + MyArray[i].nilai + '</td>';
			 tabel += '<td>' + MyArray[i].jumlah + '</td>';
			 tabel += '<td>' + kategori + '</td>';
			 tabel += '<td> <button class="btn btn-danger btn-xs btn-block" type="button" onclick="rowDel(this);return false" value="' + i + '">delete</button> </td>';
			 tabel += '</tr>'

			 for (var n = 0; n < MyArray[i].ac.length; n++) {
				 tableAc += '<tr>';
				 tableAc += '<td>' + MyArray[i].ac[n].merek+ '</td>';
				 tableAc += '<td>' + MyArray[i].ac[n].keterangan_lokasi + '</td>';
				 tableAc += '</tr>';
			 }
		 }
		 $('#tableAc').find('tbody').html(tableAc);

		 if(  tableAc  != '' ){
		 	$('#tableAc').show();
		 } else {
		 	$('#tableAc').hide();
		 }
		resetForm();
		 $('#tbody_table').html(tabel);
		 $('#peralatan').val('');
		 $('#nilai').val('');
		 $('#jumlah').val('');
		 $('#masa_pakai').val('');
		 formatUang();
		 $('#peralatan').focus();

		$('.uangInput').autoNumeric('init', {
			aSep: '.',
			aDec: ',', 
			aSign: 'Rp. ',
			vMin: '-9999999999999.99' ,
			mDec: 0
		});
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
		var temp = $('#temp').val();
		if( temp == '[]' || temp == '' ){
			alert('Belum ada barang belanjaan yang dimasukkan');
			$('#peringatan_barang_kosong').hide().fadeIn(300);

		}
		 if(validatePass() && ( temp != '[]' && temp!= '' )){
			 $('#submit').click();
		 }
	}

	function resetForm(){
		 
			var tdTemp = $('#tempTr').val();
			var temp = '<tr>';
			temp += tdTemp ;
			temp += '</tr>';
			$('#masa_pakai').closest('tfoot').html(temp);
	}


	function masaPakaiChange(control){
		 if( $('#masa_pakai option:selected').text() == 'AC / Pendingin Ruangan' ){
			 var tempTr = $(control).closest('tr').html();
			 $('#tempTr').val(tempTr);
			 var $tdAction = $(control).closest('tr').find('.action');
			 var action = $tdAction.html();
			 $tdAction.html('');
			 var temp = '';
			 var jumlah = $('#jumlah').val();
			 console.log('jumlah');
			 console.log(jumlah);
			 for (var i = 0; i < jumlah; i++) {

				 temp += '<tr class="formPeralatan">';
				temp +='<td></td>';
				temp +='<td class="text-right">Keterangan Lokasi AC ke ' + ( parseInt(i) + 1 ) + ' :</td>';
				temp +='<td colspan="2"><textarea placeholder="Keterangan Lokasi" id="" class="keterangan_lokasi form-control textareacustom" ></textarea></td>';
				if(i == parseInt( jumlah ) -1){
					temp +='<td class="actionNext">' + action + '</td>';
				}else{
					temp +='<td></td>';
				}
				temp += '</tr>';
			 	
			 }
			 var length = $('.actionNext').length;
			 console.log('length');
			 console.log(length);
			 $(control)
				.closest('tfoot')
				.append(temp)
				.find('#keterangan')
				.focus();
		 } else {
			  var actionTemp = $('.actionNext').html();
			  $('.formPeralatan').remove();
			  console.log('actionTemp');
			  console.log(actionTemp);
			  $('.action').html(actionTemp);
		 }
	}


</script>
@stop
