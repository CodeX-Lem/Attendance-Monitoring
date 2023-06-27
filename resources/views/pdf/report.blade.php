<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance Report</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        @page {
            margin: 0;
            margin-top: 200px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            padding: 2rem;
        }

        table {
            width: 100%;
        }

        .title {
            text-align: center;
        }

        table,
        th,
        td {
            border-collapse: collapse;
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px 5px;
        }

        .text-danger {
            color: red;
        }

        .text-success {
            color: green;
        }

        .text-primary {
            color: blue;
        }

        .date-filter {
            font-size: 12px;
            position: fixed;
            top: 0;
            left: 30px;
        }

        .date-from,
        .date-to,
        .search {
            font-weight: bold;
        }

        .printed-date {
            position: fixed;
            bottom: 15px;
            left: 30px;
            font-size: 10px;
        }

        .nowrap {
            white-space: nowrap;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            height: 300px;
            width: 100%;
            margin-top: -200px;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            height: 200px;
            width: 100%;
            z-index: -1;
        }

        .header-logo {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }

        .footer-logo {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        main {
            z-index: 9998;
        }
    </style>

    <link rel="shortcut icon" href="{{ asset('icon.ico') }}" type="image/x-icon">
</head>

<body>
    <header>
        <img class="header-logo" src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('report-header.jpg'))) }}" alt="Nolitc Header">
        <div class="date-filter">
            <span><span class="date-from">Date From:</span> {{ $dateFrom }}</span>
            <span><span class="date-to">Date To:</span> {{ $dateTo }}</span>
        </div>
    </header>
    <footer>
        <img class="footer-logo" src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('report-footer.jpg'))) }}" alt="Nolitc Footer">
    </footer>

    <p class="printed-date">Printed Date: {{ date('Y-m-d h:i A') }}</p>


    <main>
        <table style="font-size: 12px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Course</th>
                    <th scope="col">Time-in AM</th>
                    <th scope="col">Time-out AM</th>
                    <th scope="col">Time-in PM</th>
                    <th scope="col">Time-out PM</th>
                    <th scope="col">Status AM</th>
                    <th scope="col">Status PM</th>
                </tr>
            </thead>
            <tbody>
                @php
                $counter = 1;
                @endphp

                @foreach($attendance as $row)
                <tr>
                    <td>{{$counter++}}</td>
                    <td>{{ date('F d, Y', strtotime($row->date)); }}</td>
                    <td>{{$row->student->fullname}}</td>
                    <td>{{ $row->student->course->course }}</td>
                    <td class="nowrap">{{ $row->time_in_am ? date('h:i A', strtotime($row->time_in_am)) : '' }}</td>
                    <td class="nowrap">{{ $row->time_out_am ? date('h:i A', strtotime($row->time_out_am)) : '' }}</td>
                    <td class="nowrap">{{ $row->time_in_pm ? date('h:i A', strtotime($row->time_in_pm)) : '' }}</td>
                    <td class="nowrap">{{ $row->time_out_pm ? date('h:i A', strtotime($row->time_out_pm)) : '' }}</td>
                    <td class="fw-bold {{ strtolower($row->status_am) == 'absent' ? 'text-danger' : (strtolower($row->status_am) == 'on-time' ? 'text-success' : 'text-primary')  }}">
                        {{$row->status_am}}
                    </td>
                    <td class="fw-bold {{ strtolower($row->status_pm) == 'absent' ? 'text-danger' : (strtolower($row->status_pm) == 'on-time' ? 'text-success' : 'text-primary')  }}">
                        {{$row->status_pm}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>