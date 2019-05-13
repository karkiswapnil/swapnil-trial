@extends('layouts.app')

@section('content')
        <h1>Edit Member</h1>
      {{ Form::open(['action' => ['MembersController@update',$member->id],'method'=>'POST']) }}
            <div class="form-group">
                {{Form::label('name','Name')}}
                {{Form::text('name',$member->name,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                    {{Form::label('dob','Date Of Birth')}}
                    {{Form::date('dob',$member->dob,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                    {{Form::label('gender','Gender')}}
                    {{Form::select('gender',Config::get('enums.gender'),$member->gender,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                    {{Form::label('phone_number','Phone Number')}}
                    {{Form::number('phone_number',$member->phone_number,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                    {{Form::label('mobile_number','Mobile Number')}}
                    {{Form::number('mobile_number',$member->mobile_number,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                    {{Form::label('religion','Religion')}}
                    {{Form::text('religion',$member->religion,['class'=>'form-control'])}}
            </div>
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
     {{ Form::close() }}
@endsection