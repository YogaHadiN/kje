@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Antrian Beli Obat

@stop
@section('page-title') 
<h2>Antrian Faktur Obat</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}}">Home</a>
      </li>
      <li class="active">
          <strong>Riwayat Pembelian</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $faktur_beli->count() !!}</h3>
                </div>
                <div class="panelRight">
                  <h3>Bulan : {!! $bth !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered table-hover" id="tabel_faktur_beli">
					  <thead>
						<tr>
						  <th class="hide">id</th>
						  <th>tanggal</th>
						  <th>Nama Supplier</th>
						  <th>Nomor Faktur</th>
						  <th>Biaya</th>
						  <th>Action</th>
						</tr>
					</thead>
					<tbody>
					  @foreach ($faktur_beli as $fb)
					  <tr>
						  <td class="hide"><div>{!!$fb->id!!}</div></td>
						  <td><div>{!!App\Models\Classes\Yoga::updateDatePrep($fb->tanggal)!!}</div></td>
						  <td><div>{!!$fb->supplier->nama!!}</div></td>
						  <td><div>{!!$fb->nomor_faktur!!}</div></td>
						  <td><div class="uang">{!! $fb->harga !!}</div></td>
						  <td><div><a href="{{ url('pembelians/show/' . $fb->id) }}}" class="btn-sm btn btn-primary btn-xs">Detail</a>
						  </div></td>
					  </tr>
					  @endforeach
					  
					</tbody>
					<tfoot>
					  <tr>
						  <td colspan="3" class="text-right bold">Total Pembelian : </td>
						  <td class="bold uang" id="totalHargaObat" colspan="2">{!! $harga !!}</td>
					  </tr>
					</tfoot>
				</table>
		  </div>
      </div>
</div>

@stop
@section('footer') 

<script>
  $(document).ready(function() {
    $('#dummySubmit').click(function(){

      if (
        $('input[name="tanggal"]').val() == '' ||
        $('input[name="nomor_faktur"]').val() == '' ||
        $('select[name="supplier_id"]').val() == ''
      ) {

        if ($('input[name="tanggal"]').val() == '') {
          validasi('input[name="tanggal"]', 'Harus Diisi!!');
        }
        if ($('input[name="nomor_faktur"]').val() == '') {
          validasi('input[name="nomor_faktur"]', 'Harus Diisi!!');
        }
        if ($('select[name="supplier_id"]').val() == '') {
          validasi('select[name="supplier_id"]', 'Harus Diisi!!');
        }
      } else{
        $('#submitFaktur').click();
      }

    });



    $('#submitFaktur').click(function(e) {
      var tanggal = $('input[name="tanggal"]').val();
      var nomor_faktur = $('input[name="nomor_faktur"]').val();
      var supplier_id = $('select[name="supplier_id"]').val();

      $.post('faktur_belis', {'tanggal' : tanggal, 'nomor_faktur' : nomor_faktur, 'supplier_id' : supplier_id, '_token' : '{{ Session::token() }}'}, function(data) {
        data = $.trim(data);
        if(data){
          MyArray = JSON.parse(data);

          var temp = '';

          temp += '<tr>';
          temp += '<td class="yellow"><div>' + MyArray.id + '</div></td>';
          temp += '<td class="yellow"><div>' + MyArray.tanggal + '</div></td>';
          temp += '<td class="yellow"><div>' + MyArray.supplier + '</div></td>';
          temp += '<td class="yellow"><div>' + MyArray.nomor_faktur + '</div></td>';
          temp += '<td class="yellow"><div><a class="btn-sm btn btn-primary btn-xs" href="{{ url("pembelians/' + MyArray.id + '") }}">Proses</a> <a href="#" class="btn btn-danger btn-xs" onclick="rowDel(this);return false;">hapus</a><div></td>'
          temp += '</tr>';

          console.log(temp);

          $('#faktur_insert').modal('hide');
          $('select [name="supplier_id"]').val('').selectpicker('refresh');
          $('input [name="tanggal"]').val('');
          $('input [name="nomor_faktur"]').val('');

          $('#tabel_faktur_beli tbody').append(temp);
          $('#tabel_faktur_beli tbody tr:last-child td div').hide().slideDown('500', function() {
            $(this).closest('td').addClass('loaded');
          });
        } else {
          alert('Input Gagal!!');
        }
      });
    });

    
  });

function rowDel(control){

  var id = $(control).closest('tr').find('td:first-child div').html();
  var rowIndex = $(control).closest('tr').index() + 1;
  var r = confirm('Anda yakin mau menghapus faktur beli ' + id);
  if(r){
    $.post('delete/faktur_belis', {'id': id, '_token' : '{{ Session::token() }}'}, function(data) {
      data = $.trim(data);
      if(data == '1'){
          $('#tabel_faktur_beli tbody tr:nth-child(' + rowIndex + ')').find('div').slideUp('500', function() {
            $('#tabel_faktur_beli tbody tr:nth-child(' + rowIndex + ')').hide();
          });
      } else {
        alert('gagal menghapus');
      }
      /*optional stuff to do after success */
    });
  }
}
</script>
  
@stop
