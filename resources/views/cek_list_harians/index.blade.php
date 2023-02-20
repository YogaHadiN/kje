@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Cek List Harian

@stop
@section('page-title') 
<h2>Cek List {{ $frekuensi_id == 1? 'Harian' : 'Bulanan' }}</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Cek List Harian</strong>
            </li>
</ol>

@stop
@section('content') 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="float-right">
                <a href="{{ url( isset( $bulanan ) ? 'cek_list_bulanans/create' :  'cek_list_harians/create') }}" target="_blank" class="btn btn-primary">Buat Baru</a>
            </div>
        </div>
    </div>

    <div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">

            <li role="presentation" class="active">
                <a href="#perTanggal" aria-controls="perTanggal" role="tab" data-toggle="tab">
                    Per Tanggal
                </a>
            </li>
            <li role="presentation">
                <a href="#cek_list_harians" aria-controls="cek_list_harians" role="tab" data-toggle="tab">
                    Cek List {{ $frekuensi_id == 1? 'Harian' : 'Bulanan' }}
                </a>
            </li>
        </ul>

            <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="perTanggal">
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
                                <th nowrap class="kolom_2">
                                    Tanggal
                                    {!! Form::text('tanggal', null, [
                                        'class' => 'form-control-inline tgl form-control',
                                        'onkeyup' => 'clearAndSearch();return false;',
                                        'id'    => 'tanggal'
                                    ])!!}
                                </th>
                            </tr>
                        </thead>
                        <tbody id="container"></tbody>
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
            <div role="tabpanel" class="tab-pane" id="cek_list_harians">
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Ruangan</th>
                                    <th>Cek List</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($cek_lists->count() > 0)
                                    @foreach($cek_lists as $k => $cek)
                                        <tr>
                                            <td>{{ $k + 1 }}</td>
                                            <td>{{ $cek->ruangan->nama }}</td>
                                            <td>{{ $cek->cekList->cek_list }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            Tidak ada data untuk ditampilkan
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
@stop
@section('footer') 
   {!! HTML::script('js/ceklistharianindex.js')!!}
@stop
