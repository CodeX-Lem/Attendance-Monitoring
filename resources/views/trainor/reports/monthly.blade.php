@extends('trainor.layouts.layout')
@section('title','Reports')
@section('content')
<div class="table-responsive h-100">
    <form action="{{ route('trainor.reports.monthly') }}" method="GET" class="row gx-0 gy-2 mb-3 sticky-left">
        <div class="col-auto me-2">
            <select class="form-select form-select-sm rounded-0 shadow-none" name="year" onchange="this.form.submit()">
                @for($i = 2023; $i <= 2050; $i++) <option value="{{ $i }}" @if($year==$i) selected @endif>
                    {{ $i }}
                    </option>
                    @endfor
            </select>
        </div>

        <div class="col-auto me-2">
            <select class="form-select form-select-sm rounded-0 shadow-none" name="month" onchange="this.form.submit()">
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
            <div class="input-group input-group-sm">
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


    <table class="table align-middle" style="font-size: 12px">
        <thead class="sticky-top">
            <tr>
                <th scope="col" class="sticky-left">
                    Full Name
                </th>
                @for($i = 1; $i <= $days; $i++) <th scope=" col" colspan="2" class="text-center">
                    <div class="d-flex flex-column">
                        <span>{{ $i }}</span>
                        <span>{{ $weekDays[$i - 1] }}</span>
                    </div>
                    </th>
                    @endfor
                    <th class="align-middle" colspan="6">
                        <h4 class="mt-2 text-center">Summary</h4>
                    </th>
            </tr>

            <tr>
                <td class="sticky-left">
                    <div class="d-flex gap-1">
                        <span class="text-bg-success px-2 py-1">Present</span>
                        <span class="text-bg-primary px-2 py-1">Late</span>
                        <span class="text-bg-danger px-2 py-1">Absent</span>
                    </div>
                </td>
                @for($i = 1; $i <= $days; $i++) <td class="text-center fw-bold">AM</td>
                    <td class="text-center fw-bold">PM</td>
                    @endfor
                    <th scope="col" class="text-nowrap text-danger">Total Absent AM</th>
                    <th scope="col" class="text-nowrap text-danger">Total Absent PM</th>
                    <th scope="col" class="text-nowrap text-danger">Total Days Absent</th>
                    <th scope="col" class="text-nowrap text-primary">Total Late AM</th>
                    <th scope="col" class="text-nowrap text-primary">Total Late PM</th>
                    <th scope="col" class="text-nowrap text-primary">Total Days Late</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            @php
            $absentAm = 0;
            $absentPm = 0;
            $lateAm = 0;
            $latePm = 0;
            @endphp
            <tr class="row-item" onclick="makeActive(this)">
                <td class="text-nowrap sticky-left">{{ $student->fullname }}</td>

                @for($i = 1; $i <= $days; $i++) @php $attendanceFound=false; foreach ($student->
                    attendance
                    as $attendance) {
                    $day = date('d', strtotime($attendance->date));
                    if ($day == $i) {
                    if($attendance->status_am == 'Absent') $absentAm++;
                    if($attendance->status_pm == 'Absent') $absentPm++;
                    if($attendance->status_am == 'Late') $lateAm++;
                    if($attendance->status_pm == 'Late') $latePm++;
                    $attendanceFound = true;
                    break;
                    }
                    }
                    @endphp

                    @if($attendanceFound)
                    <td class="text-center">
                        <span
                            class="px-2 text-nowrap {{ $attendance->status_am == 'On-Time' ? 'bg-success' : ($attendance->status_am == 'Late' ? 'bg-primary' : 'bg-danger') }}"></span>
                    </td>

                    <td class="text-center">
                        <span
                            class="px-2 text-nowrap {{ $attendance->status_pm == 'On-Time' ? 'bg-success' : ($attendance->status_pm == 'Late' ? 'bg-primary' : 'bg-danger') }}"></span>
                    </td>
                    @else
                    <td class="text-center" style="font-size: 14px;">-</td>
                    <td class="text-center" style="font-size: 14px;">-</td>
                    @endif
                    @endfor

                    <td class="text-center">{{ $absentAm }}</td>
                    <td class="text-center">{{ $absentPm }}</td>
                    <td class="text-center fw-bold">{{ ($absentAm + $absentPm) / 2 }}</td>
                    <td class="text-center">{{ $lateAm }}</td>
                    <td class="text-center">{{ $latePm }}</td>
                    <td class="text-center fw-bold">{{ ($lateAm + $latePm) / 2 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
const searchInput = document.querySelector("input[name='search']");
searchInput.selectionStart = searchInput.selectionEnd = searchInput.value.length;
</script>
@endsection