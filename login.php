<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="log.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<form class="log-form" action="loginget.php" method="POST" id="loginForm">
  <h1 class="title">LOGIN</h1>
  <div id="errorAlert" class="error-message"></div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
  

  <button type="submit" class="btn btn-primary">Login</button>
  <a class="aa" href="register.php"> register</a>
</form>

<script>
$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault(); 

        $.ajax({
            type: "POST",
            url: "loginget.php",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    window.location.href = "display.php"; 
                } else {
                    $("#errorAlert").text(response.message).fadeIn();
                }
            },
            error: function () {
                $("#errorAlert").text("An error occurred. Please try again.").fadeIn();
            } 
        });
    });
});
</script>
</body>
</html>