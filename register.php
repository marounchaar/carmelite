<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="log.css">
</head>
<body>

<form class="log-form" action="register_insert.php" method="POST" id="registerForm">
  <h1 class="title">REGISTER</h1>
<div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" name="username" required>
</div>

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>

  <div id="errorAlert" class="alert alert-danger" style="display: none;"></div>
  <div id="successAlert" class="alert alert-success" style="display: none;"></div>


  <button type="submit" class="btn btn-primary">Register</button>
  <a class="aa" href="login.php"> already have an account?</a>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $("#registerForm").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        $.ajax({
            type: "POST",
            url: "register_insert.php",
            data: $(this).serialize(),
            dataType: "json", 
            success: function (response) {
                if (response.status === "success") {
                    $("#successAlert").text(response.message).fadeIn();
                    $("#errorAlert").hide();
                    setTimeout(function () {
                        window.location.href = "login.php"; 
                    }, 2000);
                } else {
                    $("#errorAlert").text(response.message).fadeIn();
                    $("#successAlert").hide();
                }
            },
            error: function (xhr, status, error) {
                $("#errorAlert").text("An error occurred. Please try again.").fadeIn();
                $("#successAlert").hide();
                console.error("AJAX Error:", status, error);
            }
        });
    });
});
</script>
</body>
</html>