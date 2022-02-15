@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Pendapatans Lain

@stop
@section('page-title') 
<h2>Pendapatan Lain</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Pendapatan Lain</strong>
      </li>
</ol>

@stop
@section('content') 
@if (Session::has('print'))
   <div id="print-struk">
       
   </div> 
@endif
{!! Form::open(['url' => 'pendapatans/index']) !!}
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <div class="panelLeft">Pendapatan Lain-Lain</div>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::open(['url'=>'pendapatans', 'method'=> 'post']) !!} 
					<div class="form-group @if($errors->has('sumber_uang'))has-error @endif">
					  {!! Form::label('sumber_uang', 'Sumber Uang', ['class' => 'control-label']) !!}
					  {!! Form::text('sumber_uang',  null, ['class' => 'form-control selectpick cek_pembayaran_asuransi rq', 'data-live-search' => 'true']) !!}
					  @if($errors->has('sumber_uang'))<code>{{ $errors->first('sumber_uang') }}</code>@endif
					</div>
					<div class="form-group @if($errors->has('coa_id'))has-error @endif">
					  {!! Form::label('coa_id', 'Kas masuk Ke', ['class' => 'control-label']) !!}
                      {!! Form::select('coa_id', $coa_ids, 110000, ['class' => 'form-control selectpick rq']) !!}
					  @if($errors->has('coa_id'))<code>{{ $errors->first('coa_id') }}</code>@endif
					</div>
					<div class="form-group @if($errors->has('staf_id'))has-error @endif">
					  {!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
                      {!! Form::select('staf_id', App\Models\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true']) !!}
					  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
					</div>
					<div class="form-group @if($errors->has('tanggal'))has-error @endif">
					  {!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
                      {!! Form::text('tanggal' , date('d-m-Y'), ['class' => 'form-control tanggal rq']) !!}
					  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
					</div>
					<div class="form-group @if($errors->has('nilai'))has-error @endif">
					  {!! Form::label('nilai', 'Nilai', ['class' => 'control-label']) !!}
					  {!! Form::text('nilai' , null, ['class' => 'form-control rq uangInput']) !!}
					  @if($errors->has('nilai'))<code>{{ $errors->first('nilai') }}</code>@endif
					</div>
					<div class="form-group @if($errors->has('keterangan'))has-error @endif">
					  {!! Form::label('keterangan', 'Keterangan', ['class' => 'control-label']) !!}
                      {!! Form::textarea('keterangan' , null, ['class' => 'form-control textareacustom cek_pembayaran_asuransi rq']) !!}
					  @if($errors->has('keterangan'))<code>{{ $errors->first('keterangan') }}</code>@endif
					</div>
                    <div class="form-group">
						<button class="btn btn-success btn-block btn-lg" type="button" onclick="cek_tagihan();">Submit</button>
						{!! Form::submit('Submit Pendapatan Lain-lain', ['class' => 'btn btn-success btn-block btn-lg hide', 'id' => 'submit_form']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="alert alert-info">
			<h2>Perhatian</h2>
			<p>Pastikan Transaksi ini bukan :</p>
            <ul>
                <li>Pendapatan dari Pemeriksaan Pasien</li>
				<li>Pendapatan dari  <a  href="{{ url('pembayarans/asuransi') }}">Pembayaran Tagihan Asuransi</a> </li>
				<li>Pendapatan dari  <a  href="{{ url('pembayarans/asuransi') }}">Pembayaran Tagihan Perusahaan</a> </li>
            </ul>
			<p>karena masing2 sudah ada form yang berbeda</p>
					
        </div>
		<div class="alert alert-danger hide" id="tagihan">
			<h2>Konfirmasikan</h2>
			<p>Konfirmasikan transaksi ini bukan didapat dari pembayaran tagihan asuransi dan perusahaan</p>
			<p>karena masing2 sudah ada form yang berbeda</p>
			{!! Form::hidden('konfirmasikan', '0', ['class' => 'form-control', 'id' => 'konfirmasikan']) !!}
			<br />
			<button class="btn btn-warning btn-lg btn-block" type="button" id="confirm_button" onclick="confirmed();return false;">Konfirmasikan</button>
			<button class="btn btn-primary btn-lg btn-block hide" type="button" id="unconfirm_button" onclick="unconfirmed();return false;">Batalkan Konfirmasi</button>
		</div>
    </div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Pendapatan Lain-Lain</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
				<?php echo $pendapatans->appends(Input::except('page'))->links(); ?>
					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>Sumber Uang</th>
								<th>Kas Masuk Ke</th>
								<th>Nama Petugas</th>
								<th>Nilai Uang</th>
								<th>Keterangan</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pendapatans as $p)
								<tr>
									<td>{{ $p->created_at->format('d-m-Y') }}</td>
									<td>{{ $p->sumber_uang }}</td>
									<td>{{ $p->jurnals[0]->coa->coa }}</td>
									<td>{{ $p->staf->nama }}</td>
									<td class="uang">{{ $p->nilai }}</td>
									<td>{{ $p->keterangan }}</td>
									<td> <a target="_blank" class="btn btn-info btn-xs btn-block" href="{{ url('pdfs/pendapatan/' . $p->id) }}">Struk</a>  </td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<?php echo $pendapatans->appends(Input::except('page'))->links(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}
@stop
@section('footer') 
<script>
	var asuransis = {!! json_encode( $asuransis ) !!};
	  jQuery(document).ready(function($) {
			if( $('#print-struk').length ){
				window.open("{{ url('pdfs/pendapatan/' . Session::get('print')) }}", '_blank');
			}
			$('#konfirmasikan').val('0');
			$('#input').keypress(function(e) {
				  var key = e.which || e.keyCode;
				  if (key == 9) {
					$(this).click();
					return false;
				  }
			});
	  });
	function inputt(control){

    var pass = true;
    var string = '';
    $('.rq').each(function(index, el) {
      if ($(this).val() == '') {
        validasi('#' + $(this).attr('id'), 'Harus Diisi!!');
        string += $(this).attr('content') + ', ';
        pass = false;
      }
    });
		if (pass) {
			var pendapatan = $(control).closest('tr').find('td:first-child input').val();
			var jumlah = $(control).closest('tr').find('td:nth-child(2) input').val();
		  var keterangan = $(control).closest('tr').find('td:nth-child(3) input').val();
			var staf_id = $('#staf_id').val();

		  string = $('#array').val();
		  data = $.parseJSON(string);
			data[data.length] = {
				'pendapatan' : pendapatan,
			'jumlah' : jumlah,
				'staf_id' : staf_id,
				'keterangan' : keterangan
			};

			var string = JSON.stringify(data);
			$('#array').val(string);
			view();
		} else {
		  alert(string + ' Tidak boleh dikosongkan');
		}
	}

	function view(){

		var MyArray = $('#array').val();

		MyArray = $.parseJSON(MyArray);

		var temp = '';
		for (var i = 0; i < MyArray.length; i++) {
			temp += '<tr>'
			temp += '<td>' + MyArray[i].pendapatan + '</td>';
			temp += '<td>' + MyArray[i].jumlah + '</td>';
      temp += '<td>' + MyArray[i].keterangan + '</td>';
			temp += '<td><button type="button" class="btn btn-danger btn-xs" onclick="del(this);return false;" value="' + i + '">delete</button></td>';
			temp += '</tr>'
		};

		$('#ajax').html(temp);
    $('.ini').val('');
    $('#pendapatan').focus();
	}

  function del(control){
    var i = $(control).val();
    string = $('#array').val();

    dataString = $.parseJSON(string);

    dataString.splice(i, 1);

    string = JSON.stringify(dataString);

    $('#array').val(string);
    view();
  }

  function submit(){

    var array = $('#array').val();
    if (array !=  '[]' && array != '') {
        $('#submit').click();
    } else {
      alert('tidak ada Transaksi pendapatan yang bisa dimasukkan');
    }

  }
	function cek_tagihan(){
		if( $('#konfirmasikan').val() == '0' ){
			var tagihan = false;
			var asuransi = false;
			$('.cek_pembayaran_asuransi').each(function(){
				var text = $(this).val();
				if(text.indexOf('tagihan') >= 0){
					tagihan = true;
					return false;
				}
				var ass = asuransis;
				for (var i = 0; i < ass.length; i++) {
					if(text.indexOf(ass[i]) >= 0){
						asuransi = true;
						break;
					}
				}
			});	 
			if(asuransi || tagihan){
				$('#perhatian').hide();
				$('#tagihan').removeClass('hide').hide().fadeIn(500);
				alert('Mohon Pastikan kembali bahwa ini bukan pendapatan dari pembayaran tagihan asuransi atau perusahaan');
			} else {
				 validate_form();
			}
		} else {
			 validate_form();
		}
	}

	function confirmed(){
		$('#konfirmasikan').val('1');	 
		$('#confirm_button').fadeOut(500, function(){
			$('#unconfirm_button').removeClass('hide').fadeIn(500, function(){
				 $(this).focus();
			});	 
		});	 
	}
	function unconfirmed(){
		$('#konfirmasikan').val('0');	 
		$('#unconfirm_button').fadeOut(500, function(){
			$('#confirm_button').removeClass('hide').fadeIn(500, function(){
				 $(this).focus();
			});	 
		});	 
	}
function validate_form(){
	 if( validatePass() ){
		 $('#submit_form').click();
	 }
}

</script>
	
@stop
