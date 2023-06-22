@extends('admin.layouts.layout')
@section('title','Students')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-0 p-sm-3">
        <div class="container-fluid">
            <form action="{{ route('admin.students.index') }}" method="GET"
                class="row align-items-center justify-content-end mt-3 mt-sm-0 g-3">
                <input type="hidden" class="form-control shadow-none rounded-0" name="entries"
                    value="{{ request('entries', 5) }}" autocomplete="off">


                <div class="col-auto">
                    <select class="form-select form-select-sm rounded-0 shadow-none" name="course_id"
                        onchange="this.form.submit()">
                        <option value="" @if($selectedCourse=='' ) selected @endif>All</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}" @if($course->id == $selectedCourse) selected
                            @endif>{{ $course->course }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-auto">
                    <select class="form-select form-select-sm rounded-0 shadow-none" name="training_completed"
                        onchange="this.form.submit()">
                        <option value="0" @if($training_completed==0) selected @endif>Not Yet Completed</option>
                        <option value="1" @if($training_completed==1) selected @endif>Completed</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control shadow-none rounded-0" placeholder="Search any student"
                            name="search" autocomplete="off" autofocus>
                        <button type="submit"
                            class="btn btn-success d-inline-flex align-items-center gap-2 rounded-0 me-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                            <span>Search</span>
                        </button>

                        <a href="{{ route('admin.students.create') }}"
                            class="btn btn-sm btn-primary btn-add rounded-0 d-inline-flex align-items-center gap-1">
                            <svg xmlns=" http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-folder-plus" viewBox="0 0 16 16">
                                <path
                                    d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2Zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672Z" />
                                <path
                                    d="M13.5 9a.5.5 0 0 1 .5.5V11h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V12h-1.5a.5.5 0 0 1 0-1H13V9.5a.5.5 0 0 1 .5-.5Z" />
                            </svg>
                            <span>New</span>
                        </a>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped align-middle" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Qr Code</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Training Program</th>
                            <th scope="col">Municipality/City</th>
                            <th scope="col">Training Status</th>
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
                            <td>{{ $student->course->course }}</td>
                            <td>{{ $student->city }}</td>
                            <td>{{ $student->training_status }}</td>
                            {{-- <td>
                                @if($student->training_completed)
                                <div class="d-flex align-items-center gap-2">
                                    <span>Completed</span>
                                    <form action="{{ route('admin.students.ongoing', ['id' => $student->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="badge text-bg-danger border-0">Mark as not yet
                                completed</button>
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
            </td> --}}
            {{-- <td>
                                @if($student->accepted == 0)
                                <div class="d-flex align-items-center gap-2">
                                    <form action="{{ route('admin.students.accepted', ['id' => $student->id]) }}"
            method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="badge text-bg-success border-0">Accept</button>
            </form>
            <a href="{{ route('admin.students.destroy', ['id' => $student->id]) }}"
                class="mt-1 badge text-bg-danger text-decoration-none" data-confirm-delete="true">Reject</a>
        </div>
        @elseif($student->accepted == 1)
        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.students.accepted', ['id' => $student->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="badge text-bg-success border-0">Accepted</button>
            </form>
        </div>
        @endif
        </td> --}}
        <td>
            <div class="d-flex justify-content-end">
                <div class="dropdown">
                    <button class="dropdown-toggle border-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu text-small shadow position-fixed rounded-0">
                        <li>
                            <a href="{{ route('admin.students.qrcode', ['id' => $student->id]) }}"
                                class="dropdown-item">
                                Download Qr Code
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.students.view-student', ['id' => $student->id]) }}"
                                class="dropdown-item">
                                View Info
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.students.show', ['id' => $student->id]) }}" class="dropdown-item">
                                Edit
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.students.destroy',['id' => $student->id]) }}" class="dropdown-item"
                                data-confirm-delete="true">
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

        <div class="row m-0 gy-2 gy-md-0 justify-content-between">
            <div class="col-auto">
                <div class="d-flex align-items-center gap-2">
                    <span>Show</span>
                    <form action="{{ route('admin.students.index') }}">
                        <select name="entries" class="form-select form-select-sm shadow-none rounded-0"
                            onchange="this.form.submit()">
                            <option value="5" {{ $students->perPage() == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $students->perPage() == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ $students->perPage() == 15 ? 'selected' : '' }}>15</option>
                            <option value="20" {{ $students->perPage() == 20 ? 'selected' : '' }}>20</option>
                        </select>
                        <input type="hidden" class="form-control shadow-none rounded-0" name="search"
                            value="{{ request('search', '') }}">

                        <input type="hidden" class="form-control shadow-none rounded-0" name="training_completed"
                            value="{{ request('training_completed', '0') }}">


                        <input type="hidden" class="form-control shadow-none rounded-0" name="course_id"
                            value="{{ request('course_id', '') }}">
                    </form>
                    <span>Entries</span>
                </div>
            </div>
            <div class="col-auto">
                <ul class="pagination">
                    @php
                    $search = request('search', '');
                    $entries = request('entries', 5);
                    $trainingCompleted = request('training_completed','0');
                    $course_id = request('course_id','');
                    $currentPage = $students->currentPage();
                    $lastPage = $students->lastPage();
                    @endphp
                    @if ($currentPage == 1)
                    <li class="page-item disabled"><span class="page-link rounded-0">Previous</span></li>
                    @else
                    <li class="page-item"><a class="page-link shadow-none rounded-0"
                            href="{{ $students->previousPageUrl() }}&entries={{ $entries }}&search={{ $search }}&training_completed={{ $trainingCompleted }}&course_id={{ $course_id }}"
                            rel="prev">Previous</a></li>
                    @endif

                    <li class="page-item"><span class="page-link rounded-0 text-nowrap active">{{ $currentPage }}
                            of
                            {{ $lastPage }}</span></li>

                    @if ($currentPage == $lastPage)
                    <li class=" page-item disabled"><span class="page-link rounded-0">Next</span></li>
                    @else
                    <li class="page-item"><a class="page-link shadow-none rounded-0"
                            href="{{ $students->nextPageUrl() }}&entries={{ $entries }}&search={{ $search }}&training_completed={{ $trainingCompleted }}&course_id={{ $course_id }}"
                            rel="next">Next</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- <x-pagination :pageData="$students" route="{{ route('admin.students.index') }}"></x-pagination> --}}
    </div>
</div>
</div>
</div>
@endsection