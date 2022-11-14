@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Entri Beli Obat

@stop
@section('head')
    <link href="{!! asset('css/pembelian.css') !!}" rel="stylesheet" media="print">
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

{!! Form::open(['url' => 'pembelians', 'method' =>'post', 'autocomplete' => 'on'])!!}

<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default">
      <div class="panel-body">
		  <div class="form-group @if($errors->has('staf_id'))has-error @endif">
		    {!! Form::label('staf_id', 'Nama Penginput', ['class' => 'control-label']) !!}
            {!! Form::select('staf_id', App\Models\Classes\Yoga::stafList(), null, ['class'=>'form-control selectpick', 'id'=>'staf_id', 'data-live-search' => 'true'])!!}
		    @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
		  </div>
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
                  <span class="">Total : </span><span class="uang " id="totalHargaObat">0</span>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered" id="tableEntriBeli" nowrap>
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
            {!! Form::textarea('tempBeli', null, ['class' => 'form-control hide', 'id' => 'tempBeli', 'autocomplete' => 'on'])!!}
            <input type="text" class="displayNone" id="faktur_belanja_id" name="faktur_belanja_id" value="{!! $id !!}">
            <div id="pesan2"></div>
            <div class="row">
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <button class="btn btn-primary btn-block" id="dummySubmit" type="button">Submit</button>
                    {!! Form::submit('Submit', ['class' => 'btn btn-primary btn-block hide', 'id'=>'submit'])!!} 
              </div>
              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                  <a href="{{ url('fakturbelanjas')}}" class="btn btn-danger btn-block">cancel</a>
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
          <input type="hidden" name="_token" id="token" value="{{ Session::token() }}">
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
          <input type="hidden" name="_token" value="{{ Session::token() }}">
          @include('raks.createForm', [
              'formula'  => $formula ,
              'modal'    => true,
              'stokShow' => true
          ])
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
          @include('mereks.createForm', ['rak' => $rak, 'modal' => true ])
        </form>
      </div> 
    </div>
  </div>
</div>
<button class="btn btn-info hide" type="button" onclick="testPrint();return false;" id="print">print</button>
<div class="row" id="content-print">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box title-print text-center">
            <h2>Laporan Penerimaan Obat</h2>
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
       .
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
        $('.modal').on('hidden.bs.modal', function(){
            $('.btn').removeAttr('disabled');
        }); 
      $('#dummySubmit').click(function(){
         $('.btn').attr('disabled', 'disabled'); 
          var staf_id = $('#staf_id').val();
          var tempBeli = $('#tempBeli').val();
          var arrau_yang_kosong = [];
          if(staf_id == '' || tempBeli == ''){
           if(staf_id == ''){
            validasi('#staf_id', 'Harus Diisi');
            arrau_yang_kosong[arrau_yang_kosong.length] = 'Staf Penanggung Jawab'
           }
           if(tempBeli == ''){
            validasi('#tempBeli', 'Harus Diisi');
            arrau_yang_kosong[arrau_yang_kosong.length] = 'Daftar Belanja'
           }
           if(arrau_yang_kosong.length == 1){
            var pesan = arrau_yang_kosong[0] + ' harus diisi terlebih dahulu';
           } else {
               var pesan = arrau_yang_kosong[0] + ' dan ' + arrau_yang_kosong[1] + ' harus diisi terlebih dahulu';
           }
           alert(pesan);
           $('.btn').removeAttr('disabled');
          } else {
              testPrint();
         }
      }); 
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
        if ($('#class_rak').val() == '3') {
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
        if (
          $('#ddl_merek_id').val() == '' ||
          $('#txt_exp_date').val() == '' ||
          $('#txt_harga_beli').val() == '' ||
          $('#txt_harga_jual').val() == '' ||
          $('#txt_jumlah').val() == ''
        ){

          if($('#ddl_merek_id').val() == ''){
            validasi('#ddl_merek_id', 'Harus Diisi!!');
          }
          if($('#txt_exp_date').val() == ''){
            validasi('#txt_exp_date', 'Harus Diisi!!');
          }
          if($('#txt_harga_beli').val() == ''){
            validasi('#txt_harga_beli', 'Harus Diisi!!');
          }
          if($('#txt_harga_jual').val() == ''){
            validasi('#txt_harga_jual', 'Harus Diisi!!');
          }
          if($('#txt_jumlah').val() == ''){
            validasi('#txt_jumlah', 'Harus Diisi!!');
          }
        } else {

            var merek = $(control).closest('tr').find('td:nth-child(1) select option:selected').text();
            var ddl_value = $(control).closest('tr').find('td:nth-child(1) select option:selected').attr('data-value');
            var harga_beli = $(control).closest('tr').find('td:nth-child(2) input').val();
            var harga_jual = $(control).closest('tr').find('td:nth-child(3) input').val();
            var exp_date = $(control).closest('tr').find('td:nth-child(4) input').val();
            var today = hari_ini();

            var jumlah = $(control).closest('tr').find('td:nth-child(5) input').val();

            var merek_id = getMerekId(ddl_value);
            var harga_beli_awal = getHargaBeli(ddl_value);
            var exp_date_awal = getExpDate(ddl_value);
            var sediaan = getSediaan(ddl_value);

            // console.log('exp_date = ' + exp_date);
            // console.log('today = ' + today);
            // console.log('exp_date_awal = ' + exp_date_awal);

            var harga_berubah = harga_beli - harga_beli_awal;

            dataTambah = {
              'merek' : merek,
              'merek_id' : merek_id,
              'harga_beli' : harga_beli,
              'harga_jual' : harga_jual,
              'harga_berubah' : harga_berubah,
              'exp_date' : exp_date,
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

            var merek_bool = false;
            for (var i = 0; i < data.length; i++) {
              if(data[i].merek_id == merek_id){
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
      var temp = '';
      var total = 0;
      for (var i = 0; i < dataf.length; i++) {

        var biaya = parseInt(dataf[i].harga_beli) * parseInt(dataf[i].jumlah);
        temp += '<tr>';
        temp += '<td nowrap>' + (i + 1) + '</td>';
        temp += '<td nowrap>' + dataf[i].merek + '</td>';
        temp += '<td nowrap class="uang2">' + dataf[i].harga_beli + '</td>';
        temp += '<td nowrap class="uang2">' + dataf[i].harga_jual + '</td>';
        temp += '<td nowrap>' + dataf[i].exp_date + '</td>';
        temp += '<td nowrap class="jumlah">' + dataf[i].jumlah + '</td>';
        temp += '<td nowrap class="uang2">' + biaya + '</td>';
        temp += '<td nowrap><a href="#" class="btn btn-danger btn-xs" onclick="rowDel(' + i + ');return false;">hapus</a></td>';
        temp += '</tr>';

        total += biaya;

      };

      clearForm();

      $('#tableEntriBeli tbody').html(temp);
      $('#tempBeli').val(JSON.stringify(dataf));
      $('#totalHargaObat').html(uang( total ));

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
      return false;
    }

    function rowDel(control){

        data.splice(control, 1);
        viewData(data);

    }
    function ddlChange(control){
      if ($(control).val() != '') {

            control = $('#ddl_merek_id option:selected').attr('data-value');
            console.log(control);
            control = $.parseJSON(control);

            console.log(control);

            var merek_id = control.merek_id;
            var harga_jual = control.harga_jual;
            var class_rak = control.class_rak;
            var exp_date = control.exp_date;
            if (exp_date != null) {
              exp_date = exp_date.split('-');
              exp_date = exp_date[2] + '-' + exp_date[1] + '-' + exp_date[0]
            }

            var harga_beli = control.harga_beli;

            $('#txt_harga_beli').val(harga_beli);
            jual = harga_jual;
            $('#txt_harga_jual').val(harga_jual);
            $('#class_rak').val(class_rak);
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
    function dummySubmit(){
       $('.btn').attr('disabled', 'disabled'); 
        var staf_id = $('#staf_id').val();
        var tempBeli = $('#tempBeli').val();
        var arrau_yang_kosong = [];
        if(staf_id == '' || tempBeli == ''){
         if(staf_id == ''){
          validasi('#staf_id', 'Harus Diisi');
          arrau_yang_kosong[arrau_yang_kosong.length] = 'Staf Penanggung Jawab'
         }
         if(tempBeli == ''){
          validasi('#tempBeli', 'Harus Diisi');
          arrau_yang_kosong[arrau_yang_kosong.length] = 'Daftar Belanja'
         }
         if(arrau_yang_kosong.length == 1){
          var pesan = arrau_yang_kosong[0] + ' harus diisi terlebih dahulu';
         } else {
             var pesan = arrau_yang_kosong[0] + ' dan ' + arrau_yang_kosong[1] + ' harus diisi terlebih dahulu';
         }
         alert(pesan);
         $('.btn').removeAttr('disabled');
        } else {
            $('#print').removeAttr('disabled').click();
       }
    }
function testPrint(){
    var tempBeli = $('#tempBeli').val();
    tempBeli = $.parseJSON(tempBeli);
    var staf= $('#staf_id option:selected').text();
    $('.staf-print').html(staf);
    var temp = '';
    var totalBiaya = 0;
    for (var i = 0; i < tempBeli.length; i++) {
        var harga = tempBeli[i].harga_beli * tempBeli[i].jumlah;
        temp += '<tr>';
        temp += '<td>' + tempBeli[i].merek + '</td>'
        temp += '<td class="text-right" nowrap>' + uang( tempBeli[i].harga_beli ) + '</td>'
        temp += '<td class="text-right" nowrap>' + tempBeli[i].jumlah + '</td>'
        temp += '<td class="text-right" nowrap>' + uang( harga ) + '</td>'
        temp += '</tr>';
        totalBiaya += harga;
    }
    $('#totalBiaya').html(uang( totalBiaya ));
    $('#daftarBelanja').html(temp);
    $('#submit').removeAttr('disabled').click();
}

  </script>
@stop
