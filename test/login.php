<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="api.js"></script>
    <title>Inicio de Sesión único</title>
</head>

<body>
    <div id="login">
        <h1>Inicio de Sesión único</h1>
        <form action="javascript:login(username.value, password.value)" method="post">
            <input type="text" id="username" value="admin" placeholder="Usuario" required>
            <input type="password" id="password" value="admininformatica" placeholder="Contraseña">
            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>
    <script>
        (() => {
            verifyLogin();
        })()
    </script>
</body>

</html>