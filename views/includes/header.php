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
            <a class="navbar-brand"><i class="fas fa-icons"></i> Bludist</a>
            <div id="my-nav" class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?php echo ROOT; ?>"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <?php if (isset($_SESSION['username'])) : ?>
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown" href="<?php echo ROOT; ?>profile"><i class="fas fa-user"></i>
                                <?php echo $_SESSION['username']; ?></a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo ROOT; ?>account"><i class="fas fa-user"></i> Account</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>