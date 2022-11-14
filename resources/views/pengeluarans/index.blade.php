@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Pengeluaran Klinik

@stop
@section('head')
    <link href="{!! asset('css/pembelian.css') !!}" rel="stylesheet" media="print">
@stop
@section('page-title') 
<h2>Pengeluaran Klinik</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Pengeluaran Klinik</strong>
      </li>
</ol>

@stop
@section('content') 
{!! Form::open(['url' => 'pengeluarans', 'method' =>'post'])!!}
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="form-group @if($errors->has('staf_id'))has-error @endif">
          {!! Form::label('staf_id', 'Nama Staf : ', ['id' => 'staf_label', 'class' => 'control-label']) !!}
          {!! Form::select('staf_id', App\Models\Classes\Yoga::stafList(), null, ['class' => 'form-control rq', 'id' => 'staf_id', 'data-live-search' => 'true', 'content' => 'Nama Staf']) !!}
		    @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
        </div>
      </div>
    </div>
  </div>
</div>
<div class="panel panel-info hide">
    <div class="panel-heading">
      <h3 class="panel-title">Informasi Supplier</h3>
    </div>
    <div class="panel-body">

		<div class="table-responsive">
				<table class="table table-condensed table-bordered table-hover">
				  <thead>
					<tr>
					  <th>Petugas Kasir</th>
					  <th>Nomor Faktur</th>
					  <th>Supplier</th>
					</tr>
				  </thead>
				  <tbody>
					<tr>
					  </td>
					  <td>
						{!! Form::text('nomor_faktur', $fakturbelanja->nomor_faktur, ['class' => 'form-control', 'id' => 'nomor_faktur'])!!}
					  </td>
					  <td>
						{!! Form::text('supplier_id', $fakturbelanja->supplier_id, ['class' => 'form-control', 'id' => 'supplier_id'])!!}
					  </td>
					  <td>
						{!! Form::text('faktur_belanja_id', $fakturbelanja->id, ['class' => 'form-control', 'id' => 'faktur_belanja_id'])!!}
					  </td>
					</tr>
				  </tbody>
				</table>
		</div>
              {!! HTML::link('suppliers/create', 'Supplier Tidak Ada?', ['class' => ''])!!}
            
      </div>
</div>
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                  {!! $fakturbelanja->supplier->nama !!} | {!!$fakturbelanja->nomor_faktur!!})
                </div>
                <div class="panelRight bold">
                  <span class="">Total : </span><span class="uang " id="totalHargaObat">0</span>
                </div>

            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
			  <div class="table-responsive">
					<table class="table table-bordered table-hover" id="tableEntriBeli" nowrap>
						  <thead>
							<tr>
							 <th>No</th>
							   <th>Keterangan Pengeluaran</th>
							   <th>Jenis Pengeluaran</th>
							   <th>Harga Satuan</th>
							   <th>Jumlah</th>
							   <th nowrap>Total Item</th>
							   <th>Action</th>
							</tr>
						</thead>
						<tbody>
						  
						</tbody>
						  <tfoot>
							<tr>
							  <td colspan="2"><input type="text" class="form-control rq" name="keterangan" id="keterangan" onblur="textBlur();return false;" content="Keterangan" placeholder="Sebisa mungkin pilih yang sudah ada"></td>
							   <td>{!! Form::select('jenis_pengeluaran', $jenis_pengeluarans, null, ['class' => 'form-control rq', 'id' => 'jenis_pengeluaran', 'content' => 'Jenis Pengeluaran'])!!}</td>
							   <td><input type="text" id="harga_satuan" content="Harga Satuan" class="form-control rq" placeholder="harga satuan"/></td>
							   <td><input type="text" id="jumlah" content="jumlah" class="form-control rq" placeholder="jumlah"/></td>
							   <td colspan="2"><button type="button" id="btn_Action" class="btn btn-primary btn-sm btn-block" onclick="input(this);return false;">input</buttomn></td>
							</tr>
						</tfoot>
					</table>
			  </div>
		  </div>

            {!! Form::textarea('transaksi_beli', null, ['class' => 'form-control hide', 'id' => 'tempBeli'])!!}
            <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
            {!! Form::submit('Submit', ['class' => 'btn btn-primary displayNone', 'id' => 'submit'])!!} 
            <a href="" class="btn btn-danger">cancel</a>
          {!! Form::close()!!}
      </div>
</div>
<button class="btn btn-info hide" type="button" onclick="testPrint();return false;" id="print">print</button>
<div class="row" id="content-print">
    <div class="box title-print text-center">
        <h2>Laporan Belanja Bukan Obat</h2>
    </div>
    <hr> 
    <div class="box">
		<div class="table-responsive">
			<table class="table table-condensed">
				<tbody>
					<tr>
						<td>Supplier</td> 
						<td>:</td>
						<td>{{ $fakturbelanja->supplier->nama }}</td> 
					</tr>  
					<tr>
						<td>Tanggal</td>
						<td>:</td>
						<td>{{App\Models\Classes\Yoga::updateDatePrep(  $fakturbelanja->tanggal  )}}</td>
					</tr>
					<tr>
						<td>Nomor Faktur</td>
						<td>:</td>
						<td>{{ $fakturbelanja->nomor_faktur }}</td>
					</tr>
				</tbody>
			</table>
		</div>
        <hr> 
    </div>
    <div class="font-small">
		<div class="table-responsive">
			<table class="table table-condensed bordered">
				<thead>
					<tr>
						<th>Merek</th>
						<th>Rp</th>
						<th>Qty</th>
						<th>Harga</th>
					</tr>
				</thead>
				<tbody id="daftarBelanja">
				</tbody>
				<tfoot>
					<tr>
						<td>Total</td>
						<td id="totalBiaya" class="biaya-print" nowrap colspan="3"></td>
					</tr>    
				</tfoot>
			</table>
		</div>
        <hr> 
    </div>

       <div class="only-padding">
           
       </div> 
        <table class="table-center">
            <tr>
                <td>Penginput</td>
                <td>Disahkan Oleh</td>
            </tr>
            <tr class="tanda-tangan">
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="staf-print"></td>
                <td>( ................. )</td>
            </tr>
        </table>
       <div class="small-padding">
           
       </div> 
    </div>
@stop
@section('footer') 
  <!-- script untuk Jquery UI (isinya autocomplete)-->
  <script src="{!! asset('js/jquery-ui.min.js') !!}"></script>
  <script>
    var data=[];
    var dataTambah='';
    var lanjut = true;


    $(document).ready(function() {

      clearForm();

      if ($('#tempBeli').val() == '' || $('#tempBeli').val == '[]') {
      } else {
        data = $('#tempBeli').val();
        data = $.parseJSON(data);
        viewData(data);
      }

      $('#btn_Action').keypress(function(e) {
        var key = e.keyCode || e.which;

        if (key == 9){
          $(this).click();
          return false
        }
      });

      var tags = '{!! $bukanObat !!}';
      tags = $.parseJSON(tags);

      $('#keterangan').autocomplete({
        source : tags
      });


      $('#submitForm').click(function(e) {
        if(
          $('select[name="supplier_id"]').val() == '' ||
          $('select[name="staf_id"]').val() == '' 
          ) {

          if($('select[name="supplier_id"]').val() == ''){
            validasi('select[name="supplier_id"]', 'Harus diisi!');
          } 
          if($('select[name="staf_id"]').val() == '' ){
            validasi('select[name="staf_id"]', 'Harus diisi!');
          }
        } else {
          $('#print').click();
        }
      });


    });

    function input(control) {

        var pass = true;
        var string = '';
        $('.rq').not('button').each(function(index, el) {
           if ($(this).val() == '') {

              string += $(this).attr('content') + ', ';
              validasi('#'+ $(this).attr('id'), 'Harus Diisi');
              pass = false;
           }
        });

        if (pass){

            var nomor_faktur = $('#nomor_faktur').val();
            var supplier_id = $('#supplier_id').val();
            var keterangan = $(control).closest('tr').find('td:nth-child(1) input').val();
            var harga_satuan = $(control).closest('tr').find('td:nth-child(3) input').val();
            var jumlah = $(control).closest('tr').find('td:nth-child(4) input').val();
            var jenis_pengeluaran_id = $(control).closest('tr').find('td:nth-child(2) select').val();
            var jenis_pengeluaran = $(control).closest('tr').find('td:nth-child(2) select option:selected').text();

            dataTambah = {
              'keterangan' : keterangan,
              'harga_satuan' : harga_satuan,
              'jumlah' : jumlah,
              'jenis_pengeluaran_id' : jenis_pengeluaran_id,
              'jenis_pengeluaran' : jenis_pengeluaran
            };

            submitInput();


      } else {
        alert(string + ' Harus Diisi terlebih dahulu');
      }
    }

    function viewData(dataf){
      var temp = '';
      var total = 0;
      for (var i = 0; i < dataf.length; i++) {

        var biaya = parseInt(dataf[i].harga_satuan) * parseInt(dataf[i].jumlah);

       temp += '<tr>';
       temp += '<td nowrap>' + (i + 1) + '</td>';
       temp += '<td nowrap>' + dataf[i].keterangan + '</td>';
       temp += '<td nowrap>' + dataf[i].jenis_pengeluaran + '</td>';
       temp += '<td nowrap class="uang">' + dataf[i].harga_satuan + '</td>';
       temp += '<td nowrap class="jumlah">' + dataf[i].jumlah + '</td>';
       temp += '<td nowrap class="uang">' + biaya + '</td>';
       temp += '<td nowrap><button type="button" class="btn btn-danger btn-xs" onclick="rowDel(this);return false" value="' + i + '">hapus</button></td>';
       temp += '</tr>';

        total += biaya;

      };

      $('#tableEntriBeli tbody').html(temp);
      $('#tempBeli').val(JSON.stringify(dataf));
      $('#totalHargaObat').html(total);

      $('.uang').each(function() {
          var number = $(this).html();
          number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
          $(this).html('Rp. ' + number + ',-');
      });
      
      $('.jumlah').each(function() {
          var number = $(this).html();
          number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
          $(this).html(number);
      });

      clearForm();
      if ($('#tempBeli').val() == '[]') {
        $('#tempBeli').val('');
      };
      return false;
    }

    function rowDel(control){

        data.splice(control, 1);
        viewData(data);

    }

    function textBlur(){

      var keterangan = $('#keterangan').val();

      $.post('{{ url("pengeluarans/ketkeluar") }}', { 'keterangan': keterangan, '_token' : '{{ Session::token() }}' }, function(data) {
        data = $.parseJSON(data);

        if (data.confirm == '1') {
          var jumlah = data.cont.jumlah;
          var jenis_pengeluaran_id = data.cont.jml_peng_id;

          $('#jenis_pengeluaran').val(jenis_pengeluaran_id);
          $('#harga_satuan').val(jumlah);
        }

      });


    }

    function ddlChange(control){
      control = $(control).val();
      control = $.parseJSON(control);

      var merek_id = control.merek_id;
      var harga_jual = control.harga_jual;
      var exp_date = control.exp_date;

      exp_date = exp_date.split('-');
      exp_date = exp_date[2] + '-' + exp_date[1] + '-' + exp_date[0]

      var harga_beli = control.harga_beli;

      $('#txt_harga_beli').val(harga_beli);
      $('#txt_harga_jual').val(harga_jual);
      $('#txt_exp_date').val(exp_date);

    }
    function getMerekId(control){
      control = $.parseJSON(control);
      return control.merek_id;
    }
    function getHargaBeli(control){
      control = $.parseJSON(control);
      return control.harga_beli;
    }
    function getExpDate(control){
      control = $.parseJSON(control);
      return control.exp_date;
    }
    function getSediaan(control){
      control = $.parseJSON(control);
      return control.sediaan;
    }
    function confSubmit(selector, message){
        var r = confirm(message);
        if (r) {
          lanjut = true;
        } else {
          lanjut = false;
          $(selector).focus();
        }
    }

    function submitInput(){
      data[data.length] = dataTambah;
      viewData(data); 
    }

    function clearForm() {

      $('#keterangan').val('');
      $('#harga_satuan').val('');
      $('#jumlah').val('');
      $('#jenis_pengeluaran').val('');

      $('#keterangan').focus();
    }

function testPrint(){
    var tempBeli = $('#tempBeli').val();
    tempBeli = $.parseJSON(tempBeli);
    var staf = $('#staf_id option:selected').text();
    $('.staf-print').html(staf);
    var temp = '';
    var totalBiaya = 0;
    for (var i = 0; i < tempBeli.length; i++) {
        var harga = tempBeli[i].harga_satuan * tempBeli[i].jumlah;
        console.log(harga);
        temp += '<tr>';
        temp += '<td>' + tempBeli[i].keterangan+ '</td>'
        temp += '<td>' + uang( tempBeli[i].harga_satuan ) + '</td>'
        temp += '<td>' + tempBeli[i].jumlah + '</td>'
        temp += '<td>' + uang( harga ) + '</td>'
        temp += '</tr>';
        totalBiaya += harga;
    }
    $('#totalBiaya').html(uang( totalBiaya ));
    $('#daftarBelanja').html(temp);
    $('#submit').click();
}
  </script>
@stop
