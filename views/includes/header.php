<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.css">
    <title>Bludist</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-info fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= ROOT; ?>"><i class="fas fa-icons"></i> Bludist</a>
            <div id="my-nav" class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <?php
                    if (isset($_SESSION['username'])) :
                    ?>
                        <li class="nav-item dropdown active">
                            <a class="nav-link" href="<?= ROOT; ?>profile"><i class="fas fa-user"></i>
                                <?= $_SESSION['username']; ?></a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?= ROOT; ?>login"><i class="fas fa-user"></i> Login</a>
                        </li>
                    <?php
                        header("Location: " . ROOT . "logout");
                    endif;
                    ?>
                </ul>
            </div>
        </div>
    </nav>