@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Antrian Beli Obat

@stop
@section('page-title') 
<h2>Antrian Belanja</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Cari Faktur Belanja Obat</strong>
      </li>
</ol>
@stop
@section('head') 
	<style type="text/css" media="all">
		#tabel_faktur_beli tbody tr td:first-child{

			width:85px;

		}
		.padding-bottom {
			margin-bottom:10px;
		}
	</style>
@stop
@section('content') 
@if (Session::has('print'))
   <div id="print-struk">
       
   </div> 
@endif
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3></h3>
                </div>
                <div class="panelRight">
					<a href="{{ url('suppliers/belanja_obat') }}" class="btn btn-success"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>	Belanja Obat Klik Disini</a>
                  </div>
                </div>
            </div>
      <div class="panel-body">
		  <div class="table-responsive">
			  <div class="row padding-bottom">
				  <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
					  Menampilkan <span id="rows"></span> data
				  	
				  </div>
			  	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				{!! Form::select('name', App\Models\Classes\Yoga::manyRows(), 15, [
					'class' => 'form-control',
					'onchange' => 'clearAndView();return false;',
					'id'    => 'displayed_rows'
				]) !!} 
			  	</div>
			  </div>
			  <div class="table-responsive">
					<table class="table table-bordered table-hover full-width" id="tabel_faktur_beli">
					  <thead>
						<tr>
							<th> Tanggal <br /> {!! Form::text('tanggal',  null, [
									'class' => 'form-control',
									'onkeyup' => 'clearAndView();return false',
									'id'    => 'tanggal'
								]) !!} </th>
							<th>Nama Supplier <br /> {!! Form::text('nama_supplier',  null, [
									'class' => 'form-control',
									'onkeyup' => 'clearAndView();return false',
									'id'    => 'nama_supplier'
								]) !!} 
							</th>
							<th> Nomor Faktur <br />{!! Form::text('nomor_faktur',  null, [
									'class' => 'form-control',
									'onkeyup' => 'clearAndView();return false',
									'id'    => 'nomor_faktur'
								]) !!} </th>
							<th>Total Biaya</th>
							<th>
								<button class="btn btn-danger btn-sm" type="button">Clear</button>
							</th>
						</tr>
					</thead>
					<tbody id="content"></tbody>
				</table>
			  </div>
			<div id="page-box">
				<nav class="text-right" aria-label="Page navigation" id="paging">
				
				</nav>
			</div>
		  </div>
      </div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Rekap Per Bulan </h3>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>Bulan</th>
						<th>Rekap</th>
					</tr>
				</thead>
				<tbody>
					@if(count($akumulasi) > 0)
						@foreach($akumulasi as $rekap)
							<tr>
								<td>{{ $rekap->bulan }}</td>
								<td>{{ App\Models\Classes\Yoga::buatrp( $rekap->total_per_bulan ) }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="">
								{!! Form::open(['url' => 'akumulasi/imports', 'method' => 'post', 'files' => 'true']) !!}
									<div class="form-group">
										{!! Form::label('file', 'Data tidak ditemukan, upload data?') !!}
										{!! Form::file('file') !!}
										{!! Form::submit('Upload', ['class' => 'btn btn-primary', 'id' => 'submit']) !!}
									</div>
								{!! Form::close() !!}
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop
@section('footer') 

<script src="{!! url('js/twbs-pagination/jquery.twbsPagination.min.js') !!}"></script>
<script type="text/javascript" charset="utf-8">
    $(function () {
		view();
        if( $('#print-struk').length ){
            window.open("{{ url('pdfs/pembelian/' . Session::get('print')) }}", '_blank');
        }
    });
	function view(key = 0){
		var base = "{{ url('/') }}";
		var tanggal        = $('#tanggal').val();
		var nama_supplier  = $('#nama_supplier').val();
		var nomor_faktur   = $('#nomor_faktur').val();
		var petugas        = $('#petugas').val();
		var displayed_rows = $('#displayed_rows').val();
		var temp = '';
		var param = { 
			'tanggal':        $('#tanggal').val(),
			'nama_supplier':  $('#nama_supplier').val(),
			'nomor_faktur':   $('#nomor_faktur').val(),
			'petugas':        $('#petugas').val(),
			'total_biaya':    $('#total_biaya').val(),
			'displayed_rows': $('#displayed_rows').val(),
			'key': key
		};

		$.post(base + '/pembelians/cari/ajax', param, function(hasil) {
			var data    = hasil.data;
            var base_s3 = "{{ \Storage::disk('s3')->url('') }}"
			var pages   = hasil.pages;
			var key     = hasil.key;
			var rows     = hasil.count;
			var temp    = '';
			 for (var i = 0; i < data.length; i++) {
				 temp += '<tr>';
				 temp += '<td>' + data[i].tanggal +  '</td>';
				 temp += '<td>' + data[i].nama_supplier +  '</td>';
				 temp += '<td>' + data[i].nomor_faktur +  '</td>';
				 temp += '<td nowrap class="text-right">' + uang( data[i].total_biaya ) +  '</td>';
				 temp += '<td>';
				 temp += '<a class="btn btn-info btn-xs" href="{{ url('pembelians/show') }}/' + data[i].faktur_belanja_id + '">Detail</a> ';
                if (data[i].bukti_transfer !== null) {
                     temp += '<a class="btn btn-success btn-xs" target="_blank" href="' + base_s3 + data[i].bukti_transfer + '">Bukti TF</a> ';
                }
				 temp += '<a class="btn btn-primary btn-xs" href="{{ url('pdfs/pembelian') }}/' + data[i].faktur_belanja_id + '" target="_blank">Struk</a>';
				 temp += '</td>';
				 temp += '</tr>';
			 }
			$('#content').html(temp);
			$('#rows').html(rows);
            if( data.length ){
                $('#paging').twbsPagination({
                    startPage: parseInt(key) +1,
                    totalPages: pages,
                    visiblePages: 7,
                    onPageClick: function (event, page) {
                        view(parseInt( page ) -1);
                    }
                });
            }
		});
	}
function clearAndView(key = 0){
	if($('#paging').data("twbs-pagination")){
		$('#paging').twbsPagination('destroy');
	}
	view(key);
}
</script>
@stop
