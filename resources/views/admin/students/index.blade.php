@extends('admin.layouts.layout')
@section('title','Students')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-0 p-sm-3">
        <div class="container-fluid">
            <x-search searchRoute="{{ route('admin.students.index') }}" addRoute="{{ route('admin.students.create') }}" searchMessage='Search any student here'></x-search>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped align-middle" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Qr Code</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Classification</th>
                            <th scope="col">Training Status</th>
                            <th scope="col">Scholarship Type</th>
                            <th scope="col">Training Result</th>
                            <th scope="col">Admission</th>
                            <th scole="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($students) == 0)
                        <tr>
                            <td colspan="9" class="text-center">No results found</td>
                        </tr>
                        @endif
                        @php
                        $counter = 1;
                        @endphp
                        @foreach($students as $student)
                        <tr>
                            <th scope="row">{{ $counter++ }}</th>
                            <td> {!!
                                QrCode::size(50)->generate($student->qr_code)
                                !!}</td>
                            <td>{{ $student->fullname }}</td>
                            <td>{{ $student->classification }}</td>
                            <td>{{ $student->training_status }}</td>
                            <td>{{ $student->scholarship_type }}</td>
                            <td>
                                @if($student->training_completed)
                                <div class="d-flex align-items-center gap-2">
                                    <span>Completed</span>
                                    <form action="{{ route('admin.students.ongoing', ['id' => $student->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="badge text-bg-danger border-0">Mark as not yet completed</button>
                                    </form>
                               </div>
                                @else
                               <div class="d-flex align-items-center gap-2">
                                    <span>Not Yet Completed</span>
                                    <form action="{{ route('admin.students.completed', ['id' => $student->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="badge text-bg-primary border-0">Mark as completed</button>
                                    </form>
                               </div>
                                @endif
                            </td>
                            <td>
                                @if($student->accepted == 0)
                                <div class="d-flex align-items-center gap-2">
                                    <form action="{{ route('admin.students.accepted', ['id' => $student->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"  class="badge text-bg-success border-0">Accept</button>
                                    </form>
                                    <a href="{{ route('admin.students.destroy', ['id' => $student->id]) }}" class="mt-1 badge text-bg-danger text-decoration-none" data-confirm-delete="true">Reject</a>
                                </div>
                                @elseif($student->accepted == 1)
                                <div class="d-flex align-items-center gap-2">
                                    <form action="{{ route('admin.students.accepted', ['id' => $student->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"  class="badge text-bg-success border-0">Accepted</button>
                                    </form>
                                </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle border-1" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu text-small shadow position-fixed rounded-0">
                                            <li>
                                                <a href="{{ route('admin.students.qrcode', ['id' => $student->id]) }}" class="dropdown-item">
                                                    Download Qr Code
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.students.view-student', ['id' => $student->id]) }}" class="dropdown-item">
                                                    View Info
                                                </a>
                                            </li>
                                            <li>
                                                <a href="" class="dropdown-item">
                                                    Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin.students.destroy',['id' => $student->id]) }}" class="dropdown-item" data-confirm-delete="true">
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <x-pagination :pageData="$students" route="{{ route('admin.students.index') }}"></x-pagination>
            </div>
        </div>
    </div>
</div>
@endsection