<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="logo-1.svg" type="image/icon type" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Attendance Tracker - NOLITC</title>

    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}" />

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
</head>

<body style="background-image: url('{{ asset('background.jpg') }}'); ">
    <div class="container box-container d-flex flex-column h-100 justify-content-center">
        <div class="box align-items-center justify-content-center d-flex gap-5">
            <div class="container-fluid">
                <div class="row gap-5 p-5">
                    <div class="col-4 ms-5 d-flex flex-column align-items-center fw-bold">
                        <br />
                        <p class="ms-3 mb-3 mt-5" id="current-date"></p>
                        @if(isset($status))
                        <p class="border bg-success py-2 px-3">{{ $status }}</p>
                        @endif
                    </div>

                    <div class="col-6 border p-3 ms-5">
                        <div class="profile-section">
                            @if(isset($student))
                            <img src="{{ asset('storage/images/' . $student->image) }}" alt="Profile Picture"
                                class="profile-picture text-light mb-5" />
                            @else
                            <img src="{{asset('user.png')}}" alt="Profile Picture"
                                class="profile-picture text-light mb-5" />
                            @endif
                            <div class="container">
                                <form action="{{ route('attendance.scan') }}" method="POST">
                                    @csrf
                                    <p class="text-start f-3 mb-5">
                                        <span class="fw-bold">
                                            @if(isset($message))
                                            {{ $message }}
                                            @endif
                                            @if(isset($student))
                                            {{ $student->fullname }}
                                            @endif
                                        </span>
                                    </p>
                                    <input type="text" class="form-control p-1 fs-5 shadow-none rounded-0"
                                        name="qr_code" placeholder="Scan your QR Code here" autofocus
                                        autocomplete="off" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    // JavaScript code to display and continuously update current date and time
    const currentDateElement = document.getElementById("current-date");

    function updateClock() {
        const currentDate = new Date();

        const dateOptions = {
            year: "numeric",
            month: "long",
            day: "numeric"
        };
        const timeOptions = {
            hour: "numeric",
            minute: "numeric",
            second: "numeric",
            hour12: true,
        };
        const currentDateString = currentDate.toLocaleDateString(
            undefined,
            dateOptions
        );
        const currentTimeString = currentDate.toLocaleTimeString(
            undefined,
            timeOptions
        );
        const currentMilliseconds = currentDate.getMilliseconds();
        const amOrPm = currentDate.getHours() >= 12 ? "PM" : "AM";

        currentDateElement.innerHTML = `${currentDateString}<br>${currentTimeString}`;
    }

    // Initial update of the clock
    updateClock();

    // Update the clock every second
    setInterval(updateClock, 1000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>