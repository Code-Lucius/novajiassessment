<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{url('assets/bootstrap/css/bootstrap.min.css')}}">
    <title>Novaji</title>
</head>
<body>

    <div class="container">

          <div class="col-6">
            <p>encrypt code</p>
            <form action="{{route('encrypt')}}" method="post">
            @csrf
            <input type="text" name="encrypt">
            <button>encrypt</button>
            </form>


            <p>decrypt code</p>
            <form action="{{route('decrypt')}}" method="post">
            @csrf
            <input type="text" name="decrypt">
            <button>decrypt</button>
            </form>
          </div>
    </div> 
</body>
</html>