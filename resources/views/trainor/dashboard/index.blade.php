@extends('trainor.layouts.layout')
@section('title','Dashboard')
@section('content')

<div class="h-100 overflow-y-auto d-flex flex-column">
    <h2 class="m-3">Dashboard</h2>
    <div class="row mx-0 g-3">
        <div class="col-md-6">
            <div class="card rounded-0 border-0 text-bg-primary card-dashboard h-100">
                <div class="card-body d-block d-md-flex">
                    <div class="me-auto text-center text-md-start">
                        <h3>{{ $totalStudents }}</h3>
                        <h6>Total Students</h6>
                    </div>

                    <div class="d-none d-md-block" style="opacity: 0.5;">
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
                    <div class="me-auto text-center text-md-start">
                        <h3>{{ $totalAttendanceToday }}</h3>
                        <h6>Attendance Today</h6>
                    </div>

                    <div class="d-none d-md-block" style="opacity: 0.5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                            class="bi bi-clock" viewBox="0 0 16 16">
                            <path
                                d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                        </svg>
                    </div>
                </div>
                <div class="card-footer border-0 p-0">
                    <a href="{{ route('trainor.reports.index') }}"
                        class="text-decoration-none d-block text-center py-1 card-dashboard__link">More
                        Info</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 px-5 d-none d-sm-block flex-grow-1">
        <canvas id="attendanceChart" style="width: 100%; height:100%"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Create an array of the counts
const onTimeCountAM = "{{ $onTimeCountAM }}";
const onTimeCountPM = "{{ $onTimeCountPM }}";
const lateCountAM = "{{ $lateCountAM }}";
const lateCountPM = "{{ $lateCountPM }}";
const absentCountAM = "{{ $absentCountAM }}";
const absentCountPM = "{{ $absentCountPM }}";

const attendance = [onTimeCountAM, onTimeCountPM, lateCountAM, lateCountPM, absentCountAM, absentCountPM];

// Get the canvas element
const chartCanvas = document.getElementById('attendanceChart');

const devicePixelRatio = window.devicePixelRatio || 1; // Get the device's pixel ratio

// Create the chart
new Chart(chartCanvas, {
    type: 'bar',
    data: {
        labels: ['On-Time AM', 'On-Time PM', 'Late AM', 'Late PM', 'Absent AM', 'Absent PM'],
        datasets: [{
            maxBarThickness: 120,
            data: attendance,
            backgroundColor: ['#9BD0F5'],
        }]
    },
    options: {
        scales: {
            y: {
                ticks: {
                    precision: 0
                }
            }
        },
        devicePixelRatio: devicePixelRatio, // Set the chart's rendering resolution
        responsive: true,
        plugins: {
            tooltip: {
                enabled: true // Disable tooltips
            },
            legend: {
                display: false, // Show the legend
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