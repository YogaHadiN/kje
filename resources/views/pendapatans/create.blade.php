@extends('layout.master')

@section('title') 
Klinik Jati Elok | Pendapatans Lain

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
                    <div class="form-group">
                      {!! Form::label('sumber_uang', 'Sumber Uang') !!}
					  {!! Form::text('sumber_uang',  null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
                    </div>
					<div class="form-group">
                      {!! Form::label('staf_id', 'Petugas') !!}
                      {!! Form::select('staf_id', App\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::label('tanggal', 'Tanggal') !!}
                      {!! Form::text('tanggal' , date('d-m-Y'), ['class' => 'form-control tanggal']) !!}
                    </div>
					<div class="form-group">
                      {!! Form::label('nilai', 'Nilai') !!}
					 <div class="input-group">
                          <div class="input-group-addon">Rp. </div>
						  {!! Form::text('nilai' , null, ['class' => 'form-control']) !!}
                     </div>
                    </div>
					<div class="form-group">
                      {!! Form::label('keterangan', 'Uangnya didapat karena apa') !!}
                      {!! Form::textarea('keterangan' , null, ['class' => 'form-control textareacustom']) !!}
                    </div>
                    <div class="form-group">
                      {!! Form::submit('Submit Pendapatan Lain-lain', ['class' => 'btn btn-success btn-block btn-lg']) !!}
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
            </ul>
			<p>karena masing2 sudah ada form yang berbeda</p>
					
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
								<th>Nama Petugas</th>
								<th>Nilai Uang</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							@foreach($pendapatans as $p)
								<tr>
									<td>{{ $p->created_at->format('d-m-Y') }}</td>
									<td>{{ $p->sumber_uang }}</td>
									<td>{{ $p->staf->nama }}</td>
									<td class="uang">{{ $p->nilai }}</td>
									<td>{{ $p->keterangan }}</td>
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
  jQuery(document).ready(function($) {
    view();
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


</script>
	
@stop
