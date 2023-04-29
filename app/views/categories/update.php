<?php require APPROOT . '/views/inc/header.php';
$errors = $data['errors'];
$data = (object)$data['data'];

?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Update Category</h2>

            <form action="<?php echo URLROOT . "/categories/update/" . $data->id; ?>" method="post">
                <input type="hidden" name="id" value="<?= $data->id ?>">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control <?php echo (!empty($errors['name'])) ? 'is-invalid' : ''; ?>" id="nameInput" name="name" placeholder="Name" value="<?php echo $data->name; ?>">
                    <label for="nameInput">Name</label>
                    <span class="invalid-feedback"><?php echo $errors['name']; ?></span>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>

        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>