{!! Form::label('GPA')!!}
<div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div class="input-group">
            <span class="input-group-addon" id="addonG">G</span>
            {!! Form::text('G', $g, ['class' => 'form-control gpa', 'id' => 'G', 'aria-describedby' => 'addonG'])!!}
        </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div class="input-group">
            <span class="input-group-addon" id="addonP">P</span>
            {!! Form::text('P', $p, ['class' => 'form-control gpa gpa2', 'id' => 'P', 'aria-describedby' => 'addonP'])!!}
        </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div class="input-group">
            <span class="input-group-addon" id="addonA">A</span>
            {!! Form::text('A', $a, ['class' => 'form-control gpa gpa2', 'id' => 'A', 'aria-describedby' => 'addonA'])!!}
        </div>
    </div>
</div>
{!! Form::text('GPA', null, ['class' => 'hide form-control'])!!}