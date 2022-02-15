{!! Form::open(['url' => 'sender', 'method' => 'post']) !!}
	{!! Form::text('content', null, ['class' => 'form-control']) !!}
	{!! Form::submit('Submit', ['class' => 'btn btn-success', 'id' => 'submit']) !!}
{!! Form::close() !!}

