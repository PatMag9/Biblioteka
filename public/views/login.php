<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="public/css/style.css"/>
        <title>BiblioSolis</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="container">
            <div class="logo-container">
                <div class="logo">
                    <img src="public/img/logo.svg">
                    <div class="banner">BiblioSolis</div>
                </div>
            </div>
            <form class="actions" action="login" method="POST">
                <input class="input-button" name="email" type="text" placeholder="e-mail">
                <input class="input-button" name="password" type="password" placeholder="password">
                <button class="action-button" type="submit">Login</button>
            </form>
            <div class="messages">
                <?php
                if(isset($messages)) {
                    foreach($messages as $message) {
                        echo $message;
                    }
                } ?>
            </div>
        </div>
    </body>
</html>