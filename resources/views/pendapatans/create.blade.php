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

<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="form-group">
          {!! Form::label('staf_id', 'Nama Staf : ') !!}
          {!! Form::select('staf_id', App\Classes\Yoga::stafList(), null, ['class' => 'rq form-control', 'id' => 'staf_id', 'content' => 'Nama Staf']) !!}
        </div>
      </div>
    </div>        
  </div>
</div>
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : </h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-striped table-bordered table-hover" id="tableAsuransi">
                  <thead>
                    <tr>
 						<th>Pendapatan Lain</th>
 						<th>Biaya</th>
 						<th>Yang Menyerahkan Uang</th>
 						<th>Action</th>
                    </tr>
                </thead>
                <tbody id="ajax">
                	

                </tbody>
                <tfoot>
                	<td>
                		{!! Form::text('pendapatan', null, ['class' => 'rq form-control ini', 'placeholder' => 'contoh: Fee Rumah Sakit', 'id' => 'pendapatan', 'content' => 'Pendapatan Lain'])!!}
                	</td>
                	<td>
                		{!! Form::text('jumlah', null, ['class' => 'rq form-control ini', 'placeholder' => 'contoh: 300000', 'content' => 'Biaya', 'id' => 'jumlah'])!!}
                	</td>
                	<td>
                		{!! Form::text('keterangan', null, ['class' => 'rq form-control ini', 'placeholder' => 'contoh: RS Murni Asih', 'content' => 'Yang Menyerahkan Uang', 'id' => 'keterangan'])!!}
                	</td>
                	<td>
                		<button type='button' class="btn btn-primary" onclick="input(this); return false;" id='input'>Input</button>
                	</td>
                </tfoot>
            </table>
            {!! Form::open(['url' => 'pendapatans/index']) !!}
				{!! Form::textarea('array', '[]', ['class' => 'form-control hide', 'id' => 'array']) !!}
				{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit'])!!}
			{!! Form::close() !!}
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
               <button class="btn btn-primary btn-lg btn-block" onclick="submit(); return false;">Submit</button>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              {!! HTML::link('laporans', 'Cancel', ['class' => 'btn btn-danger btn-lg btn-block'])!!}
            </div>
          </div>
      </div>
</div>


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

	function input(control){

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