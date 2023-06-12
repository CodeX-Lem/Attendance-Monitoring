@extends('admin.layouts.layout')
@section('title','Users')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-3">
        <nav style="--bs-breadcrumb-divider: '/';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><span>Users</span></li>
                <li class="breadcrumb-item active">Change Admin Username</li>
            </ol>
        </nav>
        <hr>
        <form action="{{ route('admin.users.change-username', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="previous_url" value="{{ old('previous_url', $previousUrl) }}">
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control shadow-none rounded-0" name="username" autocomplete="off" value="{{ old('username', $user->username) }}">
                    @error('username')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <a href="{{ old('previous_url', $previousUrl) }}" class="btn btn-primary btn-sm rounded-0 shadow-none">
                Go Back
            </a>
            <button type="submit" class="btn btn-success btn-sm rounded-0 shadow-none">
                Update Username
            </button>
        </form>
    </div>
</div>
@endsection