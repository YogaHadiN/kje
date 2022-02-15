 @extends('layout.master')

 @section('title') 
{{ env("NAMA_KLINIK") }} | Edit Users

 @stop
 @section('page-title') 

 <h2>Edit User</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li>
          <a href="{!! url('users')!!}">User</a>
      </li>
      <li class="active">
          <strong>Edit User</strong>
      </li>
</ol>
 @stop
 @section('content') 

 <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
     <div class="panel panel-success">
         <div class="panel-heading">
             <div class="panel-title">Edit User</div>
         </div>
         <div class="panel-body">
            {!! Form::model($user, array(
                "url"   => "users/" . $user->id,
                "class" => "m-t", 
                "role"  => "form",
                "method"=> "put"
            ))!!}
            @include('users.form', ['create'=> false])
            {!! Form::close() !!}
              @if(\Auth::user()->role == '6')
                  @if (\Auth::id() != $user->id)
                    {{-- expr --}}
                    {!! Form::open(['url' => 'users/' . $user->id, 'method' => 'delete'])!!}
                      {!! Form::submit('Delete', ['class' => 'btn btn-danger block full-width m-b', 'onclick' => 'return confirm("Anda yakin mau menghapus User ' . $user->id . ' - ' . $user->username . '?")'])!!}
                    {!! Form::close()!!}
                  @else 
                      <a href="#" class="btn btn-danger block full-width m-b" disabled>User Aktif tidak bisa dihapus</a>
                  @endif
              @endif
         </div>
     </div>
</div>


 </div>

 @stop
 @section('footer') 


 @stop


       
