@extends('trainor.layouts.layout')
@section('title','Students')
@section('content')
<div class="h-100 overflow-y-auto">
    <nav style="--bs-breadcrumb-divider: '/';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><span>Students</span></li>
            <li class="breadcrumb-item active">Edit Student</li>
        </ol>
    </nav>
    <hr>
    <form action="{{ route('trainor.students.update', ['id' => $student->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="previous_url" value="{{ old('previous_url', $previousUrl) }}">
        <div class="row m-0 mb-2 gx-3 gy-2">
            <div class="col-md-4">
                <label class="form-label">First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control shadow-none rounded-0" name="first_name" autocomplete="off" value="{{ old('first_name', $student->first_name) }}">
                @error('first_name')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Middle Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control shadow-none rounded-0" name="middle_name" autocomplete="off" value="{{ old('middle_name', $student->middle_name) }}">
                @error('middle_name')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control shadow-none rounded-0" name="last_name" autocomplete="off" value="{{ old('last_name', $student->last_name) }}">
                @error('last_name')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Gender <span class="text-danger">*</span></label>
                <select class="form-select shadow-none rounded-0" name="gender">
                    <option value="" @if(old('gender', '' )=='' ) selected @endif>--Select Gender--</option>
                    <option value="Male" @if($student->gender =='Male' || old('gender') == 'Male') selected
                        @endif>Male</option>
                    <option value="Female" @if($student->gender =='Female' || old('gender') == 'Female' ) selected
                        @endif>Female</option>
                </select>
                @error('gender')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" class="form-control shadow-none rounded-0" name="dob" autocomplete="off" value="{{ old('dob', $student->dob) }}">
                @error('dob')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Civil Status <span class="text-danger">*</span></label>
                <select class="form-select shadow-none rounded-0" name="civil_status">
                    <option value="" @if(old('civil_status', '' )=='' ) selected @endif>--Select Civil Status--
                    </option>
                    <option value="Single" @if($student->civil_status =='Single') selected @endif>Single</option>
                    <option value="Married" @if($student->civil_status=='Married' ) selected @endif>Married</option>
                    <option value="Widowed" @if($student->civil_status=='Widowed' ) selected @endif>Widowed</option>
                    <option value="Divorced" @if($student->civil_status=='Divorced' ) selected @endif>Divorced
                    </option>
                    <option value="Seperated" @if($student->civil_status=='Seperated' ) selected @endif>Seperated
                    </option>
                </select>
                @error('civil_status')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Nationality <span class="text-danger">*</span></label>
                <input type="text" class="form-control shadow-none rounded-0" name="nationality" autocomplete="off" value="{{ old('nationality', $student->nationality) }}">
                @error('nationality')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-8">
                <label class="form-label">Street Address</label>
                <input type="text" class="form-control shadow-none rounded-0" name="street" autocomplete="off" value="{{ old('street', $student->street) }}">
                @error('street')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Barangay <span class="text-danger">*</span></label>
                <input type="text" class="form-control shadow-none rounded-0" name="barangay" autocomplete="off" value="{{ old('barangay', $student->barangay) }}">
                @error('barangay')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">City/Municipality <span class="text-danger">*</span></label>
                <input type="text" class="form-control shadow-none rounded-0" name="city" autocomplete="off" value="{{ old('city', $student->city) }}">
                @error('city')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">District <span class="text-danger">*</span></label>
                <input type="text" class="form-control shadow-none rounded-0" name="district" autocomplete="off" value="{{ old('district', $student->district) }}">
                @error('district')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Province <span class="text-danger">*</span></label>
                <input type="text" class="form-control shadow-none rounded-0" name="province" autocomplete="off" value="{{ old('province', $student->province) }}">
                @error('province')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Highest Grade Completed</label>
                <input type="text" class="form-control shadow-none rounded-0" name="highest_grade_completed" autocomplete="off" value="{{ old('highest_grade_completed', $student->highest_grade_completed) }}">
                @error('highest_grade_completed')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Scholarship Type <span class="text-danger">*</span></label>
                <select class="form-select shadow-none rounded-0" name="scholarship_type">
                    <option value="NFTWSP" @if($student->scholarship_type =='NFTWSP' ) selected @endif>NFTWSP
                    </option>
                    <option value="TWSP" @if($student->scholarship_type =='TWSP' ) selected @endif>TWSP</option>
                </select>
                @error('scholarship_type')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>


            <div class="col-md-3">
                <label class="form-label">Training Result <span class="text-danger">*</span></label>
                <select class="form-select shadow-none rounded-0" name="training_completed">
                    <option value="0" @if($student->training_completed == 0 ) selected @endif>Not Completed</option>
                    <option value="1" @if($student->training_completed == 1 ) selected @endif>Completed</option>
                </select>
                @error('training_completed')
                <div class="form-text text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-auto">
                <a href="{{ old('previous_url', $previousUrl) }}" class="btn btn-primary btn-sm rounded-0 shadow-none">
                    Go Back
                </a>
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-success btn-sm rounded-0 shadow-none">
                    Update Student
                </button>
            </div>
        </div>
    </form>
</div>
@endsection