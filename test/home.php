<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="api.js"></script>
    <title>Página Inicial</title>
</head>

<body>
    <div id="menu">
        <button type="button" onclick="logout()">Logout</button>
    </div>
    <h5>Bienvenido</h5>
    <script>
        (() => {
            verifyLogin();
        })()
    </script>
</body>

</html>