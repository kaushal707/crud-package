<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/gh/BMSVieira/BVAmbient@413fec0/js/bvambient.js"></script>
    <title>Laravel CRUD generator</title>
</head>
<body>
    <div id="ambient" style="overflow:hidden; position:absolute; width:100%; height:100vh;"></div>
    <div class="container">
        <div class="row p-3">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h2 class=" text-center text-primary"><strong>Laravel CRUD Generator</strong></h2>
                <br>
                <br>
                <form action="{{ route('generateCrud') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Enter the Crud Name <span class="text-danger">*</span></label>
                        <input type="text" name="crudName" id="" class="form-control" required maxlength="20">
                    </div>
                    <div class="form-group">
                        <label for="">Enter Fields#Datatyped Seperate By Comma <span class="text-danger">(<i> Example:
                                    name#string, age#Integer, year#date </i>)</span></label>
                        <input type="text" name="fields" id="" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Run Migration ? <span class="text-danger"> * </span></label>
                        <br>
                        <input type="radio" id="html" name="run_migration" value="1" checked>
                        <label for="html">Yes</label>
                        <input type="radio" id="css" name="run_migration" value="0">
                        <label for="css">No</label>
                    </div>
                    <button class="btn btn-primary">Generate</button>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
        
        <div class="row py-2">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="wrapper">
                    <div class="innerText p-3">
                        @php
                            $messages['terminal'] = 'Message Output';
                        @endphp
                        @foreach ($messages as $key => $item)
                            <p>{{ $item }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
    <style>
        .wrapper {
            width: auto;
            height: auto;
            border: 2px solid #000;
            background-color: rgb(38, 39, 38);
            color: green;
        }

        html,
        body {
            width: 100%;
            height: 100vh;
        }

        .bvambient_particle {
            position: absolute;
            pointer-events: none;
            transition: top linear, left linear;
        }

    </style>

    <script>

        document.addEventListener("DOMContentLoaded", function() {
            var demo1 = new BVAmbient({
                selector: "#ambient",
                fps: 60,
                max_transition_speed: 12000,
                min_transition_speed: 8000,
                particle_number: 10,
                particle_maxwidth: 60,
                particle_minwidth: 10,
                particle_radius: 50,
                particle_opacity: true,
                particle_colision_change: true,
                particle_background: "#f112ed ",
                particle_image: {
                    image: false,
                    src: ""
                },
                responsive: [{
                        breakpoint: 768,
                        settings: {
                            particle_number: "15"
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            particle_number: "10"
                        }
                    }
                ]
            });
        });
    </script>
</body>
</html>
