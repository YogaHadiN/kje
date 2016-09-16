@extends('layout.master')

@section('title') 
Klinik Jati Elok | No Sales
@stop
@section('page-title') 
 <h2>No Sales</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>No Sales Form</strong>
      </li>
</ol>
@stop
@section('content') 
@if (Session::has('print'))
    <div id="print">
    </div>
@endif
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Form No Sales</div>
            </div>
            <div class="panel-body">
                {!! Form::open(['url'=>'no_sales', 'method'=> 'post']) !!} 
                
                
                <div class="form-group @if($errors->has('staf_id'))has-error @endif">
                  {!! Form::label('staf_id', 'Petugas', ['class' => 'control-label']) !!}
                  {!! Form::select('staf_id', App\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search' => 'true', 'id' => 'staf_id']) !!}
                  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
                </div>
				
				<div class="form-group @if($errors->has('tujuan'))has-error @endif">
				  {!! Form::label('tujuan', 'Tujuan No Sales', ['class' => 'control-label']) !!}
                  {!! Form::textarea('tujuan' , null, ['class' => 'form-control textareacustom']) !!}
				  @if($errors->has('tujuan'))<code>{{ $errors->first('tujuan') }}</code>@endif
				</div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <button type="button" class="btn btn-block btn-success" onclick="dummySubmit(); return false;">Submit</button>
                            {!! Form::submit('Submit', ['class' => 'hide', 'id' => 'submit']) !!}
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            {!! HTML::link('laporans','Cancel', ['class' => 'btn btn-danger btn-block']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Daftar No Sales</div>
            </div>
            <div class="panel-body">
                <div class-"table-responsive">
                    <?php echo $no_sales->appends(Input::except('page'))->links(); ?>
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Petugas</th>
                                <th>Tujuan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($no_sales->count() > 0)
                                @foreach($no_sales as $ns)
                                <tr>
                                    <td>{{$ns->created_at->format('d-m-Y')}}</td>
                                    <td>{{$ns->created_at->format('H:i:s')}}</td>
                                    <td>{{$ns->staf->nama}}</td>
                                    <td>{{$ns->tujuan}}</td>
                                    <td> <a class="btn btn-info btn-xs" href="{{ url('pdfs/ns/' . $ns->id) }}" target="_blank">Print Struk</a> </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data untuk ditampilkan :p</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <?php echo $no_sales->appends(Input::except('page'))->links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('footer') 
    <script type="text/javascript" charset="utf-8">
        $(function () {
              if( $('#print').length > 0 ){
                window.open("{{ url('pdfs/ns/' . Session::get('print')) }}", '_blank');
              }
        });
        function dummySubmit(){
            if(validatePass() && $('#staf_id').val() != ''){
                 $('#submit').click();
            }
        }
    </script>
@stop
