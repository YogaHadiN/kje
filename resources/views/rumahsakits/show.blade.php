@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Detail

@stop
@section('page-title') 
<h2>Detail Rumah Sakit</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('rumahsakits')}}">Rumah Sakit</a>
      </li>
      <li class="active">
          <strong>Detail</strong>
      </li>
</ol>
@stop
@section('content')
{!! Form::open(['url'=>'rumahsakits/' . $rumahsakit->id, 'method'=> 'put']) !!} 


{!! Form::text('rumah_sakit_id', $rumahsakit->id, ['class' => 'hide', 'id' => 'rumah_sakit_id']) !!} 


<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">Detail Rumah Sakit</div>
    </div>
    <div class="panel-body">
		<div class="table-responsive">
				<table class="table table-bordered table-hover table-condensed">
					<tbody>
						<tr>
							<td>Nama Rumah Sakit</td>
							<td> {!! Form::text('nama', $rumahsakit->nama, ['class' => 'form-control']) !!} </td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td> {!! Form::textarea('alamat', $rumahsakit->alamat, ['class' => 'form-control textareacustom']) !!} </td>

						</tr>
						<tr>
							<td>Telp</td>
							<td> {!! Form::text('telepon', $rumahsakit->telepon, ['class' => 'form-control']) !!} </td>
						</tr>
					</tbody>
				</table>
		</div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">List Spesialis</div>
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover table-condensed">
						<thead>
							<th>Nama Spesialis</th>
							<th>Action</th>
						</thead>
						<tbody>
						   <tr>
							   <td id="tdSpec">
								   {!! Form::select('tujuan_rujuks', App\Models\Classes\Yoga::TujuanRujukList(), null, ['class' => 'selectpick form-control', 'data-live-search' => 'true', 'id' => 'selectSpesialis']) !!} 
							   </td>
							   <td>
									<button class="btn btn-info btn-sm btn-block" type="button" onclick="tambahTJ(this);return false;">Tambah</button> 
							   </td>
						   </tr> 
						</tbody>
						  <tbody id="spesialiss">
							  
						  </tbody> 
					</table>
				</div>
            </div>
            {!! Form::textarea('spesialis', $rumahsakit->tujuanRujuk, ['class' => 'form-control hide', 'id' => 'spesialis']) !!}
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Daftar PIC</div>
            </div>
            <div class="panel-body">
				<div class="table-responsive">
					<table class="table  table-bordered table-hover table-condensed">
						<thead>
							<tr>
								<th>Nama</th>
								<th>Telp</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>

							<tr>
								<td> {!! Form::text('nama_pic', null, ['class' => 'form-control', 'id'=> 'nama']) !!} </td>
								<td> {!! Form::text('telp', null, ['class' => 'form-control', 'id'=> 'telp']) !!} </td>
								<td> <button class="btn btn-primary btn-sm btn-block" type="button" onclick="tambahBJ(this);return false;" id="tambahPIC">Tambah</button> </td>
							</tr>


						</tbody>
						<tbody id="bpjscenters">
						</tbody>
					</table>
				</div>
                {!! Form::textarea('bpjscenter', $rumahsakit->bpjsCenter, ['class' => 'form-control hide', 'id' => 'bpjscenter']) !!}
                
            </div>
        </div>
        
    </div>
    
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <button class="btn btn-success btn-lg btn-block" type="submit">Update</button>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <a href="{{ url("rumahsakits") }}" class="btn btn-danger btn-lg btn-block">Cancel</a>
    </div>
    
</div>

{!! Form::close() !!}

@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
    
    $(function () {
        render('spesialis', 'spesialiss', 'tujuan_rujuk');
        render('bpjscenter', 'bpjscenters', 'nama');
        $('#tambahPIC').keypress(function(e){
            var key = e.keyCode || e.which;
            if(key == 9){
             $(this).click();
            }
        });
    });

   function render(source_id, target_id, nama){
        var tujuanrujuks = $('#'+ source_id).val();
        tujuanrujuks = $.parseJSON(tujuanrujuks); 
        var temp = '<tr>';
        if(tujuanrujuks.length > 0){
            for (var i = 0; i < tujuanrujuks.length; i++) {
                temp += '<td>';
                if(nama == 'nama'){
                    temp += tujuanrujuks[i].nama;
                } else{
                    temp += tujuanrujuks[i].tujuan_rujuk;
                }
                temp += '</td>';
               if(nama == 'nama'){
                   temp += '<td>' + tujuanrujuks[i].telp + '</td>';
               }               
                temp += '<td nowrap>';
                if(nama == 'nama'){
                    temp += basicBC(i);
                } else {
                    temp += basicTJ(i, tujuanrujuks[i].id);
                }
                temp += '</td>';
                temp += '</tr>';
            }; 
        } else {
            if(nama == 'nama'){
                temp += '<td colspan="3" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>'
                temp += '</tr>';
            }else{
                temp += '<td colspan="2" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>'
                temp += '</tr>';
            }
            
        }
        
        $('#' + target_id).html(temp);
   } 
    function delTJ(control){
        var tj = $(control).closest('tr').find('td:first-child').html();
        var r = confirm('Anda yakin mau menghapus ' + tj + ' dari daftar Spesialis?');
        if(r){
            var id = $(control).val();
            var array = $('#spesialis').val(); 
            array = $.parseJSON(array);
            array.splice(id,1);
            $('#spesialis').val(JSON.stringify(array));
            render('spesialis', 'spesialiss', 'tujuan_rujuk');
        }
    }

    function delBC(control){
        var nama = $(control).closest('tr').find('td:first-child').html();
        var r = confirm('Anda Yakin mau menghapus ' + nama + ' dari daftar BPJS center?');
       if(r){
            var id = $(control).val();
            var array = $('#bpjscenter').val(); 
            array = $.parseJSON(array);
            array.splice(id,1);
            $('#bpjscenter').val(JSON.stringify(array));
            render('bpjscenter', 'bpjscenters', 'nama');
       }
    }
    
    function tambahTJ(control){
        var id = $('#selectSpesialis').val();
        if(id != ''){
            if(id != ''){
             var text = $('#selectSpesialis option:selected').text();
            }
            var json = $('#spesialis').val();
            json = $.parseJSON(json);
            sama = false;
            for (var i = 0; i < json.length; i++) {
                if(json[i].id == id){
                 sama = true;
                 break;
                }
            }
            if(sama){
             alert('Spesialis Yang Sama Sudah Dimasukkan, silahkan pilih spesialisasi yang lain');
             $('#selectSpesialis').val('').selectpicker('refresh').closest('div').find('.btn-white').focus();
             return false;
            }
            var data = {
                'id' : id,
                'tujuan_rujuk' : text
            }
            json[json.length] = data;
            $('#spesialis').val(JSON.stringify(json));
            render('spesialis', 'spesialiss', 'tujuan_rujuk');
             $('#selectSpesialis').val('').selectpicker('refresh').closest('div').find('.btn-white').focus();
        } else {
            validasi3('#selectSpesialis', 'Harus Diisi!');
        }
    }

    function tambahBJ(control){
        var nama = $('#nama').val();
        var telp = $('#telp').val();
        if(nama != '' && telp != ''){
            var data = {
                 'id' : null,
                 'nama' : nama,
                 'telp' : telp,
                 'rumah_sakit_id' : $('#rumah_sakit_id').val()
            };
            var json = $('#bpjscenter').val();
            json = $.parseJSON(json);
            json[json.length] = data;
            $('#bpjscenter').val(JSON.stringify(json));
            render('bpjscenter', 'bpjscenters', 'nama');
            $('#telp').val('');
            $('#nama').val('').focus();
            return false;
        } else {
           if(nama == ''){
               validasi('#nama', 'Harus diisi');
           }
           if(telp == ''){
               validasi('#telp', 'Harus diisi');
           }
            
        }
    }
    
    function editBC(control){
        $('button').attr('disabled', 'disabled');
        var nama = $(control).closest('tr').find('td:first-child').html();
        var telp = $(control).closest('tr').find('td:nth-child(2)').html();
        var textnama = '<input type="text" class="form-control  nama" onfocus="this.select();" onmouseup="return false;" data-temp="' + nama + '" value="' + nama + '">';
        var texttelp = '<input type="text" class="form-control telp" data-temp="' + telp + '" value="' + telp + '">';
        $(control).closest('tr').find('td:first-child').html(textnama);
        $(control).closest('tr').find('td:nth-child(2)').html(texttelp);
        $(control).closest('tr').find('.nama').focus();
        var editAction = ''; 
        var i = $(control).val();
        editAction += '<div class="row">';
        editAction += '<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">';
        editAction += '<button class="btn btn-success btn-xs" type="submit" onclick="updateBC(this);return false;" value="' + i + '">update</button>'
        editAction += '</div>'
        editAction += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
        editAction += '<button class="btn btn-danger btn-xs" type="submit" onclick="cancelBC(this);return false;" value="' + i + '">cancel</button>'
        editAction += '</div>'
        editAction += '</div>'
        $(control).closest('td').html(editAction);
    }
    function editTJ(control){
        var i = $(control).val();
        var tujuan_rujuk_id = $(control).attr('tujuan_rujuk_id');
        var tool = $('#tdSpec').find('select')[0].outerHTML;
        var text = $(control).closest('tr').find('td:first-child').html();
        $('button').attr('disabled', 'disabled');
        var editAction = '';
        editAction += '<div class="row">';
        editAction += '<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">';
        editAction += '<button class="btn btn-success btn-xs" data-text="' + text + '" type="submit" onclick="updateTJ(this);return false;" value="' + i + '">update</button>'
        editAction += '</div>'
        editAction += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
        editAction += '<button class="btn btn-danger btn-xs" type="submit" data-text="' + text + '" data-id="' + tujuan_rujuk_id + '" onclick="cancelTJ(this);return false;" value="' + i + '">cancel</button>'
        editAction += '</div>'
        editAction += '</div>'
        $(control).closest('tr').find('td:first-child').html(tool);
        $(control).closest('tr').find('td:first-child select').val(tujuan_rujuk_id).selectpicker('refresh').closest('td').find('.btn-default').removeClass('btn-default').addClass('btn-white');

        $(control).closest('tr').find('td:last-child').html(editAction);
   }
    function editPIC(control){
        $('button').attr('disabled', 'disabled');
        var editAction = ''; 
        var i = $(control).val();
        editAction += '<div class="row">';
        editAction += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">';
        editAction += '<button class="btn btn-info btn-sm" type="submit" onclick="updateBC(this);return false;" value="' + i + '">update</button>'
        editAction += '</div>'
        editAction += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
        editAction += '<button class="btn btn-danger btn-sm" type="submit" onclick="cancelBC(this);return false;" value="' + i + '">cancel</button>'
        editAction += '</div>'
        editAction += '</div>'
        $(control).closest('td').html(editAction);
    }
    function cancelBC(control){
        var i = $(control).val();
        var nama = $(control).closest('tr').find('td:first-child input').attr('data-temp');
        var telp = $(control).closest('tr').find('td:nth-child(2) input').attr('data-temp');
        $(control).closest('tr').find('td:first-child').html(nama);
        $(control).closest('tr').find('td:nth-child(2)').html(telp);
        var temp = '';
        temp += basicBC(i);
        $(control).closest('td').html(temp);
        $('button').removeAttr('disabled');
    }
    function updateBC(control){
        var i = $(control).val();
        var nama = $(control).closest('tr').find('td:first-child input').val();
        var telp = $(control).closest('tr').find('td:nth-child(2) input').val();
        var json = $('#bpjscenter').val();
        json = $.parseJSON(json);
        var id = json[i].id;
        var rumah_sakit_id = $('#rumah_sakit_id').val();
        var data = {
            'id' : id,
            'nama' : nama,
            'telp' : telp,
            'rumah_sakit_id' : rumah_sakit_id
        };
        json[i] = data;
        $('#bpjscenter').val(JSON.stringify(json));
        render('bpjscenter', 'bpjscenters', 'nama');
        var temp = '';
        temp += basicBC(i);
        $(control).closest('td').html(temp);
        $('button').removeAttr('disabled');
    }

    
function basicBC(i){
    var temp = '';
    temp += '<div class="row">';
    temp += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">';
    temp += '<button class="btn btn-warning btn-xs" type="submit" onclick="editBC(this);return false;" value="' + i + '" >edit</button>'
    temp += '</div>'
    temp += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
    temp += '<button class="btn btn-danger btn-xs" type="submit" onclick="delBC(this);return false;" value="' + i + '">delete</button>'
    temp += '</div>'
    temp += '</div>'
    return temp;
}
function basicTJ(i, id){
    var temp = '';
    temp += '<div class="row">';
    temp += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 hide">';
    temp += '<button class="btn btn-warning btn-xs" type="submit" onclick="editTJ(this);return false;" value="' + i + '" tujuan_rujuk_id="' + id + '">edit</button>'
    temp += '</div>'
    temp += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
    temp += '<button class="btn btn-danger btn-xs" type="submit" onclick="delTJ(this);return false;" value="' + i + '">delete</button>'
    temp += '</div>'
    temp += '</div>'
    return temp;
}
function cancelTJ(control){
    var i = $(control).val();
    var id = $(control).attr('data-id');
    var text = $(control).attr('data-text');
    $(control).closest('tr').find('td:first-child').html(text);
    $(control).closest('td').html(basicTJ(i, id))
    $('button').removeAttr('disabled');
}
</script>
	
@stop

