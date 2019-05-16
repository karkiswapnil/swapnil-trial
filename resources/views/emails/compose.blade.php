@extends('layouts.app')

@section('content')
        <h3>Compose New Message</h3>
        {{ Form::open(['action' => 'EmailController@send','method'=>'GET']) }}
              <div class="form-group">
                  {{Form::text('to','',['class'=>'form-control','placeholder'=>'To:'])}}
              </div>
              <div class="form-group">
                      {{Form::text('subject','',['class'=>'form-control','placeholder'=>'Subject:'])}}
              </div>
              
              <div class="form-group">
                      {{Form::textarea('message','',['class'=>'form-control'])}}
              </div>
        
              {{Form::submit('Send',['class'=>'btn btn-primary'])}}
       {{ Form::close() }}
@endsection