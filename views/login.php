<?php
include "views/includes/header.php";

// 1: registered successfully

// -10: username not exists
// -11: username exists
// -12: username invalid
// -20: incorrect password
// -21: password not matched
$status = "";

if (isset($_SESSION["status"])) {
    $status = $_SESSION["status"];
}
?>

<div class="jumbotron jumbotron-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 pr-5">
                <h2><i class="fa fa-user-plus" aria-hidden="true"></i> Register
                </h2>
                <form action="<?= ROOT; ?>register" method="post">
                    <div class="form-group">
                        <label for="reg-username">Choose a
                            username</label>
                        <input id="reg-username" class="form-control" type="text" name="reg-username" placeholder="" autocomplete="off">
                        <?php if ($status === "-11") { ?>
                            <small class="form-text text-danger">Username
                                exists.</small>
                        <?php
                            $_SESSION = array();
                        } else if ($status === "-12") { ?>
                            <small class="form-text text-danger">Username
                                invalid.</small>
                        <?php
                            $_SESSION = array();
                        } ?>
                    </div>
                    <div class="form-group">
                        <label for="reg-pwd">Password</label>
                        <input id="reg-pwd" class="form-control" type="password" name="reg-pwd" placeholder="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="reg-pwd-confirm">Password
                            confirm</label>
                        <input id="reg-pwd-confirm" class="form-control" type="password" name="reg-pwd-confirm" placeholder="" autocomplete="off">
                        <?php if ($status === "-21") { ?>
                            <small class="form-text text-danger">Password
                                not matched.</small>
                        <?php
                            $_SESSION = array();
                        } else if ($status === "-22") { ?>
                            <small class="form-text text-danger">Password
                                invalid.</small>
                        <?php } ?>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block btn-lg" name="register"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</button>
                    <?php if ($status === "1") { ?>
                        <div class="alert alert-success mt-3" role="alert">
                            Registered successfully. Please login.
                        </div>
                    <?php
                        $_SESSION = array();
                    } ?>
                </form>
            </div>
            <div class="col-md-6 pl-5">
                <h2><i class="fa-solid fa-right-to-bracket"></i> Login
                </h2>
                <form action="<?= ROOT; ?>login" method="post">
                    <div class="form-group">
                        <label for="login-username">Username</label>
                        <input id="login-username" class="form-control" type="text" name="login-username" placeholder="" autocomplete="off">
                        <?php if ($status === "-10") { ?>
                            <small class="form-text text-danger">Username not
                                exists.</small>
                        <?php
                            $_SESSION = array();
                        } ?>
                    </div>
                    <div class="form-group">
                        <label for="login-pwd">Password</label>
                        <input id="login-pwd" class="form-control" type="password" name="login-pwd" placeholder="" autocomplete="off">
                        <?php if ($status === "-20") { ?>
                            <small class="form-text text-danger">Incorrect
                                password.</small>
                        <?php
                            $_SESSION = array();
                        } ?>
                    </div>
                    <button type="submit" class="btn btn-info btn-block btn-lg" name="login"><i class="fa-solid fa-right-to-bracket"></i>
                        Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "views/includes/footer.php"; ?>