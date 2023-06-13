@extends('admin.layouts.layout')
@section('title','Users')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-3">
        <nav style="--bs-breadcrumb-divider: '/';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><span>Users</span></li>
                <li class="breadcrumb-item active">Change Admin Credentials</li>
            </ol>
        </nav>
        <hr>
        <form action="{{ route('admin.users.change-profile') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control shadow-none rounded-0" name="username" autocomplete="off" value="{{ config('adminCredentials.username') }}">
                    @error('username')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control shadow-none rounded-0" name="password" autocomplete="off" value="{{ config('adminCredentials.password') }}">
                    @error('password')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control shadow-none rounded-0" name="password_confirmation" autocomplete="off" value="{{ config('adminCredentials.password') }}">
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm rounded-0 shadow-none">
                Go Back
            </a>
            <button type="submit" class="btn btn-success btn-sm rounded-0 shadow-none">
                Update Credentials
            </button>
        </form>
    </div>
</div>
@endsection