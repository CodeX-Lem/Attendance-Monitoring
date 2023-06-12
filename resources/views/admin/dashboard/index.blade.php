@extends('admin.layouts.layout')
@section('title','Dashboard')
@section('content')
<h2 class="m-3">Dashboard</h2>
<div class="row mx-0 g-3">
    <div class="col-sm-6 col-xl-3">
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
                <a href="{{ route('admin.students.index') }}"
                    class="text-decoration-none d-block text-center py-1 card-dashboard__link">More
                    Info</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card rounded-0 border-0 text-bg-success card-dashboard h-100">
            <div class="card-body d-block d-md-flex">
                <div class="me-auto text-center text-md-start">
                    <h3>{{ $totalTrainors }}</h3>
                    <h6>Total Trainors</h6>
                </div>

                <div class="d-none d-md-block" style="opacity: 0.5;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                        class="bi bi-person-workspace" viewBox="0 0 16 16">
                        <path
                            d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H4Zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                        <path
                            d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2H2Z" />
                    </svg>
                </div>
            </div>
            <div class="card-footer border-0 p-0">
                <a href="{{ route('admin.trainors.index') }}"
                    class="text-decoration-none d-block text-center py-1 card-dashboard__link">More
                    Info</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card rounded-0 border-0 text-bg-danger card-dashboard h-100">
            <div class="card-body d-block d-md-flex">
                <div class="me-auto text-center text-md-start">
                    <h3>{{ $totalCourses }}</h3>
                    <h6>Total Courses</h6>
                </div>

                <div class="d-none d-md-block" style="opacity: 0.5;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor"
                        class="bi bi-mortarboard" viewBox="0 0 16 16">
                        <path
                            d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5ZM8 8.46 1.758 5.965 8 3.052l6.242 2.913L8 8.46Z" />
                        <path
                            d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46l-3.892-1.556Z" />
                    </svg>
                </div>
            </div>
            <div class="card-footer border-0 p-0">
                <a href="{{ route('admin.courses.index') }}"
                    class="text-decoration-none d-block text-center py-1 card-dashboard__link">More
                    Info</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card rounded-0 border-0 bg-warning text-white card-dashboard h-100">
            <div class="card-body d-block d-md-flex">
                <div class="me-auto text-center text-md-start">
                    <h3>{{ $totalAttendanceToday }}</h3>
                    <h6>Attendance Today</h6>
                </div>

                <div class="d-none d-md-block" style="opacity: 0.5;">
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
<div class="container my-5 d-flex justify-content-center" style="height: 400px;">
    <canvas id="attendanceChart" style="width: 100%; height:100%"></canvas>
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