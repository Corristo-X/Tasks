<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Car Details</title>
  </head>
  <body>
    <div class="container">
        <h1>Car Details</h1>

        <p>Make: {{ $car->make }}</p>
        <p>Model: {{ $car->model }}</p>
        <p>Year: {{ $car->year }}</p>

        <!-- Add more fields as necessary -->

        <a href="{{ route('cars.index') }}">Back to Cars</a>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
