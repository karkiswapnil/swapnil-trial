@extends('layouts.app')

@section('content')
        <h1>Add Member</h1>
        {{ Form::open(['action' => 'MembersController@store','method'=>'POST']) }}
              <div class="form-group">
                  {{Form::label('name','Name')}}
                  {{Form::text('name','',['class'=>'form-control','placeholder'=>'Full Name'])}}
              </div>
              <div class="form-group">
                      {{Form::label('dob','Date Of Birth')}}
                      {{Form::date('dob','',['class'=>'form-control'])}}
              </div>
              <div class="form-group">
                      {{Form::label('gender','Gender')}}
                      {{Form::select('gender',Config::get('enums.gender'),'',['class'=>'form-control'])}}
              </div>
              
              <div class="form-group">
                      {{Form::label('phone_number','Phone Number')}}
                      {{Form::number('phone_number','',['class'=>'form-control'])}}
              </div>
              <div class="form-group">
                      {{Form::label('mobile_number','Mobile Number')}}
                      {{Form::number('mobile_number','',['class'=>'form-control'])}}
              
              <div class="form-group">
                      {{Form::label('religion','Religion')}}
                      {{Form::text('religion','',['class'=>'form-control'])}}
              </div>
        
              {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
       {{ Form::close() }}
@endsection