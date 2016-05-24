        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    {!! Form::label('username') !!}
                    {!! Form::text('username', null, array(
                        'class'         => 'form-control',
                        'placeholder'   => 'Username'
                        ))!!}
                   @if($errors->first('username'))
                       <code>{!! $errors->first('username')!!}</code>
                   @endif
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    {!! Form::label('email') !!}
                    {!! Form::email('email', null, array(
                        'class'         => 'form-control',
                        'placeholder'   => 'email'
                    ))!!}
                    @if($errors->first('email'))
                        <code>{!! $errors->first('email')!!}</code>
                    @endif
                </div>
            </div>
        </div>
       @if(!$create)
           <div class="row">
               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                   <div class="form-group">
                       {!! Form::label('aktif') !!}
                       {!! Form::select('aktif',   [  0=>'tidak aktif', 1 => 'aktif'] , null, array(
                       'class'         => 'form-control',
                       ))!!}
                       @if($errors->first('aktif'))
                           <code>{!! $errors->first('aktif')!!}</code>
                       @endif
                       
                   </div>
               </div>
           </div>
       @endif
      <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="form-group">
                  {!! Form::label('role') !!}
                  {!! Form::select('role', App\Classes\Yoga::roleList(), null, array(
                      'class'         => 'form-control'
                  ))!!}
                  @if($errors->first('role'))
                      <code>{!! $errors->first('role')!!}</code>
                  @endif
              </div>
          </div>
      </div>
       
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    {!! Form::label('password') !!}
                    {!! Form::password('password', array(
                        'class'         => 'form-control',
                        'placeholder'   => 'Password'
                    ))!!}
                    @if($errors->first('password'))
                        <code>{!! $errors->first('password')!!}</code>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    {!! Form::label('password-repeat') !!}
                    {!! Form::password('password-repeat', array(
                        'class'         => 'form-control',
                        'placeholder'   => 'Password Repeat'
                    ))!!}
                    @if($errors->first('password-repeat'))
                        <code>{!! $errors->first('password-repeat')!!}</code>
                    @endif
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
