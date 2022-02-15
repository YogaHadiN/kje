<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KLINIK JATI ELOK | Edit Data Pendaftaran</title>
    {!! HTML::style('css/bootstrap.min.css')!!}
    {!! HTML::style('font-awesome/css/font-awesome.css')!!}
    {!! HTML::style('css/style.css')!!}
	<style type="text/css" media="all">
.middle {
	margin:auto;
}
	</style>

</head>
<body class="gray-bg">
	
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 middle loginscreen  animated fadeInDown">
        <div>
			<div class="text-center alert alert-success">
				<p>Selamat Datang 
				<h3>{{ $fb->nama_pasien }}</h3>
				</p>
				<p>Mohon diisi dengan lengkap dan benar</p>
				<p>Pengisian data ini hanya dilakukan sekali</p>
			</div>

			{!! Form::open(array('url' => 'facebook/' . $fb->id . '/edit', 'class' => 'm-t', 'method' => 'post')) !!}
				<div class="panel panel-defaulr">
					<div class="panel-body">
						<div class="row hide">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">

								<div class="form-group @if($errors->has('email'))has-error @endif">
								{!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
								  {!! Form::text('email' , $fb->email_pasien, ['class' => 'form-control']) !!}
								  @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row hide">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">

								<div class="form-group @if($errors->has('facebook_id'))has-error @endif">
								{!! Form::label('facebook_id', 'Facebook Id', ['class' => 'control-label']) !!}
								  {!! Form::text('facebook_id' , $fb->facebook_id, ['class' => 'form-control']) !!}
								  @if($errors->has('facebook_id'))<code>{{ $errors->first('facebook_id') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

								<div class="form-group @if($errors->has('nama'))has-error @endif">
								{!! Form::label('nama', 'Nama Sesuai KTP', ['class' => 'control-label']) !!}
								  {!! Form::text('nama' , $fb->nama_pasien, ['class' => 'form-control rq']) !!}
								  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('pernah_berobat'))has-error @endif">
								  {!! Form::label('pernah_berobat', 'Apa Pasien Pernah Berobat disini sebelumnya?', ['class' => 'control-label']) !!}  
								  {!! Form::select('pernah_berobat', $pernah_berobat, $fb->pernah_berobat , ['class' => 'form-control rq']) !!}
								  @if($errors->has('pernah_berobat'))<code>{{ $errors->first('pernah_berobat') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
								<label>Tanggal Lahir</label>
								<div class="row">
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<div class="form-group @if($errors->has('tanggal'))has-error @endif">
											{!! Form::label('tanggal', 'Tanggal', ['class' => 'hide']) !!}
											{!! Form::select('date', $date , $fb->tanggal_lahir_pasien->format('d'), ['class' => 'form-control angka selectpick']) !!}
										</div>
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
										<div class="form-group @if($errors->has('bulan'))has-error @endif">
										  {!! Form::label('bulan', 'Bulan', ['class' => 'hide']) !!}
										  {!! Form::select('month', $month , $fb->tanggal_lahir_pasien->format('m'), ['class' => 'form-control selectpick angka']) !!}
										</div>
									</div>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

										<div class="form-group @if($errors->has('tahun'))has-error @endif">
										  {!! Form::label('tahun', 'Tahun', ['class' => 'hide']) !!}
										  {!! Form::select('year', $year , $fb->tanggal_lahir_pasien->format('Y'), ['class' => 'form-control angka']) !!}
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('no_hp'))has-error @endif">
								{!! Form::label('no_hp', 'Nomor Handphone', ['class' => 'control-label']) !!}
								  {!! Form::text('no_hp' , $fb->no_hp_pasien, ['class' => 'form-control rq']) !!}
								  @if($errors->has('no_hp'))<code>{{ $errors->first('no_hp') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

								<div class="form-group @if($errors->has('alamat'))has-error @endif">
								{!! Form::label('alamat', 'Alamat Lengkap', ['class' => 'control-label']) !!}
								  {!! Form::textarea('alamat' , $fb->alamat_pasien, ['class' => 'form-control textareacustom rq']) !!}
								  @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

								<div class="form-group @if($errors->has('poli'))has-error @endif">
								{!! Form::label('poli', 'Mau ke Dokter Apa ? ', ['class' => 'control-label']) !!}
								  {!! Form::select('poli' , $polis, $fb->pilihan_poli, ['class' => 'form-control rq']) !!}
								  @if($errors->has('poli'))<code>{{ $errors->first('poli') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

								<div class="form-group @if($errors->has('pembayaran'))has-error @endif">
								{!! Form::label('pembayaran', 'Biaya Pribadi atau Asuransi ? ', ['class' => 'control-label']) !!}
								  {!! Form::select('pembayaran' , $pembayarans, $fb->pilihan_pembayaran, ['class' => 'form-control rq']) !!}
								  @if($errors->has('pembayaran'))<code>{{ $errors->first('pembayaran') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<button class="btn btn-primary btn-block btn-lg" type="button" onclick="dummySubmit(); return false;">Update</button>
								{!! Form::submit('submit', ['class' => 'btn btn-success btn-block btn-lg hide', 'id' => 'submit']) !!}
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<a class="btn btn-danger btn-block btn-lg" href="{{ url('facebook/' . $fb->id) }}">Cancel</a>
							</div>
						</div>
					</div>
				</div>
		</div>
            {!! Form::close() !!}
           @if(\Session::has('pesan'))
                <p class="m-t"> <code> {!! \Session::get('pesan') !!}</code> </p>
            @endif
        </div>
    </div>
    <!-- Mainly scripts -->
    {!! HTML::script('js/jquery-2.1.1.js')!!}
    {!! HTML::script('js/bootstrap.min.js')!!}
    {!! HTML::script('js/all.js')!!}
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(){
			if(validatePass()){
				$('#submit').click();
			}
		}
	</script>
</body>

</html>
