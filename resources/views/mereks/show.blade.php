 @extends('layout.master')

 @section('title') 
 {{ env("NAMA_KLINIK") }} | Create Rak
 @stop
 @section('page-title') 

 <h2>Create Rak</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('mereks')}}">Merek</a>
      </li>
      <li class="active">
          <strong>Create Rak</strong>
      </li>
</ol>
 @stop
 @section('content') 
<input type="hidden" name="_token" id="token" value="{{ Session::token() }}">

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @foreach ($errors as $error)
        {!! $error !!} <br>
    @endforeach
{!! Form::open([
        'url' => 'mereks',
        "class" => "m-t", 
        "role"  => "form",
        "method"=> "post"
])!!}
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-info">
          <div class="panel-heading">
                <h3 class="panel-title">Input Merek</h3>
          </div>
          <div class="panel-body">
           <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group @if($errors->has('merek'))has-error @endif">
				  {!! Form::label('merek', 'Edit Merek', ['class' => 'control-label']) !!}
                  {!! Form::text('merek', $merek->merek, ['class' => 'form-control'])!!}
				  @if($errors->has('merek'))<code>{{ $errors->first('merek') }}</code>@endif
				</div>
              </div>
		  </div>
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <button type="button" class="btn btn-primary btn-block" id="dummySubmit">Submit</button>
              {!! Form::submit('Submit', ['class' => 'btn btn-primary btn-block displayNone'])!!}
            </div>
  
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              {!! HTML::link('formulas/' . $formula->id, 'Cancel', ['class' => 'btn btn-warning btn-block']) !!}
            </div>
        {!! Form::close() !!}
            </div>
            </div>
            </div>

		<div class="panel panel-success">
			  <div class="panel-heading">
					<h3 class="panel-title">Panel title</h3>
			  </div>
			  <div class="panel-body">
				  <div class="table-responsive">
						<table class="table table-bordered table-hover" id="tableAsuransi">
							<tbody>
								<tr>
									<th>Alternatif Fornas</th>
									<td> {!! $rak->alternatif_fornas !!} </td>
								</tr> 
								<tr>
									<th>Expiry Date</th>
									<td> {!! App\Models\Classes\Yoga::updateDatePrep($rak->exp_date) !!} </td>
								</tr> 
								<tr>
									<th>Fornas</th>
									<td> 
										@if ($rak->fornas == '1')
											Ya
										@else
											Tidak
										@endif
									</td>
								</tr> 
								<tr>
									<th>Harga Beli</th>
									<td>Rp. {!! $rak->harga_beli !!},- </td>
								</tr> 
								<tr>
									<th>Harga Jual</th>
									<td>Rp.  {!! $rak->harga_jual !!},- </td>
								</tr> 
								<tr>
									<th>ID FORMULA</th>
									<td> {!! $rak->formula_id !!} </td>
								</tr> 
								<tr>
									<th>Stok</th>
									<td> {!! $rak->stok !!} </td>
								</tr> 
								<tr>
									<th>Stok Minimal</th>
									<td> {!! $rak->stok_minimal !!} </td>
								</tr>  
								<tr>
									<th>Merek</th>
									<td> 

										@foreach ($rak->merek as $mrk)
											{!! $mrk->merek !!}, 
										 @endforeach 

									</td>
								</tr> 
							</tbody>
						</table>
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
					<th>Efek Samping</th>
					<td>{!! $formula->efek_samping !!}</td> 
				  </tr>
				  <tr>
					<th>Golongan Obat</th>
					<td>{!! $formula->golongan_obat !!}</td> 
				  </tr>
				  <tr>
					<th>Sediaan</th>
                    <td>{!! $formula->sediaan->sediaan !!}</td> 
				  </tr>
				  <tr>
					<th>Indikasi</th>
					<td>{!! $formula->indikasi !!}</td> 
				  </tr>
				  <tr>
					<th>Kontraindikasi</th>
					<td>{!! $formula->kontraindikasi !!}</td> 
				  </tr>
				  <tr>
					<th>Komposisi</th>
					<td>
					  @foreach($formula->komposisi as $komp)
						{!!$komp->generik->generik!!} {!!$komp->bobot!!}, 
					  @endforeach
				  
					</td>
				  </tr>
				  <tr>
					<th>Merek</th>
					<td>
					  @foreach ($formula->rak as $rak)
						  @foreach ($rak->merek as $merek)
							{!! $merek->merek !!}, 
						  @endforeach
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
    @stop
    @section('footer')
      {!! HTML::script('js/rak.js')!!} 
      <script>
          $('#dummySubmit').click(function(e) {

            if($('input[name="merek"]').val() == ''){
                validasi('input[name="merek"]', 'Harus Disi');
            } else {

              $.post("{{ url('mereks/ajax/ajaxmerek') }}", {'merek' : $('input[name="merek"]').val(), 'endfix' : $('input[name="endfix"]').val()}, function(data) {
                  data = $.trim(data);

                  if(data == '1'){

                    if(data.merek == '1'){
                      validasi('input[name="merek"]', 'Merek Sudah ada');
                     }

                     if (data.rak == '1'){
                      validasi('input[name="rak_id"]', 'Rak Sudah ada');
                      }

                  } else {
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

           $(selector).on('keyup change', function(){
              $(this).closest('.form-group')
              .removeClass('has-error')
              .find('code')
              .fadeOut('1000', function() {
                  $(this).remove();
              });
           })   
             
        }
      </script>
    @stop
