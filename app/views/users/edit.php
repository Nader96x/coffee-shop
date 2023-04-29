<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
$errors = $data['errors'];
$data = (object)$data['data'];
var_dump($data);
?>
    <section class="content mt-5">
        <?php flash('user_message'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add User</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo URLROOT . "/users/edit/" . $data->id; ?>" method="post"
                              enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $data->id ?>">
                            <div class="form-floating mb-3">
                                <input type="text"
                                       class="form-control <?php echo (!empty($errors['name'])) ? 'is-invalid' : ''; ?>"
                                       id="nameInput" name="name" placeholder="Name"
                                       value="<?php echo $data->name; ?>">
                                <label for="nameInput">Name</label>
                                <span class="invalid-feedback"><?php echo $errors['name']; ?></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text"
                                       class="form-control <?php echo (!empty($errors['email'])) ? 'is-invalid' : ''; ?>"
                                       id="emailInput" name="email" placeholder="Email"
                                       value="<?php echo $data->email; ?>">
                                <label for="emailInput">Email</label>
                                <span class="invalid-feedback"><?php echo $errors['email']; ?></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text"
                                       class="form-control <?php echo (!empty($errors['password'])) ? 'is-invalid' : ''; ?>"
                                       id="passwordInput" name="password" placeholder="Password" type="password"
                                       value="">
                                <label for="passwordInput">Password</label>
                                <span class="invalid-feedback"><?php echo $errors['password']; ?></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text"
                                       class="form-control <?php echo (!empty($errors['confirm_password'])) ? 'is-invalid' : ''; ?>"
                                       id="confirm_passwordInput" name="confirm_password" placeholder="Password"
                                       type="password"
                                       value="">
                                <label for="confirm_passwordInput">Confirm Password</label>
                                <span class="invalid-feedback"><?php echo $errors['confirm_password']; ?></span>
                            </div>

                            <div class="form-floating mb-3">
                                <img width="150" src="<?= $data->avatar ?>" alt="<?= $data->name ?>">
                                <input type="file"
                                       class="form-control <?php echo (!empty($errors['avatar'])) ? 'is-invalid' : ''; ?>"
                                       id="avatarInput" name="avatar" placeholder="Avatar"
                                       value="">
                                <label for="avatarInput">Image</label>
                                <span class="invalid-feedback"><?php echo $errors['avatar']; ?></span>
                            </div>


                            <input type="submit" value="Add" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require APPROOT . '/views/inc/footer.php'; ?>