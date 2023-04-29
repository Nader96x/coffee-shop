<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
$errors = $data['errors'];
$data = $data['data'];
?>

<section class="content mt-5">
    <?php flash('category_message'); ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Add New Category</h2>
                <form action="<?php echo URLROOT; ?>/categories/create" method="post">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?php echo (!empty($data['name'])) ? 'is-invalid' : ''; ?>" id="nameInput" name="name" placeholder="Name" value="<?php echo $data['name']; ?>">
                        <label for="nameInput">Name</label>
                        <span class="invalid-feedback"><?php echo $data['name']; ?></span>
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Add Category" class="btn btn-success btn-block">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

<?php require APPROOT . '/views/inc/footer.php'; ?>