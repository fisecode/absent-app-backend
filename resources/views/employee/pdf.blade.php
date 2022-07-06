<!DOCTYPE html>
<html>

<head>
    <title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Membuat Laporan PDF Dengan DOMPDF Laravel</h4>
            <h6><a target="_blank"
                    href="https://www.malasngoding.com/membuat-laporan-…n-dompdf-laravel/">www.malasngoding.com</a>
        </h5>
    </center>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center">

                <img src="{{ asset('/storage/assets/user/' . $employeePhoto) }}" alt="avatar" class="rounded-circle"
                    style="width: 40%; aspect-ratio: 1/1;">

                <h5 class="my-3 mb-0">{{ $employee->name }}</h5>
                <p class="text-muted mb-0">{{ $employeeId }}</p>
                <p class="text-muted mb-0">{{ $employee->division }}</p>
                {{-- <div class="d-flex justify-content-center mb-2">
                <button type="button" class="btn btn-primary">Follow</button>
                <button type="button" class="btn btn-outline-primary ms-1">Message</button>
            </div> --}}
            </div>
        </div>
    </div>

</body>

</html>
