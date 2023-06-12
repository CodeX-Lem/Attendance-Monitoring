@extends('admin.layouts.layout')
@section('title','Trainors')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-3">
        <nav style="--bs-breadcrumb-divider: '/';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><span>Trainors</span></li>
                <li class="breadcrumb-item active">Create Trainor</li>
            </ol>
        </nav>
        <hr>
        <form action="{{ route('admin.trainors.store') }}" method="POST">
            @csrf
            <input type="hidden" name="previous_url" value="{{ old('previous_url', $previousUrl) }}">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control shadow-none rounded-0" name="first_name" autocomplete="off" value="{{ old('first_name') }}">
                    @error('first_name')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Middle Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control shadow-none rounded-0" name="middle_name" autocomplete="off" value="{{ old('middle_name') }}">
                    @error('middle_name')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control shadow-none rounded-0" name="last_name" autocomplete="off" value="{{ old('last_name') }}">
                    @error('last_name')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                    <select class="form-select shadow-none rounded-0" name="gender">
                        <option value="" @if(old('gender')==='' ) selected @endif>--Select Gender--</option>
                        <option value="Male" @if(old('gender')==='Male' ) selected @endif>Male</option>
                        <option value="Female" @if(old('gender')==='Female' ) selected @endif>Female</option>
                    </select>
                    @error('gender')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="text" class="form-control shadow-none rounded-0" name="contact_no" autocomplete="off" value="{{ old('contact_no') }}">
                    @error('contact_no')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control shadow-none rounded-0" name="address" autocomplete="off" value="{{ old('address') }}">
                    @error('address')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <a href="{{ old('previous_url', $previousUrl) }}" class="btn btn-primary btn-sm rounded-0 shadow-none">
                Go Back
            </a>
            <button type="submit" class="btn btn-success btn-sm rounded-0 shadow-none">
                Create Trainor
            </button>
        </form>
    </div>
</div>
@endsection