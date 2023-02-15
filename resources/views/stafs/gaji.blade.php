@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Daftar Gaji {{ $staf->nama }}

@stop
@section('page-title') 
<h2>Daftar Gaji {{ $staf->nama }}</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
		<li>
		<a href="{{ url('stafs/' . $staf->id . '/edit')}}">{{ $staf->nama }}</a>
	  </li>
	  <li class="active">
		  <strong>Daftar Gaji</strong>
	  </li>
</ol>
@stop
@section('content') 
    {!! Form::text('staf_id', $staf->id, [
        'class' => 'form-control hide',
        'id' => 'staf_id'
    ]) !!}
    <div>
                <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#detil" aria-controls="" role="tab" data-toggle="tab">Detil</a></li>
            <li role="presentation"><a href="#bulanan" aria-controls="" role="tab" data-toggle="tab">Bulanan</a></li>
        </ul>
                <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="detil">
                <div class="table-responsive">
                    <?php echo $gajis->appends(Input::except('page'))->links(); ?>
                        <table class="table table-hover table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal Dibayar</th>
                                    <th>Periode</th>
                                    <th>Gaji Pokok</th>
                                    <th>Bonus</th>
                                    <th>Gaji Bruto</th>
                                    <th>Gaji Netto</th>
                                    <th>Pph21</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($gajis->count() > 0)
                                    @foreach($gajis as $gaji)
                                        <tr>
                                            <td>{{ $gaji->tanggal_dibayar->format('d-m-Y') }}</td>
                                            <td>{{ $gaji->mulai->format('M-Y') }}</td>
                                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($gaji->gaji_pokok) }}</td>
                                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($gaji->bonus) }}</td>
                                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($gaji->bonus + $gaji->gaji_pokok) }}</td>
                                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($gaji->pph21s?->pph21) }}</td>
                                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($gaji->bonus + $gaji->gaji_pokok - $gaji->pph21s?->pph21) }}</td>
                                            <td> <a class="btn btn-sm btn-primary" href="{{ url('pdfs/bayar_gaji_karyawan/' . $gaji->id) }}" target="_blank">Print Struk</a> </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="">Tidak Ada Data Untuk Ditampilkan :p</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    <?php echo $gajis->appends(Input::except('page'))->links(); ?>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="bulanan">
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            Menampilkan <span id="rows"></span> hasil
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding-bottom">
                            {!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
                                'class'    => 'form-control',
                                'onchange' => 'clearAndSearch();return false;',
                                'id'       => 'displayed_rows'
                            ]) !!}
                        </div>
                      </div>
                    <table class="table table-hover table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    Tanggal Dibayar
                                    {!! Form::text('tanggal_dibayar', null, [
                                        'class' => 'form-control-inline tgl form-control ajaxsearchrekening',
                                        'onkeyup' => 'clearAndSearch();return false;',
                                        'id'    => 'tanggal_dibayar'
                                    ])!!}
                                </th>
                                
                                <th>
                                    Gaji Pokok
                                    {!! Form::text('gaji_pokok', null, [
                                        'class' => 'form-control-inline form-control',
                                        'onkeyup' => 'clearAndSearch();return false;',
                                        'id'    => 'gaji_pokok'
                                    ])!!}
                                </th>
                                <th>
                                    Bonus
                                    {!! Form::text('bonus', null, [
                                        'class' => 'form-control-inline form-control',
                                        'onkeyup' => 'clearAndSearch();return false;',
                                        'id'    => 'bonus'
                                    ])!!}
                                </th>
                                <th>
                                    Pph21
                                    {!! Form::text('pph21', null, [
                                        'class' => 'form-control-inline form-control',
                                        'onkeyup' => 'clearAndSearch();return false;',
                                        'id'    => 'pph21'
                                    ])!!}
                                </th>
                                <th>
                                    Gaji Netto
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id="container">

                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div id="page-box">
                                <nav class="text-right" aria-label="Page navigation" id="paging">
                                
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer') 
    {!! HTML::script('js/stafs_gaji.js')!!}
    
	
@stop

