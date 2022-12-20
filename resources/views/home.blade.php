@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>{{ session()->get('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        @if (Auth::user()->is_admin == 1)
                            Hello, Admin {{ Auth::user()->name }}! You are successfully logged in!
                        @else
                            Hello, User {{ Auth::user()->name }}! You are successfully logged in!
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
