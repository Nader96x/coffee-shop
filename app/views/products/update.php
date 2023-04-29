<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
$errors = $data['errors'];
$data = (object)$data['data'];
require_once('../app/models/Category.php');
$categories = new Category;
$cats = $categories->getCategories();
?>

<section class="content mt-5">
    <?php flash('product_message'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body bg-light mt-5">
                <h2>Update Product</h2>
                <form action="<?php echo URLROOT . "/products/update/" . $data->id; ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data->id ?>">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control <?php echo (!empty($errors['name'])) ? 'is-invalid' : ''; ?>" id="nameInput" name="name" placeholder="Name" value="<?php echo $data->name; ?>">
                        <label for="nameInput">Name</label>
                        <span class="invalid-feedback"><?php echo $errors['name']; ?></span>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" step="0.01" class="form-control <?php echo (!empty($errors['price'])) ? 'is-invalid' : ''; ?>" id="priceInput" name="price" placeholder="price" value="<?php echo $data->price; ?>">
                        <label for="priceInput">Price</label>
                        <span class="invalid-feedback"><?php echo $errors['price']; ?></span>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="status" id="status" class="form-control">
                            <option value="0" selected>Not Available</option>
                            <option value="1">Available</option>
                        </select>
                        <label for="statusInput">Status</label>
                        <span class="invalid-feedback"><?php echo $errors['status']; ?></span>
                    </div>
                    <div class="form-floating mb-3">

                        <select name="cat_id" id="cat_id" class="form-control">
                            <option value="" disabled selected>Select Category</option>
                            <?php
                            foreach ($cats as $cat) { ?>
                                <option value="<?= $cat->id ?>"><?= $cat->name ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <label for="cat_idInput">Category</label>
                        <span class="invalid-feedback"><?php echo $errors['cat_id']; ?></span>
                    </div>

                    <div class="form-floating mb-3">
                        <img width="150" src="<?= $data->avatar ?>" alt="<?= $data->name ?>">
                        <input type="file" class="form-control <?php echo (!empty($errors['avatar'])) ? 'is-invalid' : ''; ?>" id="avatarInput" name="avatar" placeholder="Avatar" value="">
                        <label for="avatarInput">Image</label>
                        <span class="invalid-feedback"><?php echo $errors['avatar']; ?></span>
                    </div>

                    <input type="submit" value="Update" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</section>

<?php require APPROOT . '/views/inc/footer.php'; ?>