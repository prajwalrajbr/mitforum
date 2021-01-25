<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Starter</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #f1f1f1;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .full-height {
            height: 100vh;
        }
        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
        .position-ref {
            position: relative;
        }
        input {
            padding: 10pt;
            width: 60%;
            font-size: 15pt;
            border-radius: 5pt;
            border: 1px solid lightgray;
            margin: 10pt;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            width: 60%;
            align-items: center;
            margin: 20pt;
            border: 1px solid lightgray;
            padding: 20pt;
            border-radius: 5pt;
            background: white;
        }
        button {
            border-radius: 5pt;
            padding: 10pt 14pt;
            background: white;
            border: 1px solid gray;
            font-size: 14pt;
            margin: 20pt;
        }
        button:hover {
            background: lightgray;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <form class="form-container" action="api/password/reset" method="POST" id="form">
        <h1>MITForum</h1>
        <h2>Forgot Password?</h2>
        @csrf
        <input hidden type="email" name="email" placeholder="Enter email" value="{{request()->get('email')}}">
        <input type="password" id="p1" name="password" placeholder="Enter new password">
        <input type="password" id="p2" name="password_confirmation" placeholder="Confirm new password">
        <input hidden name="token" placeholder="token" value="{{request()->get('token')}}">
        <button type="submit" onclick="validate">Submit</button>
    </form>
</div>
</body>
<script>
var my_func = function(event) {
    var p1 = document.getElementById('p1').value;
    var p2 = document.getElementById('p2').value;
    if(p1===p2){
        if(p1.length<8){     
            alert("Password must be at least 8 characters");
            event.preventDefault();
        }
        else if(p2.length>20){
            alert("Password must be at most 20 characters long");
            event.preventDefault();
        }
    }else{
        alert("Passwords must be same");
        event.preventDefault();
    }
};
var form = document.getElementById("form");

// attach event listener
form.addEventListener("submit", my_func, true);
function validate(){

    if(p1!=p2){
        alert('')
        

    }
}
</script>
</html>