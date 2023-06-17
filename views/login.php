<?php include "views/includes/header.php"; ?>

<div class="jumbotron jumbotron-fluid mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 pr-5">
                <h2><i class="fa fa-user-plus" aria-hidden="true"></i> Register
                </h2>
                <form action="<?php echo ROOT; ?>register" method="post">
                    <div class="form-group">
                        <label for="reg-username">Choose a
                            username</label>
                        <input id="reg-username" class="form-control" type="text" name="reg-username" placeholder="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="reg-pwd">Password</label>
                        <input id="reg-pwd" class="form-control" type="password" name="reg-pwd" placeholder="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="reg-pwd-confirm">Password
                            confirm</label>
                        <input id="reg-pwd-confirm" class="form-control" type="password" name="reg-pwd-confirm" placeholder="" autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-warning btn-block btn-lg" name="register"><i class="fa fa-user-plus" aria-hidden="true"></i> Register</button>
                </form>
            </div>
            <div class="col-md-6 pl-5">
                <h2><i class="fa-solid fa-right-to-bracket"></i> Login
                </h2>
                <form action="<?php echo ROOT; ?>account" method="post">
                    <div class="form-group">
                        <label for="login-username">Username</label>
                        <input id="login-username" class="form-control" type="text" name="login-username" placeholder="" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="login-pwd">Password</label>
                        <input id="login-pwd" class="form-control" type="password" name="login-pwd" placeholder="" autocomplete="off">
                    </div>
                    <button type="submit" class="btn btn-info btn-block btn-lg" name="login"><i class="fa-solid fa-right-to-bracket"></i>
                        Login</button>

                </form>
            </div>
        </div>
    </div>
</div>
<?php include "views/includes/footer.php"; ?>