 @extends('layout.master')

 @section('title') 
 {{ env("NAMA_KLINIK") }} | Edit Merek
 @stop
 @section('page-title') 

 <h2>Edit Merek</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('mereks')}}">Merek</a>
      </li>
      <li class="active">
          <strong>Edit Merek</strong>
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
          'url' => 'mereks/' . $merek->id,
          "class" => "m-t", 
          "role"  => "form",
          "method"=> "put"
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
              @if(\Auth::user()->role_id == '6')
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              @else
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
              @endif
                <button type="button" class="btn btn-primary btn-block" id="dummySubmit">Submit</button>
                {!! Form::submit('Submit', ['class' => 'btn btn-primary btn-block displayNone', 'id' => 'submit_update'])!!}
          {!! Form::close() !!}
              </div>
              @if(\Auth::user()->role_id == '6')
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                {!! Form::open(['url' => 'mereks/' . $merek->id, 'method' => 'delete'])!!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm("Anda yakin mau menghapus ' . $merek->id . ' - ' . $merek->merek . '")'])!!}
                {!! Form::close()!!}
              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              @else
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              @endif
                <div class="form-group">
                  {!! HTML::link('mereks', 'Cancel', ['class' => 'btn btn-warning btn-block']) !!}
                </div>
              </div>
              </div>
              </div>
              </div>
        <div class="panel panel-success">
          <div class="panel-heading">
            <h3 class="panel-title">Info Rak</h3>
          </div>
          <div class="panel-body">
			  <div class="table-responsive">
					<table class="table table-bordered table-hover text-left" id="tableAsuransi">
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
					  <th>Rak</th>
					  <td>{!! $rak->id !!}</td>
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
@include('formulas.temp')
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
                      validasi('input[name="merek"]', 'Merek Tidak Berubah, klik Cancel untuk batal atau ganti nama lain');
                  } else {
                    $('input#submit_update').click();
                  }
              });
            }
          });
       
      </script>
    @stop
