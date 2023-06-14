@extends('trainor.layouts.layout')
@section('title','Reports')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-0 p-sm-3">
        <div class="container-fluid">

            <div class="row gx-1 gy-2 gy-md-0 mt-3 align-items-center justify-content-end">
                <div class="col-md-10">
                    <form action="" method="GET">
                        <div class="input-group input-group-sm">
                            <input type="hidden" class="form-control shadow-none rounded-0" name="entries"
                                value="{{ request('entries', 5) }}" autocomplete="off">

                           <div class="d-flex gap-2 me-3">
                               <div class="d-flex align-items-center gap-2">
                                    <label class="form-label mt-1">From</label>
                                    <input type="date" class="form-control shadow-none rounded-0" name="date-from">
                               </div>
                               <div class="d-flex align-items-center gap-2">
                                    <label class="form-label mt-1">To</label>
                                    <input type="date" class="form-control shadow-none rounded-0" name="date-to">
                               </div>
                           </div>

                            <input type="text" class="form-control shadow-none rounded-0" placeholder="Search any student"
                                name="search" autocomplete="off" autofocus>
                            <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2 rounded-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                                <span>Search</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped align-middle" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Fullname</th>
                            <th scope="col">Time-in AM</th>
                            <th scope="col">Status AM</th>
                            <th scope="col">Time-out AM</th>
                            <th scope="col">Time-in PM</th>
                            <th scope="col">Status PM</th>
                            <th scope="col">Time-out PM</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @if(count($students) == 0)
                        <tr>
                            <td colspan="9" class="text-center">No results found</td>
                        </tr>
                        @endif
                        @php
                        $counter = 1;
                        @endphp --}}
                    </tbody>
                </table>
                {{-- <x-pagination :pageData="$students" route="{{ route('trainor.students.index') }}"></x-pagination> --}}
            </div>
        </div>
    </div>
</div>
@endsection