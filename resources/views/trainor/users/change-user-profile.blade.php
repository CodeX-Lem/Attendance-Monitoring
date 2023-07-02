@extends('trainor.layouts.layout')
@section('title','Users')
@section('content')
<div class="h-100 overflow-y-auto">
    <nav style="--bs-breadcrumb-divider: '/';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Change User Credentials</li>
        </ol>
    </nav>
    <hr>
    <form action="{{ route('trainor.user.change-profile', ['id' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row m-0 mb-2 gx-3 gy-2">
            <div class="col-12">
                <label class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control shadow-none rounded-0" name="username" autocomplete="off" value="{{ $user->username }}">
                @error('username')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control shadow-none rounded-0" name="password" autocomplete="off" value="">
                @error('password')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control shadow-none rounded-0" name="password_confirmation" autocomplete="off" value="">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-success btn-sm rounded-0 shadow-none">
                    Update Credential
                </button>
            </div>
        </div>
    </form>
</div>
@endsection