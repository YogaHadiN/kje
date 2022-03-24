@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Entri Beli Obat

@stop
@section('head') 
<style type="text/css" media="all">
.padding-bottom{
	padding-bottom:10px;
}
</style>
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
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Nomor Faktur :</h3>
                </div>
                <div class="panelRight bold">
                  <span class="">Total : </span><span class="uang " id="totalHargaObat">0</span>
                </div>
            </div>
      </div>
      <div class="panel-body">

		  <div class="table-responsive">
			  <div class="row">
				<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
					Menampilkan <span id="rows"></span> data
				</div>
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding-bottom">
					{!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
						'class'    => 'form-control ',
						'onchange' => 'clearAndView();return false;',
						'id'       => 'displayed_rows'
					]) !!}
				</div>
			  </div>
			  <div class="table-responsive">
					<table class="table table-bordered" id="tableEntriBeli" nowrap>
						  <thead>
							<tr>
							   <th>
								   Tanggal <br />
								   {!! Form::text('tanggal',  null, [
									   'class' => 'form-control', 
									   'onkeyup' => 'clearAndView();return false;', 
									   'id' => 'tanggal'
								   ]) !!}
							   </th>
							   <th>
								   Nomor Faktur <br />
								   {!! Form::text('nomor_faktur',  null, [
									   'class' => 'form-control', 
									   'onkeyup' => 'clearAndView();return false;', 
									   'id' => 'nomor_faktur'
								   ]) !!}
							   </th>
							   <th>Nama Supplier <br />
								   {!! Form::text('nama_supplier',  null, [
									   'class' => 'form-control', 
									   'onkeyup' => 'clearAndView();return false;',
									   'id' => 'nama_supplier'
								   ]) !!}
							   </th>
							   <th>Merek Obat <br />
								   {!! Form::text('merek',  null, [
									   'class'   => 'form-control',
									   'onkeyup' => 'clearAndView();return false;',
									   'id'      => 'merek'
								   ]) !!}
							   </th>
							   <th>Harga Beli </th>
							   <th>Harga Jual </th>
							   <th>Jumlah</th>
							</tr>
						</thead>
						<tbody id="content">
						</tbody>
					</table>
			  </div>
				<div id="page-box">
					<nav class="text-right" aria-label="Page navigation" id="paging">
					
					</nav>
				</div>
		  </div>
      </div>
</div>
@stop
@section('footer') 

<script src="{!! url('js/twbs-pagination/jquery.twbsPagination.min.js') !!}"></script>
<script type="text/javascript" charset="utf-8">
	view();
	function view(key = 0){
		var base = "{{ url('/') }}";
		var displayed_rows = $('#displayed_rows').val();
		var nama_supplier = $('#nama_supplier').val();
		var nomor_faktur = $('#nomor_faktur').val();
		var merek = $('#merek').val();
		var harga_beli = $('#harga_beli').val();
		var harga_jual = $('#harga_jual').val();
		var tanggal = $('#tanggal').val();


		var param = { 
			'displayed_rows': displayed_rows,
			'nama_supplier':  nama_supplier,
			'nomor_faktur':   nomor_faktur,
			'merek':          merek,
			'key':            key,
			'tanggal':        tanggal,
			'harga_beli':     harga_beli,
			'harga_jual':     harga_jual
		};
		$.post( base + '/pembelians/ajax', param, function(hasil) {

			var data  = hasil.data;
			var key   = hasil.key;
			var rows  = hasil.rows;
			var pages = hasil.pages;

			var temp = '';

			 for (var i = 0; i < data.length; i++) {
				 temp += '<tr>';
				 temp += '<td nowrap>' + data[i].tanggal +  '</td>';
				 temp += '<td>' + data[i].nomor_faktur +  '</td>';
				 temp += '<td>' + data[i].nama_supplier +  '</td>';
				 temp += '<td>' + data[i].merek +  '</td>';
				 temp += '<td class="text-right" nowrap>' + uang( data[i].harga_beli ) +  '</td>';
				 temp += '<td class="text-right" nowrap>' + uang( data[i].harga_jual ) +  '</td>';
				 temp += '<td class="text-right" nowrap>' + data[i].jumlah +  '</td>';
				 temp += '</tr>';
			 }

			$('#content').html(temp);
			$('#rows').html(rows);
			$('#paging').twbsPagination({
				startPage: parseInt(key) +1,
				totalPages: pages,
				visiblePages: 7,
				onPageClick: function (event, page) {
					view(parseInt( page ) -1);
				}
			});
			
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
