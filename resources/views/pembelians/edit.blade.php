@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Entri Beli Obat

@stop
@section('page-title') 
<h2>Pembelian Obat</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('faktur_belis')}}">Antrian Pembelian</a>
      </li>
      <li class="active">
          <strong>Entri</strong>
      </li>
</ol>

@stop
@section('content') 
 <input type="hidden" name="_token" id="token" value="{{ Session::token() }}">

 {!! Form::model($fakturbelanja, [
	 'url'          => 'pembelians/' . $fakturbelanja->id,
	 'method'       => 'post',
	 'autocomplete' => 'on',
	 'files'        => 'true'
 ])!!}
 <div class="row">
 	<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panelLeft">
					<div class="panel-title">Edit Transaksi</div>
				</div>
				<div class="panelRight">
				</div>
			</div>
			<div class="panel-body">
			@include('suppliers.formFakturBelanja', ['edit' => true])
			</div>
		</div>
 	</div>
 </div>
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Nomor Faktur : {!! $fakturbelanja->nomor_faktur !!} | {!! $fakturbelanja->supplier->nama !!}</h3>
                </div>
                <div class="panelRight bold">
                  <span class="">Total : </span><span class="uang2" id="totalHargaObat">0</span>
                </div>

            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered table-hover" id="tableEntriBeli" nowrap>
					  <thead>
						<tr>
						   <th>No</th>
						   <th>Merek Obat</th>
						   <th>Harga Beli</th>
						   <th>Harga Jual</th>
						   <th>Exp Date</th>
						   <th>Jumlah</th>
						   <th>Harga Item</th>
						   <th>Action</th>
						   <th class='hide'>Class Rak</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					  <tfoot>
						<tr>
						  <td class="hide"></td>
						  <td colspan="2">
							<select id="ddl_merek_id" class="form-control selectpick" data-live-search='true' onchange='ddlChange(this);'>
								  <option value=""> - Pilih Merek - </option>
							  @foreach($mereks as $merek)
								  <option value="{!! $merek->id !!}" data-value='{!! $merek->custid !!}'>{!! $merek->merek !!}</option>
							  @endforeach
							</select>
						  </td>
						   <td><input type="text" id="txt_harga_beli" class="form-control" placeholder="harga beli"/></td>
						   <td><input type="text" id="txt_harga_jual" class="form-control" placeholder="harga jual"/></td>
						   <td><input type="text" id="txt_exp_date" class="form-control tanggal" placeholder="exp date"/></td>
						   <td><input type="text" id="txt_jumlah" class="form-control" placeholder="jumlah"/></td>
						   <td colspan="2"><button type="button" id="btn_Action" class="btn btn-primary btn-sm btn-block" onclick="input(this);return false;">input</buttomn></td>
						   <td>{!! Form::text('class_rak', null, ['class'=> 'hide', 'id' =>'class_rak'])!!}</td>
						</tr>
					</tfoot>
				</table>
		  </div>
            {!! Form::textarea('tempBeli', json_encode($exist), ['class' => 'form-control hide', 'id' => 'tempBeli', 'autocomplete' => 'on'])!!}
            {!! Form::textarea('tempBefore', json_encode($exist), ['class' => 'form-control hide', 'id' => 'tempBefore', 'autocomplete' => 'on'])!!}
            <input type="text" class="displayNone" id="faktur_belanja_id" name="faktur_belanja_id" value="{!! $id !!}">
            <div id="pesan2"></div>
			@include('suppliers.belanja_obat_upload_gambar', ['pembelian' => $fakturbelanja])
            <div class="row">
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                  <button type="button" class="btn btn-primary btn-block" onclick="dummySubmit();return false;">Update</button>
                  {!! Form::submit('Submit', ['class' => 'btn btn-primary btn-block hide', 'id' => 'submit'])!!} 
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                  <a href="{{ url('laporans')}}" class="btn btn-danger btn-block">Cancel</a>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <h3 class='red'>Isi Dengan BENAR!! JANGAN NGARANG2</h3>
              </div>
            </div>
          {!! Form::close()!!}
      </div>
</div>
<a href="#" onclick='buatObat();return false;'>Obat Tidak Ditemukan?</a>
<div class="panel panel-danger" id='buatObat'>
    <div class="panel-heading">
      <h3 class="panel-title">Pilih Salah Satu</h3>
    </div>
    <div class="panel-body">
          <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
              <a href="#" data-toggle="modal" data-target="#modalNewFormula">
               <div class="widget blue-bg p-xl">
                 <strong class='text-center'> 
                    <h2>
                        Formula Baru
                    </h2>
                  </strong>
                <ul class="list-unstyled m-t-md">
                    <li>
                        Buat obat yang memilik komposisi yang sama sekali baru atau obat yang memiliki komposisi sama tapi sediaannya berbeda
                    </li>
                </ul>

            </div>
          </a>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
              <a href="#" data-toggle="modal" data-target="#modalNewRak">
                 <div class="widget lazur-bg p-xl">
                   <strong class='text-center'> 
                      <h2>
                          Rak Baru
                      </h2>
                    </strong>
                  <ul class="list-unstyled m-t-md">
                      <li>
                          Buat Rak baru sudah ada formula yang sama tapi harganya beda. Pertama-tama pilih dulu formula yang sama.
                      </li>
                  </ul>
              </div>
            </a>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
              <a href="#" data-toggle="modal" data-target="#modalNewMerek">
                 <div class="widget yellow-bg p-xl">
                   <strong class='text-center'> 
                      <h2>
                          Merek Baru
                      </h2>
                    </strong>
                  <ul class="list-unstyled m-t-md">
                      <li>
                          Buat merek baru dimana sudah ada formula yang sama, harga yang sama, tapi mereknya beda. Pertama-tama pilih rak yang sama
                      </li>
                  </ul>
              </div>
              </a>
            </div>
          </div>
    </div>
</div>
<!-- Modal Untuk Membuat Formula Baru-->
<div class="modal fade" id="modalNewFormula" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <form action="" id='create_new_formula'>
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          @include('formulas.createForm', ['readonly' => 'readonly', 'modal' => true])
        </form>
      </div> 
    </div>
  </div>
</div>
<!-- Modal Untuk Membuat Rak Baru-->
<div class="modal fade" id="modalNewRak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">PETUNJUK : Pilih Obat Yang Memiliki Komposisi Yang Sama, tapi harga berbeda, jika ditemukan obat yang memiliki komposisi yang sama dan harga yang sama berarti Buat Merek baru, bukan buar rak baru</h4>
      </div>
      <div class="modal-body">
		  <div class="table-responsive">
			<table class="table table-bordered table-hover DT">
			  <thead>
				<tr>
				  <th>ID</th>
				  <th>Merek</th>
				  <th>Komposisi</th>
				  <th>Harga Beli</th>
				  <th>Harga Jual</th>
				  <th nowrap>Action</th>
				</tr>
			  </thead>
			  <tbody>
				@foreach($mereks as $merek)
				  <tr>
					<td>{!! $merek->rak->formula_id !!}</td>
					<td>{!! $merek->merek !!}</td>
					<td>
					  @foreach($merek->rak->formula->komposisi as $komposisi)
						{!! $komposisi->generik->generik !!} {!!$komposisi->bobot !!} <br>
					  @endforeach

					</td>
					<td class='uang'>{!! $merek->rak->harga_beli !!}</td>
					<td class='uang'>{!! $merek->rak->harga_jual !!}</td>
					<td>
					  <button type='button' class='btn btn-primary btn-sm btn-block' onclick='buatRak(this);return false;' >pilih</button>
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

<!-- Modal Untuk Membuat Rak Baru LANJUTAN-->
<div class="modal fade" id="newRak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">BUAT RAK BARU</h4>
      </div>
      <div class="modal-body">
        <form action="" id='create_new_rak'>
          <input type="hidden" name='_token' value="{{ Session::token() }}">
          @include('raks.createForm', ['formula' => $formula , 'modal' => true])
        </form>
      </div> 
    </div>
  </div>
</div>



<!-- Modal Untuk Membuat MEREK Baru-->
<div class="modal fade" id="modalNewMerek" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">PETUNJUK : Pilih Obat Yang Memiliki Komposisi Yang Sama, Dan Harganya Kurang Lebih Sama!!</h4>
      </div>
      <div class="modal-body">
		  <div class="table-responsive">
			<table class="table table-bordered table-hover DT">
			  <thead>
				<tr>
				  <th>ID</th>
				  <th>Merek</th>
				  <th>Komposisi</th>
				  <th>Harga Beli</th>
				  <th>Harga Jual</th>
				  <th nowrap>Action</th>
				</tr>
			  </thead>
			  <tbody>
				@foreach($mereks as $merek)
				  <tr>
					<td>{!! $merek->rak_id !!}</td>
					<td>{!! $merek->merek !!}</td>
					<td>
					  @foreach($merek->rak->formula->komposisi as $komposisi)
						{!! $komposisi->generik->generik !!} {!!$komposisi->bobot !!} <br>
					  @endforeach

					</td>
					<td class='uang'>{!! $merek->rak->harga_beli !!}</td>
					<td class='uang'>{!! $merek->rak->harga_jual !!}</td>
					<td>
					  <button type='button' class='btn btn-primary btn-sm btn-block' onclick='buatMerek(this);return false;'>pilih</button>
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


<!-- Modal Untuk Membuat Merek Baru LANJUTAN-->
<div class="modal fade" id="newMerek" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">BUAT MEREK BARU</h4>
      </div>
      <div class="modal-body">
        <form action="" id='create_new_merek'>
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          @include('mereks.createForm', ['rak' => $rak, 'modal' => true ])
        </form>
      </div> 
    </div>
  </div>
</div>



@stop
@section('footer') 
<script>
  var base = "{{ url('/') }}";
  console.log(base);
</script>
<script src="{{ url('js/createForm.js') }}"></script>
{!! HTML::script('js/rak.js')!!} 
{!! HTML::script('js/merek.js')!!} 

  <script>
    var data=[];
    var dataTambah='';
    var lanjut = true;
    var jual = 0;


    $(document).ready(function() {

      $('#buatObat').hide();
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

      $('#create_new_formula #submitFormula').click(function(e) {
        var param = $('#create_new_formula').serializeArray();
        console.log(param);
        $.post(base + '/formulas', param, function(data) {
            appendOption(data);
            $('#modalNewFormula').modal('hide');
        });
        return false;
      });
      $('#newRak input[type="submit"]').click(function(e) {

        var param = $('#create_new_rak').serializeArray();
        $.post(base + '/raks', param, function(data) {
          appendOption(data);
          $('#newRak').modal('hide');
        });
        return false;
      });
      $('#newMerek input[type="submit"]').click(function(e) {

        var param = $('#create_new_merek').serializeArray();
        $.post(base + '/mereks', param, function(data) {
          appendOption(data);
          $('#newMerek').modal('hide');
        });
        return false;
      });

      $('#txt_harga_beli').keyup(function(e) {
        var dua_kali = 0;
        if ($('#class_rak').val() == '1') {
          dua_kali = $(this).val() * 1.3;
        } else {
          dua_kali = $(this).val() * 2;
        }

        if (dua_kali > jual) {
          for (var i = 0; i < dua_kali; i = i + 100) {
          }
          $('#txt_harga_jual').val(i);
        } else {
          $('#txt_harga_jual').val(jual);
        }
      });

    });

    function input(control) {

        if ( $('#staf_id').val() == '' ){

          validate_staf_id();

        } else if (

          $('#ddl_merek_id').val() == '' ||
          $('#txt_exp_date').val() == '' ||
          $('#txt_harga_beli').val() == '' ||
          $('#txt_harga_jual').val() == '' ||
          $('#txt_jumlah').val() == ''
        ){
          if($('#ddl_merek_id').val() == ''){
            validasi4('#ddl_merek_id', 'Harus Diisi!!');
          }
          if($('#txt_exp_date').val() == ''){
            validasi4('#txt_exp_date', 'Harus Diisi!!');
          }
          if($('#txt_harga_beli').val() == ''){
            validasi4('#txt_harga_beli', 'Harus Diisi!!');
          }
          if($('#txt_harga_jual').val() == ''){
            validasi4('#txt_harga_jual', 'Harus Diisi!!');
          }
          if($('#txt_jumlah').val() == ''){
            validasi4('#txt_jumlah', 'Harus Diisi!!');
          }
          if($('#staf_id').val() == ''){
          }
        } else {

        var merek      = $(control).closest('tr').find('td:nth-child(2) select option:selected').text();
        var ddl_value  = $(control).closest('tr').find('td:nth-child(2) select option:selected').attr('data-value');
        var harga_beli = $(control).closest('tr').find('td:nth-child(3) input').val();
        var harga_jual = $(control).closest('tr').find('td:nth-child(4) input').val();
        var exp_date   = $(control).closest('tr').find('td:nth-child(5) input').val();
        var today      = hari_ini();
        
        console.log('merek      = ' + merek);
        console.log('ddl_value  = ' + ddl_value);
        console.log('harga_beli = ' + harga_beli);
        console.log('harga_jual = ' + harga_jual);
        console.log('exp_date   = ' + exp_date);
        console.log('today      = ' + today);

        var jumlah = $(control).closest('tr').find('td:nth-child(6) input').val();

        var merek_id        = getMerekId(ddl_value);
        var harga_beli_awal = getHargaBeli(ddl_value);
        var exp_date_awal   = getExpDate(ddl_value);
        var sediaan         = getSediaan(ddl_value);

        var harga_berubah = harga_beli - harga_beli_awal;

        dataTambah = {
          'id'  : null,
          'merek' : merek,
          'merek_id' : merek_id,
          'harga_beli' : harga_beli,
          'harga_jual' : harga_jual,
          'harga_berubah' : harga_berubah,
          'exp_date' : tanggal(exp_date),
          'jumlah' : jumlah
        };

        exp_date_awal = new Date(exp_date_awal);
        exp_date_awal = exp_date_awal.getTime();

        exp_date = exp_date.split('-');
        exp_date = exp_date[2] + '-' + exp_date[1] + '-' + exp_date[0]
        exp_date = new Date(exp_date);
        exp_date = exp_date.getTime();


        today = new Date(today);
        today = today.getTime();

        console.log('exp_date = ' + exp_date);
        console.log('today = ' + today);
        console.log('exp_date_awal = ' + exp_date_awal);
        var selisih = parseInt(exp_date) - parseInt(today);
        console.log('selisih = ' + selisih);

        var data_ini = $.parseJSON($('#tempBeli').val());

        var merek_bool = false;
        for (var i = 0; i < data_ini.length; i++) {
          if(data_ini[i].merek_id == merek_id){
            merek_bool = true;
            break;
          }
        }
          if(((harga_beli/harga_beli_awal > 1.2) || (harga_beli/harga_beli_awal < 0.8 )) && harga_beli_awal != null){
            confSubmit('#txt_harga_beli', 'Perubahan harga lebih dari 20 %, lanjutkan?')
          }
          if ((sediaan == 'tablet' || sediaan == 'capsul') && harga_beli < 4000 && harga_jual/harga_beli < 2 && lanjut == true){
            confSubmit('#txt_harga_jual', 'Harga Jual terlalu kecil, lanjutkan?')
          }
          if ((exp_date <= today ) && lanjut == true){
            alert('Barang sudah kadaluarsa, tidak bisa diinput !!');
            lanjut = false;
            $('.form-control').val('');

            $('#ddl_merek_id')
            .selectpicker('refresh')
            .closest('div')
            .find('.btn-white')
            .focus();
          }
          if ((exp_date_awal > exp_date) && lanjut == true){
            confSubmit('#txt_exp_date', 'tanggal kadaluarsa lebih awal dari pada data yang ada, Barang Lama Nih, lanjutkan?')
          }
          if(merek_bool){
            var r = confirm('Merek yang sama sudah pernah dimasukkan, lanjutkan?');
            if (r) {
              lanjut = true;    
            } else{
              lanjut = false;
              clearForm();
            };
          }
          if (lanjut) {
            submitInput();
          };
          lanjut = true;
      }
    }

    function viewData(dataf){
      view(dataf);
      clearForm();
      return false;
    }
    function viewData2(dataf){
      view(dataf);
      return false;
      clearForm2();
    }

    function rowEdit(control){


      if ($('#staf_id').val() == '') {
        validate_staf_id();
      } else {

        var key    = $(control).closest('tr').find('td:first-child div').html();
        key        = parseInt(key) -1;
        
        var string            = $('#tempBeli').val();
        data                  = $.parseJSON(string);
        var merek_id          = data[key].merek_id;
        console.log('merek_id = ' + merek_id);
        var jumlah            = data[key].jumlah;
        var harga_beli        = data[key].harga_beli;
        var harga_jual        = data[key].harga_jual;
        var exp_date          = tanggal(data[key].exp_date);

        $('.btn, .form-control').attr('disabled', 'disabled');


        var option_merek_id = $('#ddl_merek_id').html();
        var select = '<select class="selectpick" disabled data-live-search="true" onchange="ddlChange(this);return false;">' + option_merek_id + '</select>'
        $(control)
          .closest('tr')
          .find('td:nth-child(2)')
          .html(select)
          .find('select')
          .val(merek_id)
          .selectpicker({
            style: 'btn-default',
            size: 10,
            selectOnTab : true,
            style : 'btn-white'
          })
          .closest('td').find('.btn-white').focus();


        $(control).closest('tr').find('td:nth-child(3)').find('div').html('<input type="text" class="form-control" value="' + harga_beli + '">');
        $(control).closest('tr').find('td:nth-child(4)').find('div').html('<input type="text" class="form-control" value="' + harga_jual + '">');
        $(control).closest('tr').find('td:nth-child(5)').find('div').html('<input type="text" id="exp_date_edit" class="form-control tanggal" value="' + exp_date + '">');
        $(control).closest('tr').find('td:nth-child(6)').find('div').html('<input type="text" class="form-control" value="' + jumlah + '">');
        $('#exp_date_edit').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
        var button_text = '<a href="#" onclick="rowUpdate(this);return false;" class="btn btn-sm btn-success">update</a>&nbsp;&nbsp;';
        button_text += '<a href="#" onclick="rowCancel();return false;" class="btn btn-sm btn-primary">cancel</a>';

        $(control).closest('tr').find('td:nth-child(8)').find('div').html(button_text);
        $('#class_rak').val(class_rak);
      }

    }

    function rowDel(control){
      var merek = $(control).closest('tr').find('td:nth-child(2) div').html();
      var jumlah = $(control).closest('tr').find('td:nth-child(6) div').html();
      var r = confirm('Yakin mau menghapus ' + merek + ' sebanyak ' + jumlah + ' dari nota?');
      var key = $(control).val();

      data = returnData();
      if (r) {
        data.splice(key, 1);
        $(control).closest('tr').find('div').slideUp('400', function(){
          viewData2(data);
        });
      }
    }

    function rowCancel(){
      $('.btn, .form-control').removeAttr('disabled');
      viewData2(data);
    }

    function ddlChange(control){
      if ($(control).val() != '') {

        datafr = $(control).find('option:selected').attr('data-value');
        datafr = $.parseJSON(datafr);

        var merek_id   = datafr.merek_id;
        var harga_jual = datafr.harga_jual;
        var class_rak  = datafr.class_rak;
        var exp_date   = datafr.exp_date;

        if (exp_date != null) {
          exp_date = exp_date.split('-');
          exp_date = exp_date[2] + '-' + exp_date[1] + '-' + exp_date[0]
        }

        var harga_beli = datafr .harga_beli;

        jual = harga_jual;

        $(control).closest('tr').find('td:nth-child(3)').find('input').val(harga_beli);  
        $(control).closest('tr').find('td:nth-child(4)').find('input').val(harga_jual); 
        $(control).closest('tr').find('td:nth-child(5)').find('input').val(exp_date); 
        $(control).closest('tr').find('td:last-child').find('input').val(class_rak); 
      }


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

      $('#ddl_merek_id').val('').selectpicker('refresh');
      $('#txt_exp_date').val('');
      $('#txt_harga_beli').val('');
      $('#txt_harga_jual').val('');
      $('#txt_jumlah').val('');

      $('#ddl_merek_id').closest('td').find('.btn-white').focus();
    }
    function clearForm2() {

      $('#ddl_merek_id').val('').selectpicker('refresh');
      $('#txt_exp_date').val('');
      $('#txt_harga_beli').val('');
      $('#txt_harga_jual').val('');
      $('#txt_jumlah').val('');
    }

    function buatObat(){
      $('#buatObat').toggle(1000);
      $("html, body").animate({ scrollTop: "300px" });
      $('#create_new_merek, #create_new_rak, #create_new_formula')
          .find('input:text, input:password, input:file, select, textarea')
          .val('');
      $('#create_new_merek, #create_new_rak, #create_new_formula')
          .find('input:radio, input:checkbox')
          .removeAttr('checked').removeAttr('selected');
    }

    function buatRak(control) {
      var formula_id = $(control).closest('tr').find('td:first-child').html();
      $('#ket_formula_id').html(formula_id);
      $('#formulaIdOnRak').val(formula_id);

      $.post(base + '/pembelians/ajax/formulabyid', {'formula_id': formula_id, '_token' : '{{ Session::token() }}'}, function(data) {
          data = $.parseJSON(data);
          var dijual_bebas = data.dijual_bebas;
          var efek_samping = data.efek_samping;
          var sediaan = data.sediaan;
          var indikasi = data.indikasi;
          var kontraindikasi = data.kontraindikasi;
          var Komposisi = data.Komposisi   ;
          var Merek = data.Merek;

          var $table = $('#newRak #tableAsuransi');
          var satu = $table.find('tr:first-child').html();

          $table.find('tr:nth-child(1)').find('td:nth-child(2)').html(dijual_bebas);
          $table.find('tr:nth-child(2)').find('td:nth-child(2)').html(efek_samping);
          $table.find('tr:nth-child(3)').find('td:nth-child(2)').html(sediaan);
          $table.find('tr:nth-child(4)').find('td:nth-child(2)').html(indikasi);
          $table.find('tr:nth-child(5)').find('td:nth-child(2)').html(kontraindikasi);
          $table.find('tr:nth-child(6)').find('td:nth-child(2)').html(Komposisi);
          $table.find('tr:nth-child(7)').find('td:nth-child(2)').html(Merek);
          $('#merekOnRakEndFix').html(data.endfix);
          $('#newRak').modal('show');
          $('#modalNewRak').modal('hide');
      });


    }

    function buatMerek(control) {
          var rak_id = $(control).closest('tr').find('td:first-child').html();

          $.post(base + '/pembelians/ajax/rakbyid', {'rak_id': rak_id, '_token' : '{{ Session::token() }}' }, function(data) {

                data = $.parseJSON(data);
                var merek   = data.merek;
                var komposisi   = data.komposisi;
                var harga_beli  = data.harga_beli;
                var harga_jual = data.harga_jual;
                var formula_id = data.formula_id;
                var rak_id  = data.rak_id;
                var endfix  = data.endfix;

                console.log('merek = ' + merek);
                console.log('komposisi = ' + komposisi);
                console.log('harga_beli = ' + harga_beli);
                console.log('harga_jual = ' + harga_jual);
                console.log('formula_id = ' + formula_id);
                console.log('rak_id = ' + rak_id);
                console.log('endfix = ' + endfix);

                $('#rakIdOnMerek').val(rak_id);
                $('#endFixOnMerek').val(endfix);

                var $table = $('#newMerek #tableAsuransi');

                $table.find('tr:nth-child(1)').find('td:nth-child(2)').html(merek);
                $table.find('tr:nth-child(2)').find('td:nth-child(2)').html(komposisi);
                $table.find('tr:nth-child(3)').find('td:nth-child(2)').html(harga_beli);
                $table.find('tr:nth-child(4)').find('td:nth-child(2)').html(harga_jual);
                $table.find('tr:nth-child(5)').find('td:nth-child(2)').html(formula_id);
                $table.find('tr:nth-child(6)').find('td:nth-child(2)').html(rak_id);


                $('.uang').each(function() {
                    var number = $(this).html();
                    number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
                    $(this).html('Rp. ' + number + ',-');
                });

                $('#addonMerek').html(endfix);

                $('#newMerek').modal('show');
                $('#modalNewMerek').modal('hide');
          });

    }
    function appendOption(data){

      data = $.trim(data);
      MyArray = $.parseJSON(data);

      var custom_value = MyArray.custom_value;


      var temp = "<option value='" + MyArray.merek_id + "' data-value='" + custom_value+ "'>" + MyArray.merek + "</option>" ; 
      $('#ddl_merek_id')
      .append(temp)
      .val(MyArray.merek_id)
      .trigger('change')
      .selectpicker('refresh');

      var pesan = 'Merek <strong>' +MyArray.merek+ '</strong> berhasil ditambahkan';
      var wrap = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +pesan+ '</div>';
      $('#buatObat').hide();
      alert('Merek ' + MyArray.merek + ' berhasil ditambahkan');
      $('#pesan2').html(wrap).hide().fadeIn(2000, function() {
        $(this).fadeOut(2000);
      });

      setTimeout(function(){ 
          $('#ddl_merek_id').closest('tr').find('.btn-white').focus();
      }, 500);


    }

    function rowUpdate(control){

      console.log($(control).closest('tr').find('td:nth-child(2)').find('select').val());
      console.log($(control).closest('tr').find('td:nth-child(3)').find('input').val());
      console.log($(control).closest('tr').find('td:nth-child(4)').find('input').val());
      console.log($(control).closest('tr').find('td:nth-child(5)').find('input').val());
      console.log($(control).closest('tr').find('td:nth-child(6)').find('input').val());
      if (
          $('#staf_id').val() == ''

        ) {
        alert('Nama Penginput belum diisi');
        $('#staf_id').focus();
      }else if (
          $(control).closest('tr').find('td:nth-child(2)').find('select').val() == '' ||
          $(control).closest('tr').find('td:nth-child(3)').find('input').val() == '' ||
          $(control).closest('tr').find('td:nth-child(4)').find('input').val() == '' ||
          $(control).closest('tr').find('td:nth-child(5)').find('input').val() == '' ||
          $(control).closest('tr').find('td:nth-child(6)').find('input').val() == ''
        ) {
        alert('tidak boleh ada kolom yang kosong');
      } else {
        var key = $(control).closest('tr').find('td:first-child div').html();
        key = parseInt(key) -1;

        var merek_id = $(control).closest('tr').find('td:nth-child(2)').find('select').val();
        if (merek_id != '') {
          var merek = $(control).closest('tr').find('td:nth-child(2)').find('select option:selected').text();
        }
        var merek_id = $(control).closest('tr').find('td:nth-child(2)').find('select').val();
        var harga_beli = $(control).closest('tr').find('td:nth-child(3)').find('input').val();
        var harga_jual = $(control).closest('tr').find('td:nth-child(4)').find('input').val();
        var exp_date = tanggal($(control).closest('tr').find('td:nth-child(5)').find('input').val());
        var jumlah = $(control).closest('tr').find('td:nth-child(6)').find('input').val();



        var string = $('#tempBeli').val();
        data = $.parseJSON(string);
        var dataBefore = $('#tempBefore').val();

        dataBefore = $.parseJSON(dataBefore);
        dataUpdate = {
            'id'  : data[key].id,
            'merek' : merek,
            'merek_id' : merek_id,
            'harga_beli' : harga_beli,
            'harga_jual' : harga_jual,
            'harga_berubah' : parseInt(harga_beli) - (parseInt(dataBefore[key]['harga_beli']) - parseInt(dataBefore[key]['harga_berubah'])),
            'exp_date' : exp_date,
            'jumlah' : jumlah
        };
        data[key] = dataUpdate;
        rowCancel();
      }


    }
    
    function view(dataf){
        var temp = '';
        var total = 0;
        for (var i = 0; i < dataf.length; i++) {
          var biaya = parseInt(dataf[i].harga_beli) * parseInt(dataf[i].jumlah);
          if (dataf[i].merek != null) {
            temp += '<tr>';
            temp += '<td nowrap><div>' + (parseInt(i) + 1) + '</div></td>';
            temp += '<td nowrap><div>' + dataf[i].merek + '</div></td>';
            temp += '<td nowrap><div class="uang2">' + dataf[i].harga_beli + '</div></td>';
            temp += '<td nowrap><div class="uang2">' + dataf[i].harga_jual + '</div></td>';
            temp += '<td nowrap><div>' + tanggal(dataf[i].exp_date) + '</div></td>';
            temp += '<td nowrap><div class="jumlah">' + dataf[i].jumlah + '</div></td>';
            temp += '<td nowrap><div class="uang2">' + biaya + '</div></td>';
            temp += '<td nowrap><div>';
            temp += '<button type="button" class="btn btn-warning btn-sm" onclick="rowEdit(this);return false;">edit</button>&nbsp;&nbsp;';
            temp += '<button type="button" class="btn btn-danger btn-sm" onclick="rowDel(this);return false;" value="' +i+ '">hapus</button>';
            temp += '</div></td>';
            temp += '</tr>';
            total += biaya;
          }
        };


        $('#tableEntriBeli tbody').html(temp);
        $('#tempBeli').val(JSON.stringify(dataf));
        $('#totalHargaObat').html(total);

        $('.uang2').each(function() {
            var number = $(this).html();
            number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
            $(this).html('Rp. ' + number + ',-');
        });
        
        $('.jumlah').each(function() {
            var number = $(this).html();
            number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
            $(this).html(number);
        });
    }

    function returnData(){
        var string = $('#tempBeli').val();
        return $.parseJSON(string);
    }

    function dummySubmit(){
      if ($('#tempBeli').val() != '') {
        $('#submit').click();
      } else {
        alert('tidak ada data untuk dimasukkan!');
      }
    }

    function validate_staf_id(){
          validasi('#staf_id', 'Harus Diisi!!');
          alert('Nama Staf Harus diisi dulu');
          $('#staf_id').closest('div').find('.btn-white').focus();
    }
  </script>
@stop
