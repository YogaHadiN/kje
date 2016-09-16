        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group @if($errors->has('username'))has-error @endif">
				  {!! Form::label('username', 'Usernam', ['class' => 'control-label']) !!}
                    {!! Form::text('username', null, array(
                        'class'         => 'form-control',
                        'placeholder'   => 'Username'
                        ))!!}
				  @if($errors->has('username'))<code>{{ $errors->first('username') }}</code>@endif
				</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group @if($errors->has('email'))has-error @endif">
				  {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                    {!! Form::email('email', null, array(
                        'class'         => 'form-control',
                        'placeholder'   => 'email'
                    ))!!}
				  @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
				</div>
            </div>
        </div>
       @if(!$create)
           <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				   <div class="form-group @if($errors->has('aktif'))has-error @endif">
				     {!! Form::label('aktif', 'Aktif', ['class' => 'control-label']) !!}
                       {!! Form::select('aktif',   [  0=>'tidak aktif', 1 => 'aktif'] , null, array(
                       'class'         => 'form-control',
                       ))!!}
				     @if($errors->has('aktif'))<code>{{ $errors->first('aktif') }}</code>@endif
				   </div>
               </div>
           </div>
       @endif
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			  <div class="form-group @if($errors->has('role'))has-error @endif">
			    {!! Form::label('role', 'Role', ['class' => 'control-label']) !!}
                  {!! Form::select('role', App\Classes\Yoga::roleList(), null, array(
                      'class'         => 'form-control'
                  ))!!}
			    @if($errors->has('role'))<code>{{ $errors->first('role') }}</code>@endif
			  </div>
          </div>
      </div>
       
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group @if($errors->has('password'))has-error @endif">
				  {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
                    {!! Form::password('password', array(
                        'class'         => 'form-control',
                        'placeholder'   => 'Password'
                    ))!!}
				  @if($errors->has('password'))<code>{{ $errors->first('password') }}</code>@endif
				</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group @if($errors->has('password-repeat'))has-error @endif">
				  {!! Form::label('password-repeat', 'Ketik Ulang Password', ['class' => 'control-label']) !!}
                    {!! Form::password('password-repeat', array(
                        'class'         => 'form-control',
                        'placeholder'   => 'Password Repeat'
                    ))!!}
				  @if($errors->has('password-repeat'))<code>{{ $errors->first('password-repeat') }}</code>@endif
				</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                {!! Form::submit('Submit', array(
                'class' => 'btn btn-primary block full-width m-b'
                ))!!}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                {!! HTML::link('users', 'Cancel', ['class' => 'btn btn-warning block full-width m-b'])!!}
            </div>
        </div>
