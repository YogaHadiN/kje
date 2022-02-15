 @extends('layout.master')

 @section('title') 
 {{ env("NAMA_KLINIK") }} | Edit Rak
 @stop
 @section('page-title') 
 <h2>Edit Rak</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('mereks')}}">Merek</a>
      </li>
      <li class="active">
          <strong>Edit Rak</strong>
      </li>
</ol>
 @stop
 @section('content') 
  
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    @foreach ($errors as $error)
        {{ $error }} <br>
    @endforeach

{{ Form::model($rak, [
        'url' => 'raks/' . $rak->id,
        "class" => "m-t", 
        "role"  => "form",
        "method"=> "put"
])}}

@include('raks.form', ['disabled' => 'disabled', 'readonly' => 'readonly', 'stokShow' => true ])
  
            <div class="row">

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
              {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-block'])}}
            </div>
  
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
              {{ HTML::link('raks/' . $rak->id, 'Cancel', ['class' => 'btn btn-warning btn-block']) }}
            </div>
{{ Form::close() }}
            

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
              {{ Form::open(['url' => 'raks/' .$rak->id, 'method' => 'DELETE'])}}
                  {{ Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Anda yakin mau menghapus Rak ini? Semua merek yang memiliki rak ini juga akan ikut terhapus")'])}}
              {{ Form::close()}}
            </div>
              
            </div>
          </div>
        </div>
        </div>
         <div class="col-lg-6 col-md-6">
           <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Formula</h3>
          </div>
          <div class="panel-body">
			  <div class="table-responsive">
				<table class="table table-bordered table-hover" id="tableAsuransi">
						<tbody>
						<tr>
						  <th>dijual_bebas</th>
							<td>
							  @if($formula->dijual_bebas == '1')
								Ya
							  @else
								Tidak
							  @endif
							</td> 
						  </tr>
				  <tr>
					<th>efek_samping</th>
					<td>{{ $formula->efek_samping }}</td> 
				  </tr>
				  <tr>
					<th>sediaan</th>
					<td>{{ $formula->sediaan }}</td> 
				  </tr>
				  <tr>
					<th>indikasi</th>
					<td>{{ $formula->indikasi }}</td> 
				  </tr>
				  <tr>
					<th>kontraindikasi</th>
					<td>{{ $formula->kontraindikasi }}</td> 
				  </tr>
				  <tr>
					<th>Komposisi</th>
					<td>
					  @foreach($formula->komposisi as $komp)
						{{$komp->generik->generik}} {{$komp->bobot}}, 
					  @endforeach

					</td>
				  </tr>
				  <tr>
					<th>Merek</th>
					<td>
					  @foreach ($rak->merek as $merek)
						{{ $merek->merek }}, 
					  @endforeach
					</td> 
				  </tr>
						</tbody>
					</table>
			  </div>
          </div>
      </div>
  </div>
    </div>
  </div>
</div>

  
       
<div id="notif"></div>
<div id="tabelNotif"></div>
 
    @stop
      @section('footer')
      {{ HTML::script('js/rak.js')}} 
      <script>
          $('#dummySubmit').click(function(e) {

            if(
              $('input[name="exp_date"]').val() == '' ||
              $('input[name="harga_beli"]').val() == '' ||
              $('select[name="fornas"]').val() == '' ||
              $('input[name="harga_jual"]').val() == '' ||
              $('input[name="stok"]').val() == '' ||
              $('input[name="stok_minimal"]').val() == '' ||
              $('input[name="merek"]').val() == '' ||
              $('input[name="rak_id"]').val() == ''){


                  if($('input[name="exp_date"]').val() == ''){
                    validasi('input[name="exp_date"]', 'Harus Diisi!');
                  }
                  if($('input[name="harga_beli"]').val() == ''){
                    validasi('input[name="harga_beli"]', 'Harus Diisi!');
                  }
                  if($('select[name="fornas"]').val() == ''){
                    validasi('select[name="fornas"]', 'Harus Diisi!');
                  }
                  if($('input[name="harga_jual"]').val() == ''){
                    validasi('input[name="harga_jual"]', 'Harus Diisi!');
                  }
                  if($('input[name="stok"]').val() == ''){
                    validasi('input[name="stok"]', 'Harus Diisi!');
                  }
                  if($('input[name="stok_minimal"]').val() == ''){
                    validasi('input[name="stok_minimal"]', 'Harus Diisi!');
                  }
                  if($('input[name="merek"]').val() == ''){
                    validasi('input[name="merek"]', 'Harus Diisi!');
                  }
                  if($('input[name="rak_id"]').val() == ''){
                    validasi('input[name="rak_id"]', 'Harus Diisi!');
                   }

            } else {

              $.post("{{ url('raks/ajax/ajaxrak') }}", {'formula_id': $('input[name="formula_id"]').val(), 'merek' : $('input[name="merek"]').val(), 'rak' : $('input[name="rak_id"]').val(), 'endfix' : $('input[name="endfix"]').val(), '_token' : '{{ Session::token() }}'}, function(data) {
                  data = JSON.parse(data);

                  console.log('rak = ' + data.rak);
                  console.log('merek = ' + data.merek);

                  if(data.merek == '1' || data.rak == '1'){


                    if(data.merek == '1'){
                      validasi('input[name="merek"]', 'Merek Sudah ada');
                     }

                     if (data.rak == '1'){
                      validasi('input[name="rak_id"]', 'Rak Sudah ada');
                      }

                  } else {
                    // alert('submit');
                    $('input[type="submit"]').click();
                  }
              });
            }
          });
        function validasi(selector, pesan) {

            $(selector).closest('.form-group')
            .addClass('has-error')
            .append('<code>' + pesan + '</code>')
            .hide()
            .fadeIn(1000);

            if($(selector).prop('tagName').toLowerCase() == 'input' || $(selector).prop('tagName').toLowerCase() == 'textarea'){
                 $(selector).keyup(function(){
                    $(this).closest('.form-group')
                    .removeClass('has-error')
                    .find('code')
                    .fadeOut('1000', function() {
                        $(this).remove();
                    });
                 })   
             } 
              if($(selector).prop('tagName').toLowerCase() == 'select' || $(selector).attr('class') == 'form-control tanggal'){
                 $(selector).change(function(){
                    $(this).closest('.form-group')
                    .removeClass('has-error')
                    .find('code')
                    .fadeOut('1000', function() {
                        $(this).remove();
                    });
                 })   
             }
        }
      </script>
    @stop
