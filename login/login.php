<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../style/login_style2.css">
    <script>
        function register_redirect() {
            window.location.href = "register.html";
        }
        function hiddenpassword(form, password) {
            var p = document.createElement("input");
            form.appendChild(p);
            p.name = "p";
            p.type = "hidden"
            p.value = password.value;
            password.value = "";
            form.submit();
        }
    </script>
</head>
<body>
<?php
/*  se si utilizza un dominio vero, levare il commento ed usare la funzione sottostante.
    if ($_SERVER["HTTPS"] != "on") {
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }
*/
?>

    <h2>Login</h2>
    <form action="process_login.php" method="post" name="login_form"> 

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="p" id="password" required><br>

        <button id="loginButton2">Accedi</button>
    </form>
    <button id="loginButton3">Registrati</button><br>
    <?php
        if(isset($_GET['error'])) { 
            echo "Password or Email does not exit, Retry!";
         } else if(isset($_GET['blocked'])) { 
            echo "Too many attempts, you are blocked!";
         }else if(isset($_GET['notLogged'])) { 
            echo "you are not logged!";
         }
    ?>

    <script>
        document.getElementById("loginButton2").addEventListener("click", function(event) {
            hiddenpassword(this.form, this.form.password);
        });
        document.getElementById("loginButton3").addEventListener("click", function(event) {
            register_redirect();
        });
    </script>

</body>
</html>
