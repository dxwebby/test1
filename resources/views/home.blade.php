@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Laravel and Vue -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard VUE</div>

                <div class="card-body">                                      
                    
                    <div class="card">
                        <div class="card-header">                            
                            Todo List
                        </div>
                        <div class="card-body">
                            <todo/>
                        </div>
                    </div>                                        
                </div>
            </div>
        </div>
    </div>

    <!-- Laravel and Ajax -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard AJAX</div>

                <div class="card-body">             
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="card">
                        <div class="card-header">                            
                            <div class="row">
                                <div class="col-lg-4 my-auto">
                                    Todo List
                                </div>
                                <div class="col-lg-8 my-auto">
                                    <form method="post" action="/todo">
                                        @csrf                   
                                        <div class="input-group">
                                            <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" 
                                                value="{{ old('title') }}"
                                                placeholder="Enter todo title...">                                
                                            <div class="input-group-append">
                                                <button class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>    
                                        
                                        <div class="form-group mt-2">
                                            @if ($errors->any())
                                                <div class="alert alert-danger my-auto">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul>
                                @foreach ($todos as $item)
                                    <li>
                                        <a href="/todo/{{$item->id}}">{{ ucwords($item->title) }}</a>
                                    </li>                                    
                                @endforeach
                            </ul>
                            
                            @if(Session::has('flash-message'))
                                <div class="alert alert-danger">
                                    {{Session::get('flash-message')}}
                                </div>
                            @endif
                            
                        </div>
                    </div>                                        
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
