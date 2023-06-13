@extends('admin.layouts.layout')
@section('title','Users')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-3">
        <nav style="--bs-breadcrumb-divider: '/';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><span>Users</span></li>
                <li class="breadcrumb-item active">Create User</li>
            </ol>
        </nav>
        <hr>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <input type="hidden" name="previous_url" value="{{ old('previous_url', $previousUrl) }}">
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control shadow-none rounded-0" name="username" autocomplete="off"
                        value="{{ old('username') }}">
                    @error('username')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control shadow-none rounded-0" name="password"
                        autocomplete="off">
                    @error('password')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control shadow-none rounded-0" name="password_confirmation"
                        autocomplete="off">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Trainor <span class="text-danger">*</span></label>
                    <select class="form-select shadow-none rounded-0" name="trainor_id">
                        <option value="" selected>--Select Trainor--</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->trainor->id }}" @if(old('trainor_id')==$course->trainor->id) selected
                            @endif>{{ $course->trainor->fullname }}</option>
                        @endforeach
                    </select>

                    @error('trainor_id')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <a href="{{ old('previous_url', $previousUrl) }}" class="btn btn-primary btn-sm rounded-0 shadow-none">
                Go Back
            </a>
            <button type="submit" class="btn btn-success btn-sm rounded-0 shadow-none">
                Create User
            </button>
        </form>
    </div>
</div>
@endsection