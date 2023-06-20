<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
        @page :first{
            margin-top: 50px;
        }

        @page {
            margin-top: 300px;
        }

        body{
            font-family: 'Poppins', sans-serif;
        }

        table{
            width: 100%;
        }
        .title{
            text-align: center;
            margin-bottom: 2rem;
        }

        .header{
            text-align: center;
        }

        table, th, td{
            border-collapse: collapse;
            border: 1px solid black;
        }

        th,td{
            padding: 8px 5px;
        }

        .late{
            color: red;
        }
        
        .date-filter{
            margin-bottom: 0.6rem;
            font-size: 12px;
        }

      .date-from,.date-to,.search{
        font-weight: bold;
      }

      .date-container{
        margin-bottom: 0.3rem;
      }

      .logo-left{
        position: absolute;
        left: 0;
        top: 0;
      }

      .logo-right{
        position: absolute;
        right: 0;
        top: 0;
      }
      
      .printed-date{
        font-size: 10px;
      }

      header{
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
            margin-top: 250px; /* Adjust top margin to avoid overlap with header */
            margin-bottom: 100px; /* Adjust bottom margin to avoid overlap with footer */
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
            <div class="date-container">
                <span><span class="date-from">Date From:</span> {{ $dateFrom }}</span>
                <span><span class="date-to">Date To:</span> {{ $dateTo }}</span>
            </div>
        
            <div class="search-container"><span class="search">Search Keyword: </span>{{ $search }}</div>
        </div>
    </header>
    
    <footer>
        <p class="printed-date">Printed Date: {{ date('Y-m-d h:i A') }}</p>
    </footer>

   <main>
        <table  style="font-size: 12px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Course</th>
                    <th scope="col">Time-in AM</th>
                    <th scope="col">Status AM</th>
                    <th scope="col">Time-out AM</th>
                    <th scope="col">Time-in PM</th>
                    <th scope="col">Status PM</th>
                    <th scope="col">Time-out PM</th>
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
                        <td>{{ $row->time_in_am ? date('h:i A', strtotime($row->time_in_am)) : '' }}</td>
                        <td class="{{ $row->status_am == 'Late' ? 'late' : '' }}">{{$row->status_am}}</td>
                        <td>{{ $row->time_out_am ? date('h:i A', strtotime($row->time_out_am)) : '' }}</td>
                        <td>{{ $row->time_in_pm ? date('h:i A', strtotime($row->time_in_pm)) : '' }}</td>
                        <td class="{{ $row->status_pm == 'Late' ? 'late' : '' }}">{{$row->status_pm}}</td>
                        <td>{{ $row->time_out_pm ? date('h:i A', strtotime($row->time_out_pm)) : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
   </main>
</body>
</html>