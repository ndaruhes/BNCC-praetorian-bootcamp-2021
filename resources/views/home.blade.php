@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p class="mb-4">{{ __('You are logged in!') }}</p>
                    @if(Auth::user()->role == 'Admin')
                        <h2>Halo Admin !!</h2>
                    @elseif(Auth::user()->role == 'Member')
                        <h2>Halo Member !!</h2>
                    @endif
                    <a href="{{ route('indexBlog') }}">Manage Blog</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
