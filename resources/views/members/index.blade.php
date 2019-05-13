@extends('layouts.app')

@section('content')
    <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users Table</h3>
  
              <div class="card-tools">
                <button
                  type="button"
                  class="btn btn-success"
                  data-toggle="modal"
                  data-target="#addNew"
                ><a href="/members/create">
                  Add new
                  <i class="fas fa-user-plus"></i></a>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Phone Number</th>
                    <th>Religion</th>
                    <th>Modify</th>
                  </tr>
                  @if(count($members)>0)
                  @foreach($members as $member)
                  <tr>
                      <td>{{$member->id}}</td>
                    <td>{{$member->name}}</td>
                    <td>{{$member->dob}}</td>
                    <td>{{$member->gender}}</td>
                    <td>{{$member->phone_number}}</td>
                    <td>{{$member->religion}}</td>
                    <td>
                            <a href="/members/{{$member->id}}/edit">
                              <i class="fa fa-edit"></i>
                            </a>
                            /
                            {{Form::open(['action'=>['MembersController@destroy',$member->id],'method'=>'POST',])}}
                            {{Form::hidden('_method','DELETE')}}
                            <a href="#" onclick="$(this).closest('form').submit()"> <i class="fa fa-trash"></i></a>
                        {{Form::close()}}
                          </td>
                  </tr>
                  @endforeach
                @else
                  <p>No User Data</p>
                @endif
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
@endsection