<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/app.css">
    <script defer src="/app.js"></script>
    <title>Document</title>
</head>
<body>
    <h1>User login</h1>
    <form action="" method="POST">
        @csrf
        <input type="text" name="user" placeholder="votre pseudo"><br><br>
        <input type="text" name="password" id=""><br><br>
        <button type="submit">Connexion</button>
    </form>
</body>
</html>