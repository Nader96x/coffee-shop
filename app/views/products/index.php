<?php require APPROOT . '/views/inc/header.php';
require_once('../app/models/Category.php');

$category = new Category;
?>
<section class="content">
    <?php flash('product_message'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a class="btn btn-primary btn-sm" href="<?= URLROOT ?>/products/create/">
                    <i class="fas fa-plus">
                    </i>
                    Add Product
                </a>
            </h3>

        </div>
        <div class="card-body p-3">
            <table class="table table-bordered table-light table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">image</th>
                        <th scope="col">Status</th>
                        <th scope="col">Category</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($data as $product) { ?>
                    <tr>
                        <th class="align-middle" scope="row"><?= $i++ ?></th>
                        <td><?= $product->name ?></td>
                        <td><?= $product->price ?>EGP</td>
                        <td><img width="50" src="<?= $product->avatar ?>" alt="<?= $product->name ?>"></td>
                        <td><?= $product->status ? "Available" : 'Comming Soon' ?></td>
                        <?php
                            $cat = $category->find($product->cat_id)
                            ?>
                        <td><?= $cat->name ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?= URLROOT ?>/products/update/<?= $product->id ?>"
                                    class="btn btn-success">Update</a>
                                <form method="post" action="<?= URLROOT ?>/products/delete"
                                    onsubmit="return confirm('Are you sure you want to delete this Product?')">
                                    <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <h4>total products: <?= count($data) ?></h4>
        </div>
    </div>


</section>

<?php require APPROOT . '/views/inc/footer.php'; ?>