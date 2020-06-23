<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Swift Notes</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link href="/public/style.css" rel="stylesheet">
</head>

<body class="body">
<div class="wrapper">
    <div class="header">
        <h1><i class="far fa-clipboard"></i><a href="/">Swift Notes</a></h1>
    </div>

    <div class="container">
        <div class="menu">
            <ul>
                <li><a href="/">Main Page</a></li>
                <li><a href="/?action=newnote">New note</a></li>
            </ul>
        </div>

        <div class="page">
            <?php require_once('templates/pages/' . $page . '.php'); ?>
        </div>
    </div>

    <div class="footer">
        <p>Notes app - PHP Project by Faljen</p>
    </div>
</div>
</body>

</html>