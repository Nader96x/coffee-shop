<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container mt-4">
    <?php flash('category_message'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a class="btn btn-primary btn-sm" href="<?= URLROOT ?>/categories/create/">
                    <i class="fas fa-plus">
                    </i>
                    Add Category
                </a>
            </h3>

        </div>
        <div class="card-body p-3">
            <table class="table table-bordered table-light table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($data as $category) { ?>
                    <tr>
                        <th class="align-middle" scope="row"><?= $i++ ?></th>
                        <td><?= $category->name ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?= URLROOT ?>/categories/update/<?= $category->id ?>"
                                    class="btn btn-success">Update</a>
                                <form method="post" action="<?= URLROOT ?>/categories/delete"
                                    onsubmit="return confirm('Are you sure you want to delete this Category?')">
                                    <input type="hidden" name="id" value="<?php echo $category->id; ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>