<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
 <div class="container">
     <div class="row p-3">
         <div class="col-md-12">
             <h3 class="text-primary text-center">Laravel CRUD Generator </h3>
             <hr>
              <form action="{{route('generateCrud')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="">Enter the Crud Name</label>
                    <input type="text" name="crudName" id="" class="form-control"  required maxlength="20">
                </div>
                <div class="form-group">
                    <label for="">Enter all Fields Seperate By Comma  <span class="text-danger">[ Note:Please Seperate Fields By Comma]</span></label>
                    <input type="text" name="fields" id="" class="form-control"  required>
                </div>
                <button class="btn btn-outline-success">Generate</button>
              </form>
         </div>
     </div>
     <hr>
     <div class="row py-2">
         <div class="col-md-12">
             <div class="wrapper">
                 <div class="innerText p-3">
                   @php
                       $messages["terminal"] = "Message Output";
                   @endphp
                   @foreach ($messages as $key => $item)
                       <p>{{$item}}</p>
                   @endforeach
                 </div>
             </div>
         </div>
     </div>
 </div>   
    <style>
        .wrapper{
            width: auto;
            height:auto;
            border:2px solid #000;
            background-color: rgb(38, 39, 38);
            color:green;
        }
    </style>
</body>
</html>