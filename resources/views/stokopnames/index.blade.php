@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Entri Jual Obat

@stop
@section('page-title') 
<h2>Penjualan Obat Tanpa Resep</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Penjualan Tanpa Resep</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-default">
      <div class="panel-body">
      {!! Form::open(['url' => 'stokopnames'])!!}
      <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<div class="form-group @if($errors->has('staf_id'))has-error @endif">
			  {!! Form::label('staf_id', 'Staf Penginput', ['class' => 'control-label']) !!}
              {!! Form::select('staf_id', App\Models\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search' => true, 'id' => 'staf_id'])!!}
			  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
			</div>
        </div>
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			  <div class="form-group @if($errors->has('bulanTahun'))has-error @endif">
			    {!! Form::label('bulanTahun', 'Bulan', ['class' => 'control-label']) !!}
                {!! Form::text('bulanTahun',  date('m-Y'), ['class' => ' form-control bulanTahun', 'id' => 'bulanTahun'])!!}
			    @if($errors->has('bulanTahun'))<code>{{ $errors->first('bulanTahun') }}</code>@endif
			  </div>
         </div>
         <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 hide">
          <div class="form-group">
              {!! Form::label('')!!}
               <a href="#" class="btn btn-success btn-block">Laporan</a>
            </div>
         </div>
      </div>
      </div>
    </div>
  </div>
</div>
<div class="panel panel-primary">
    <div class="panel-heading">
          <div class="panel-title">
              <div class="panelLeft">
                <h3>Formulir Stok Opname</h3>
              </div>
              <div class="panelRight">
                <h3>Rak yang belum di cek (<span id="count"></span>)</h3>
              </div>
          </div>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="" nowrap>
					  <thead>
						<tr>
						  <th>Nama Merek / Rak</th>
						  <th>Stok Fisik</th>
						  <th>Kadaluarsa</th>
						  <th>Action</th>
						</tr>
					</thead>
					<tbody id="StokBody">
					  
					</tbody>
					  <tfoot>
						<tr>
						  <td>
							<select name="rak_id" id="rak_id" class="selectpick input" data-live-search="true" onchange="ddlChange();">
							</select>

						  </td>
						  <td>{!! Form::text('stok_fisik', null, ['class' => 'form-control input req', 'id' => 'stok_fisik'])!!}</td>
						  <td>{!! Form::text('exp_date', null, ['class' => 'form-control input req tanggal', 'id' => 'exp_date'])!!}</td>
						  <td><a href="#" onclick="input(this);return false;" class="btn btn-primary btn-sm" id="input">input</a></td>
						  {!! Form::close()!!}
						</tr>
					</tfoot>
				</table>
			</div>
            <div class="alert alert-success">
              Pada Stok Opname setiap bulan, harus dilakukan serentak, penginputan pelayanan pasien dll dilakukan secara manual sementara masih diisi, stok obat dipertahankan tetap saat input, setelah penginputan selesai, bisa dilanjutkan penginputan pelayanan pasien dengan aplikasi kembali
            </div>
        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
           <table class="table table-condensed table-bordered">
          <thead>
            <tr>
              <th>Rak</th>
              <th>Merek</th>
            </tr>
          </thead>
          <tbody id='sisa'>

          </tbody>
		   </table>
        </div>
      </div>
    </div>
</div>

@stop
@section('footer') 
  <script>
  jQuery(document).ready(function($) {
  	$.post('{{ url("stokopnames/awal") }}', { 'bulanTahun' : $('#bulanTahun').val(), '_token' : '{{ Session::token() }}'}, function(data) {
  		viewAwal(data);
  	});

  	$('#input').keypress(function(e) {
  		var key = e.keyCode || e.which;
  		if (key == 9) {
  			$(this).click();
        return false;
  		};
  	});

  });
  	function input(control){
      var lanjut = true;
      var elm = ''
      $('.req').each(function(index, el) {
        if ($(this).val() == '') {
          lanjut = false;
          elm += $(this).attr('id') + ', ';       
          validasi4(this, 'harus diisi');
        } 
      });

      if ($('#staf_id').val() == '') {
        elm += 'Nama Penginput, ';
        lanjut = false;
      };

      if ($('#rak_id').val() == '') {
        lanjut = false;
        elm += $('#rak_id').attr('id');
        validasi2('#rak_id', 'Harus Diisi!');
      };
  		if (lanjut){
        var param = $('form').serializeArray();
      
            $.post('{{ url("stokopnames") }}', param, function(data, textStatus, xhr) {
              data = $.trim(data);
              datat = $.parseJSON(data);
              if (datat.confirm == '1') {
              } else {
                alert('rak yang dimasukkan sudah di cek')
              }
            viewAwal(data);
      
            });
        } else {
            alert(elm + ' tidak boleh dikosongkan');
        }

  	}



  	function del(control){
  		var id = $(control).val();
  		$.post('{{ url("stokopnames/destroy") }}', {'id': id, 'bulanTahun' : $('#bulanTahun').val(), '_token' : '{{ Session::token() }}' }, function(data) {
  			data = $.trim(data);
  			datat = $.parseJSON(data);
  			if (datat.confirm == '1') {
  				$(control).closest('tr').find('div').slideUp('500', function(){
					viewAwal(data);
  				});
  			}
  		});
  	}

  	function viewAwal(data){
  		data = $.parseJSON(data);
  		var MyArray = data.array;
  		var temp = '';
  		for (var i = 0; i < MyArray.length; i++) {
  			temp += '<tr>';
  			temp += '<td><div>' + MyArray[i].merek +  ' -- ' + MyArray[i].kode_rak + '</div></td>';
  			temp += '<td class="hide"><div>' + MyArray[i].stok_komputer + '</div></td>';
  			temp += '<td><div>' + MyArray[i].stok_fisik + '</div></td>';
  			temp += '<td><div>' + tanggal(MyArray[i].exp_date) + '</div></td>';
  			temp += '<td><div><button type="button" class="btn btn-danger btn-sm" onclick="del(this);return false;" value="' + MyArray[i].so_id + '">delete</button></div></td>';
  			temp += '</tr>';
  		}
  		$('#StokBody').html(temp);
  		$('#rak_id')
  			.html(data.option)
        .val(null)
        .selectpicker('refresh')
  			.closest('div')
  			.find('.btn-white')
  			.focus();

        MyArray = data.sisa;
        temp = '';

        for (var i = 0; i < MyArray.length; i++) {
          temp += '<tr>';
          temp += '<td>' + MyArray[i].rak_id + '</td>';
          temp += '<td>' + MyArray[i].merek + '</td>';
          temp += '</tr>';
        };

      $('#sisa').html(temp).hide().fadeIn(500);
      $('#count').html(MyArray.length);
      $('.input').val('');
  	}
  	function ddlChange(){
      var rak_id = $('#rak_id').val();
  		$.post('{{ url("stokopnames/change") }}', {'rak_id': rak_id, '_token' : '{{ Session::token() }}'}, function(data, textStatus, xhr) {
  			data = $.trim(data);
  			$('#stok_komputer').val(data);
  		});
  	}
  </script>
@stop
