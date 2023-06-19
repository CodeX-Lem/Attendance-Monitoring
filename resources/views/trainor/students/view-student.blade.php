@extends('trainor.layouts.layout')
@section('title','Students')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-3">
        <nav style="--bs-breadcrumb-divider: '/';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><span>Students</span></li>
                <li class="breadcrumb-item active">View Student</li>
            </ol>
        </nav>
        <hr>
   
      <h2 class="text-center mb-5">Student Profile</h2>
      <div class="row">
        <div class="col-xl-3">
            <div class="border mb-3" style="width: 200px; height: 200px">
                <img src="{{ asset('storage/images/' . $student->image) }}" alt="Profile Pic" style="width:100%; height: 100%" class="object-fit-cover">
           </div>
        </div>

        <div class="col-xl-6 order-3 order-xl-2">
            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Training Program: </span> <span class="fw-bold d-block d-md-inline">{{ $student->course->course }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">First Name: </span> <span class="fw-bold d-block d-md-inline">{{ $student->first_name }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Middle Name: </span> <span class="fw-bold d-block d-md-inline">{{ $student->middle_name }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Last Name: </span> <span class="fw-bold d-block d-md-inline">{{ $student->last_name }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Sex: </span> <span class="fw-bold d-block d-md-inline">{{ $student->gender }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Date of Birth: </span> <span class="fw-bold d-block d-md-inline">{{ date('F d, Y', strtotime($student->dob)) }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Civil Status: </span> <span class="fw-bold d-block d-md-inline">{{ $student->civil_status }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Nationality: </span> <span class="fw-bold d-block d-md-inline">{{ $student->nationality }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Street: </span> <span class="fw-bold d-block d-md-inline">{{ $student->street }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Barangay: </span> <span class="fw-bold d-block d-md-inline">{{ $student->barangay }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">City: </span> <span class="fw-bold d-block d-md-inline">{{ $student->city }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">District: </span> <span class="fw-bold d-block d-md-inline">{{ $student->district }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Province: </span> <span class="fw-bold d-block d-md-inline">{{ $student->province }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Highest Grade Completed: </span> <span class="fw-bold d-block d-md-inline">{{ $student->highest_grade_completed }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Client Classification: </span> <span class="fw-bold d-block d-md-inline">{{ $student->classification }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Training Status: </span> <span class="fw-bold d-block d-md-inline">{{ $student->training_status }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Scholarship Type: </span> <span class="fw-bold d-block d-md-inline">{{ $student->scholarship_type }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Training Result: </span> <span class="fw-bold d-block d-md-inline">{{ $student->training_completed ? 'Completed' : 'Not Yet Completed' }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Admission Status: </span> <span class="fw-bold d-block d-md-inline">{{ $student->accepted ? 'Accepted' : 'Pending' }}</span>
            </div>

            <div class="mb-3">
                  <a href="{{ old('previous_url', $previousUrl) }}" class="btn btn-primary btn-sm rounded-0 shadow-none">
                Go Back
            </a>
            </div>
        </div>

        <div class="col-xl-3 order-2 order-xl-3">
           <div class="mb-3" style="width: 200px; height: 200px">
            {!!
            QrCode::size(200)->generate($student->qr_code)
            !!}
           </div>
        </div>
      </div>
    </div>
</div>
@endsection