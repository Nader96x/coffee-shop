<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
$errors = $data['errors'];
$data = $data['data'];
require_once('../app/models/Category.php');
$categories = new Category;
$cats = $categories->getCategories();
?>
    <section class="content mt-5">
        <?php flash('product_message'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Add Product</h3>
                    </div>
                    <div class="card-body">
                        <form action="<?= URLROOT; ?>/products/create" method="post" enctype="multipart/form-data">

                            <div class="form-floating mb-3">
                                <input type="text"
                                       class="form-control <?= (!empty($errors['name'])) ? 'is-invalid' : ''; ?>"
                                       id="nameInput" name="name" placeholder="Name" value="<?= $data['name']; ?>">
                                <label for="nameInput">Name</label>
                                <span class="invalid-feedback"><?= $errors['name']; ?></span>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" step="0.5"
                                       class="form-control <?= (!empty($errors['price'])) ? 'is-invalid' : ''; ?>"
                                       id="priceInput" name="price" placeholder="price" value="<?= $data['price']; ?>">
                                <label for="priceInput">Price</label>
                                <span class="invalid-feedback"><?= $errors['price']; ?></span>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="status" id="status"
                                        class="form-control <?php echo (!empty($errors['status'])) ? 'is-invalid' : ''; ?>">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="0" <?= $data['status'] == 0 ? 'selected' : '' ?>>Comming Soon
                                    </option>
                                    <option value="1" <?= $data['status'] == 1 ? 'selected' : '' ?>>Available</option>
                                </select>
                                <label for="statusInput">Status</label>
                                <span class="invalid-feedback"><?= $errors['status']; ?></span>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="cat_id" id="cat_id"
                                        class="form-control <?php echo (!empty($errors['cat_id'])) ? 'is-invalid' : ''; ?>">
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    foreach ($cats as $cat) { ?>
                                        <option
                                            value="<?= $cat->id ?>" <?= $data['cat_id'] == $cat->id ? 'selected' : '' ?>>
                                            <?= $cat->name ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <label for="cat_idInput">Category</label>
                                <span class="invalid-feedback"><?= $errors['cat_id']; ?></span>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="file"
                                       class="form-control <?= (!empty($errors['avatar'])) ? 'is-invalid' : ''; ?>"
                                       id="avatarInput" name="avatar" placeholder="Avatar"
                                       value="<?= $data['avatar']; ?>">
                                <label for="avatarInput">Image</label>
                                <span class="invalid-feedback"><?= $errors['avatar']; ?></span>
                            </div>


                            <input type="submit" value="Add" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require APPROOT . '/views/inc/footer.php'; ?>