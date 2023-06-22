<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        @page :first {
            margin-top: 50px;
        }

        @page {
            margin-top: 250px;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        table {
            width: 100%;
        }

        .title {
            text-align: center;
        }

        .header {
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
        }

        .date-from,
        .date-to,
        .search {
            font-weight: bold;
        }

        .logo-left {
            position: absolute;
            left: 0;
            top: 0;
        }

        .logo-right {
            position: absolute;
            right: 0;
            top: 0;
        }

        .printed-date {
            font-size: 10px;
        }

        .nowrap {
            white-space: nowrap;
        }

        header {
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
        }

        footer {
            position: fixed;
            left: 0px;
            right: 0px;
            bottom: 0px;
        }

        main {
            margin-top: 200px;
            /* Adjust top margin to avoid overlap with header */
            margin-bottom: 100px;
            /* Adjust bottom margin to avoid overlap with footer */
        }
    </style>
</head>

<body>
    <header>
        <img class="logo-left" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}" width="100" height="100">
        <img class="logo-right" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('prov-logo.png'))) }}" width="100" height="100">


        <h2 class="header">NEGROS OCCIDENTAL<br>
            LANGUAGE AND INFORMATION <br>
            TECHNOLOGY CENTER</h2>
        <H4 class="title">ATTENDANCE REPORT</H4>

        <div class="date-filter">
            <span><span class="date-from">Date From:</span> {{ $dateFrom }}</span>
            <span><span class="date-to">Date To:</span> {{ $dateTo }}</span>
        </div>
    </header>

    <footer>
        <p class="printed-date">Printed Date: {{ date('Y-m-d h:i A') }}</p>
    </footer>

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