@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row mt-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <label for="title">Current Title:</label> <u class="current_title">{{$todo->title}}</u>
                </div>
                <div class="card-body">
                    <form action="/todo/{{ $todo->id }}" method="post" id="update_title">
                        @csrf
                        {{method_field('PATCH')}}
                        <div class="form-group">                            
                            <label for="title">New Title</label>
                            <input type="hidden" name="id" value="{{$todo->id}}">
                            <input type="text" name="new_title" value="{{ old('title')}}" 
                                    class="form-control col-lg-6 {{$errors->has('new_title') ? 'is-invalid' : ''}}" placeholder="Enter todo title...">                                
                        </div>
                        
                        <!-- NON-AJAX -->
                        @if($errors->any())
                        <div class="form-group">
                            <div class="alert alert-danger">                            
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif  

                        <!-- AJAX -->
                        <div class="alert alert-danger error-container col-lg-6">
                            <div id="ajax-errors"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>                        
                        <button id="delete_title" class="btn btn-danger">Delete</button>
                        <a href="/todo" class="btn btn-secondary">Back</a>                        
                    </form>
                        @if(Session::has('flash-message'))                        
                            <div class="alert alert-success col-lg-6">
                                {{Session::get('flash-message')}}     
                            </div>                 
                        @endif                                                                            
                </div>
            </div>            
        </div>
    </div>
</div>
    
@endsection
