@extends('trainor.layouts.layout')
@section('title','Dashboard')
@section('content')
<h2 class="m-3">Dashboard</h2>
<div class="row mx-0">
    <div class="col-md-6">
        <div class="row mx-0 g-3">
            <div class="col-md-6">
                <div class="card rounded-0 border-0 text-bg-primary card-dashboard h-100">
                    <div class="card-body d-block d-md-flex">
                        <div class="me-auto text-center text-lg-start">
                            <h3>{{ $totalStudents }}</h3>
                            <h6>Total Students</h6>
                        </div>
        
                        <div class="d-none d-lg-block" style="opacity: 0.5;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                                class="bi bi-people-fill" viewBox="0 0 16 16">
                                <path
                                    d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="card-footer border-0 p-0">
                        <a href="{{ route('trainor.students.index') }}"
                            class="text-decoration-none d-block text-center py-1 card-dashboard__link">More
                            Info</a>
                    </div>
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="card rounded-0 border-0 bg-warning text-white card-dashboard h-100">
                    <div class="card-body d-block d-md-flex">
                        <div class="me-auto text-center text-lg-start">
                            <h3>{{ $totalAttendanceToday }}</h3>
                            <h6>Attendance Today</h6>
                        </div>
        
                        <div class="d-none d-lg-block" style="opacity: 0.5;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                                class="bi bi-clock" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="card-footer border-0 p-0">
                        <a href="" class="text-decoration-none d-block text-center py-1 card-dashboard__link">More
                            Info</a>
                    </div>
                </div>
            </div>
        </div>
        
       <div class="col d-flex justify-content-center">
            <div class="mt-5">
                <canvas id="attendanceChart"></canvas>
            </div>
       </div>
    </div>

 <div class="col-md-6 mt-5 mt-lg-0">
    <div class="table-responsive" style="max-height: 500px; overflow-y:scroll;">
        <table class="table table-bordered align-middle table-striped" style="font-size: 14px; border:1px solid #ccc;">
            <thead>
              <tr>
                <th scope="col">Fullname</th>
                <th scope="col">Time-in AM</th>
                <th scope="col">Time-in PM</th>
              </tr>
            </thead>
            <tbody>
               @foreach($attendance as $row)
                <tr>
                    <td>{{ $row->student->fullname }}</td>
                    <td>{{ $row->time_in_am ? date('h:i A', strtotime($row->time_in_am)) : '' }}</td>
                    <td>{{ $row->time_in_pm ? date('h:i A', strtotime($row->time_in_pm)) : '' }}</td>
                </tr>
               @endforeach
            </tbody>
          </table>
    </div>
 </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Create an array of the counts
const lateCount = "{{ $lateCount }}";
const onTimeCount = "{{ $onTimeCount }}";

if (lateCount == 0 && onTimeCount == 0) document.querySelector("#attendanceChart").style.display = 'none';

const attendanceCounts = [lateCount, onTimeCount];

// Get the canvas element
const chartCanvas = document.getElementById('attendanceChart');

const devicePixelRatio = window.devicePixelRatio || 1; // Get the device's pixel ratio

// Create the chart
new Chart(chartCanvas, {
    type: 'pie',
    data: {
        labels: ['Late', 'On Time'],
        datasets: [{
            data: attendanceCounts,
            backgroundColor: ['blue', 'green'],
        }]
    },
    options: {
        devicePixelRatio: devicePixelRatio, // Set the chart's rendering resolution
        responsive: true,
        plugins: {
            tooltip: {
                enabled: true // Disable tooltips
            },
            legend: {
                display: true, // Show the legend
                position: 'top', // Set the position of the legend (options: top, bottom, left, right)
                labels: {
                    font: {
                        size: 16 // Adjust the font size of the legend labels
                    },
                    padding: 10, // Add padding around the legend labels
                }
            },
            datalabels: {
                display: false // Hide the labels on the pie chart
            },
            title: {
                display: true, // Show the title
                text: 'Attendance Today', // Set the title text
                font: {
                    size: 18 // Adjust the font size of the title
                }
            }
        },

    }
});
</script>

@endsection