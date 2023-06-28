@extends('trainor.layouts.layout')
@section('title','Reports')
@section('content')
<div class="p-0 p-sm-4">
    <div class="border bg-white p-0 p-sm-3">
        <div class="container-fluid">
            <form action="" method="GET" class="row gx-2 mt-3 mt-sm-0">
                <div class="col-auto">
                    <select class="form-select form-select-sm rounded-0 shadow-none" name="year"
                        onchange="this.form.submit()">
                        @for($i = 2023; $i <= 2050; $i++) <option value="{{ $i }}" @if($year==$i) selected @endif>
                            {{ $i }}
                            </option>
                            @endfor
                    </select>
                </div>

                <div class="col-auto">
                    <select class="form-select form-select-sm rounded-0 shadow-none" name="month"
                        onchange="this.form.submit()">
                        <option value="1" @if($month==1) selected @endif>January</option>
                        <option value="2" @if($month==2) selected @endif>February</option>
                        <option value="3" @if($month==3) selected @endif>March</option>
                        <option value="4" @if($month==4) selected @endif>April</option>
                        <option value="5" @if($month==5) selected @endif>May</option>
                        <option value="6" @if($month==6) selected @endif>June</option>
                        <option value="7" @if($month==7) selected @endif>July</option>
                        <option value="8" @if($month==8) selected @endif>August</option>
                        <option value="9" @if($month==9) selected @endif>September</option>
                        <option value="10" @if($month==10) selected @endif>October</option>
                        <option value="11" @if($month==11) selected @endif>November</option>
                        <option value="12" @if($month==12) selected @endif>December</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="input-group input-group-sm mt-2 mt-md-0">
                        <input type="text" class="form-control shadow-none rounded-0" placeholder="Search any student"
                            name="search" autocomplete="off" autofocus value="{{ request('search') }}">
                        <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2 rounded-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                            <span>Search</span>
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-bordered table-striped align-middle" style="font-size: 14px;">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Full Name</th>
                            @for($i = 1; $i <= $days; $i++) <th scope="col" class="text-center">{{ $i }}</th>
                                @endfor
                                <th scope="col" class="text-nowrap">Absent AM</th>
                                <th scope="col" class="text-nowrap">Absent PM</th>
                                <th scope="col" class="text-nowrap">Total Days Absent</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($students) == 0)
                        <tr>
                            <td colspan="{{ $days + 2 }}" class="text-center">No results found</td>
                        </tr>
                        @endif

                        @php
                        $counter = 1;
                        @endphp

                        @foreach($students as $student)
                        @php
                        $absentAm = 0;
                        $absentPm = 0;
                        @endphp
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td class="text-nowrap">{{ $student->fullname }}</td>

                            @for($i = 1; $i <= $days; $i++) @php $attendanceFound=false; foreach ($student->attendance
                                as $attendance) {
                                $day = date('d', strtotime($attendance->date));
                                if ($day == $i) {
                                if($attendance->status_am == 'Absent') $absentAm++;
                                if($attendance->status_pm == 'Absent') $absentPm++;
                                $attendanceFound = true;
                                break;
                                }
                                }
                                @endphp

                                @if($attendanceFound)
                                <td class="text-center" style="font-size: 12px;">
                                    <div class="d-flex flex-column">
                                        <span
                                            class="text-nowrap {{ $attendance->status_am == 'On-Time' ? 'text-success' : ($attendance->status_am == 'text-primary' ? 'L' : 'text-danger') }}">{{ $attendance->status_am == 'On-Time' ? 'P' : ($attendance->status_am == 'Late' ? 'L' : 'A') }}
                                            - AM</span>

                                        <span
                                            class="text-nowrap {{ $attendance->status_pm == 'On-Time' ? 'text-success' : ($attendance->status_pm == 'text-primary' ? 'L' : 'text-danger') }}">{{ $attendance->status_pm == 'On-Time' ? 'P' : ($attendance->status_pm == 'Late' ? 'L' : 'A') }}
                                            - PM</span>
                                    </div>
                                </td>
                                @else
                                <td class="text-center">-</td>
                                @endif
                                @endfor

                                <td class="text-center fw-bold">{{ $absentAm }}</td>
                                <td class="text-center fw-bold">{{ $absentPm }}</td>
                                <td class="text-center fw-bold">{{ ($absentAm + $absentPm) / 2 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
const searchInput = document.querySelector("input[name='search']");
searchInput.selectionStart = searchInput.selectionEnd = searchInput.value.length;
</script>
@endsection