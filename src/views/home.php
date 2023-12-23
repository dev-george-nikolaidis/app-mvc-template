<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <h1> <?= htmlentities($message) ?></h1>


    <form action="/register" method="POST">

        <button type="submit">Register</button>
    </form>

    <a href="/about">About</a>
    <a href="/products/product">Products</a>
</body>

</html>