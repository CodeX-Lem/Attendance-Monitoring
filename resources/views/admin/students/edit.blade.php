@extends('admin.layouts.layout')
@section('title','Students')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-3">
        <nav style="--bs-breadcrumb-divider: '/';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><span>Students</span></li>
                <li class="breadcrumb-item active">Edit Student</li>
            </ol>
        </nav>
        <hr>
        <form action="" method="POST" enctype="multipart/form-data">
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
                    <label class="form-label">Gender</label>
                    <select class="form-select shadow-none rounded-0" name="gender">
                        <option value="" @if(old('gender')==='' ) selected @endif>--Select Gender--</option>
                        <option value="Male" @if(old('gender')==='Male' ) selected @endif>Male</option>
                        <option value="Female" @if(old('gender')==='Female' ) selected @endif>Female</option>
                    </select>
                    @error('gender')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" class="form-control shadow-none rounded-0" name="dob" autocomplete="off" value="{{ old('dob') }}">
                    @error('dob')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Civil Status</label>
                    <select class="form-select shadow-none rounded-0" name="civil_status">
                        <option value="" @if(old('civil_status')=='' ) selected @endif>--Select Civil Status--</option>
                        <option value="Single" @if(old('civil_status')=='Single' ) selected @endif>Single</option>
                        <option value="Married" @if(old('civil_status')=='Married' ) selected @endif>Married</option>
                        <option value="Widowed" @if(old('civil_status')=='Widowed' ) selected @endif>Widowed</option>
                        <option value="Divorced" @if(old('civil_status')=='Divorced' ) selected @endif>Divorced
                        </option>
                        <option value="Seperated" @if(old('civil_status')=='Seperated' ) selected @endif>Seperated
                        </option>
                    </select>
                    @error('civil_status')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nationality</label>
                    <input type="text" class="form-control shadow-none rounded-0" name="nationality" autocomplete="off" value="{{ old('nationality') }}">
                    @error('nationality')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Street Address</label>
                    <input type="text" class="form-control shadow-none rounded-0" name="street" autocomplete="off" value="{{ old('street') }}">
                    @error('street')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Barangay</label>
                    <input type="text" class="form-control shadow-none rounded-0" name="barangay" autocomplete="off" value="{{ old('barangay') }}">
                    @error('barangay')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">City/Municipality</label>
                    <input type="text" class="form-control shadow-none rounded-0" name="city" autocomplete="off" value="{{ old('city') }}">
                    @error('city')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">District</label>
                    <input type="text" class="form-control shadow-none rounded-0" name="district" autocomplete="off" value="{{ old('district') }}">
                    @error('district')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Province</label>
                    <input type="text" class="form-control shadow-none rounded-0" name="province" autocomplete="off" value="{{ old('province') }}">
                    @error('province')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Highest Grade Completed</label>
                    <input type="text" class="form-control shadow-none rounded-0" name="highest_grade_completed" autocomplete="off" value="{{ old('highest_grade_completed') }}">
                    @error('highest_grade_completed')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Training Program <span class="text-danger">*</span></label>
                    <select class="form-select shadow-none rounded-0" name="course_id">
                        <option value="" @if(old('course_id')=='' ) selected @endif>--Select Course--</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}" @if(old('course_id')==$course->id) selected
                            @endif>{{ $course->course }}</option>
                        @endforeach
                    </select>
                    @error('course_id')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Scholarship Type <span class="text-danger">*</span></label>
                    <select class="form-select shadow-none rounded-0" name="scholarship_type">
                        <option value="" @if(old('scholarship_type')=='' ) selected @endif>--Select Type--</option>
                        <option value="NFTWSP" @if(old('scholarship_type')=='NFTWSP' ) selected @endif>NFTWSP</option>
                        <option value="TWSP" @if(old('scholarship_type')=='TWSP' ) selected @endif>TWSP</option>
                    </select>
                    @error('scholarship_type')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-8 mb-3">
                    <label class="form-label">Profile Image</label>
                    <input class="form-control shadow-none rounded-0" type="file" name="image" accept="image/*">
                    @error('image')
                    <div class="form-text text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <a href="{{ old('previous_url', $previousUrl) }}" class="btn btn-primary btn-sm rounded-0 shadow-none">
                Go Back
            </a>
            <button type="submit" class="btn btn-success btn-sm rounded-0 shadow-none">
                Create Student
            </button>
        </form>
    </div>
</div>
@endsection