@extends('layout.master')

@section('title') 
Klinik Jati Elok | Mereks

@stop
@section('page-title') 

 <h2>List Semua Obat</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Obat</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft"> 
                    <h3>Total : {!! $mereks->count() !!}</h3>
                </div>
                <div class="panelRight">
                  <a href="{{ url('css/style.css') }}"></a>

                  <a href="{{ url('formulas/create') }}" class="btn btn-success"><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Formula Baru</a>
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered DT actionAutoWidth" id="tableAsuransi">
                  <thead>
                    <tr>
                      <th>ID</th>
          						<th>Merek</th>
                      @if (\Auth::user()->role == '6')
                        {{-- <th>Stok</th> --}}
                      @endif
                      <th>Fornas</th>
                      <th>Harga Beli</th>
                      <th>Harga Jual</th>
                      <th>Komposisi</th>
                      <th>Rak</th>
                      <th>Formula</th>
                      {{-- <th>History</th> --}}
                      <th nowrap>Action</th>

                    </tr>
                </thead>
                <tbody>
                	@foreach ($mereks as $merek)
            		<tr>
                       <td>{!! $merek->id !!}</td>
          						 <td>{!! $merek->merek !!}</td>
                       @if (\Auth::user()->role == '6')
                         {{-- <td>{!! $merek->rak->stok !!}</td> --}}
                       @endif
                       <td>{!! $merek->rak->fornasnya !!}</td>
                        <td class='uang'>
                            {!! $merek->rak->harga_beli !!}
                        </td>
                        <td class='uang'>
                            {!! $merek->rak->harga_jual !!}
                        </td>
                       <td>
                          @foreach($merek->rak->formula->komposisi as $komp)

                            {!! $komp->generik->generik !!} {!!$komp->bobot!!} <br> 

                          @endforeach
                      </td>
                        <td nowrap>
                              <a href="raks/{!! $merek->rak->id !!}" class="">{!! $merek->rak->id !!}</a>
                        </td>
                        <td>
                              <a href="formulas/{!! $merek->rak->formula_id !!}" class="">{!! $merek->rak->formula_id !!}</a> 
                        </td> 
                        <td>
                          {!! HTML::link('mereks/' . $merek->id . '/edit', 'edit', ['class' => 'btn btn-warning'])!!}
                        </td>
                	</tr>
                	@endforeach
                </tbody>
            </table>
      </div>
</div>
@stop
@section('footer') 
	
@stop
