<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Create an Account</h2>
                <p>Please fill out this form to register with us</p>
                <form action="<?php echo URLROOT; ?>/users/register" method="post">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" id="nameInput" name="name" placeholder="Name" value="<?php echo $data['name']; ?>">
                        <label for="nameInput">Email</label>
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" id="emailInput" name="email" placeholder="Email" value="<?php echo $data['email']; ?>">
                        <label for="emailInput">Email</label>
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" id="passwordInput" name="password" placeholder="Password" value="<?php echo $data['password']; ?>">
                        <label for="passwordInput">Password</label>
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" id="confirmPasswordInput" name="password" placeholder="Confirm Password" value="<?php echo $data['confirm_password']; ?>">
                        <label for="confirmPasswordInput">Confirm Password</label>
                        <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Register" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>