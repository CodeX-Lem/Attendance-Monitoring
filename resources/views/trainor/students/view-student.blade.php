@extends('trainor.layouts.layout')
@section('title','Students')
@section('content')
<style>
.profile {
    position: relative;
}

.change-profile {
    position: absolute;
    background: rgba(0, 0, 0, 0.7);
    color: #fff;
    font-weight: bold;
    padding: 5px;
    width: 100%;
    text-align: center;
    opacity: 0;
    transition: all 0.3s ease-out;
}

.profile:hover .change-profile {
    opacity: 1;
}
</style>
<div class="h-100 overflow-y-auto">
    <nav style="--bs-breadcrumb-divider: '/';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><span>Students</span></li>
            <li class="breadcrumb-item active">View Student</li>
        </ol>
    </nav>
    <hr>

    <h2 class="text-center">Student Profile</h2>
    <div class="d-flex align-items-center justify-content-center justify-content-xl-end mb-5 ">
        @if($student->accepted == 0)
        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('trainor.students.accepted', ['id' => $student->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="fs-4 badge text-bg-success border-0">Accept</button>
            </form>
            <a href="{{ route('trainor.students.reject', ['id' => $student->id]) }}"
                class="fs-4  badge text-bg-danger text-decoration-none" data-confirm-delete="true">Reject</a>
        </div>
        @elseif($student->accepted == 1)
        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('trainor.students.accepted', ['id' => $student->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="fs-4 badge text-bg-success border-0">Accepted</button>
            </form>
        </div>
        @endif
    </div>
    <div class="row m-0">
        <div class="col-xl-3">
            <div class="border mb-3 profile" style="width: 200px; height: 200px">
                <label for="image" class="h-100 w-100">
                    <p class="change-profile" style="cursor:pointer;">Change Profile</p>
                    @if($student->image)
                    <img src="data:image/jpeg;base64,{{ $student->image }}" alt="Profile Pic"
                        style="width:100%; height:100%;cursor:pointer; object-fit:cover;">
                    @else
                    <img src="{{ asset('no-image.png') }}" alt="Profile Pic"
                        style="width:100%; height:100%;cursor:pointer; object-fit:cover;">
                    @endif
                </label>
                <form action="{{ route('trainor.students.change-profile', ['id' => $student->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input class="d-none" type="file" name="image" id="image" accept=" .png, .jpeg, .jpg"
                        onchange="this.form.submit()">
                </form>
                @error('image')
                <p class="text-danger text-center">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="col-xl-6 order-3 order-xl-2">
            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Training Program: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->course->course }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">First Name: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->first_name }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Middle Name: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->middle_name }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Last Name: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->last_name }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Sex: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->gender }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Date of Birth: </span> <span
                    class="fw-bold d-block d-md-inline">{{ date('F d, Y', strtotime($student->dob)) }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Civil Status: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->civil_status }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Nationality: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->nationality }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Street: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->street }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Barangay: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->barangay }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">City: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->city }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">District: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->district }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Province: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->province }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Highest Grade Completed: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->highest_grade_completed }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Client Classification: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->classification }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Training Status: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->training_status }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Scholarship Type: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->scholarship_type }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Training Result: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->training_completed ? 'Completed' : 'Not Yet Completed' }}</span>
            </div>

            <div class="mb-3">
                <span class="d-inline-block" style="width: 150px">Admission Status: </span> <span
                    class="fw-bold d-block d-md-inline">{{ $student->accepted ? 'Accepted' : 'Pending' }}</span>
            </div>

            <div class="mb-3 d-flex align-items-center gap-2">
                <a href="{{ old('previous_url', $previousUrl) }}" class="btn btn-primary btn-sm rounded-0 shadow-none">
                    Go Back
                </a>
            </div>
        </div>

        <div class="col-xl-3 order-2 order-xl-3">
            <div class="mb-3 d-flex flex-column align-items-center gap-2" style="width: 200px; height: 200px">
                {!!
                QrCode::size(200)->generate($student->qr_code)
                !!}

                <span class="fs-5 fw-bold">{{ $student->qr_code }}</span>
            </div>

        </div>
    </div>
</div>
@endsection