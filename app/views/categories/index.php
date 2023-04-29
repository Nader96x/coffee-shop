<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container mt-4">
    <a href="categories/create">Add Category</a>
    <table class="table table-dark table-striped text-center">
        <caption>Categories</caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data as $category) { ?>
            <tr>
                <td><?= $category->id ?></td>
                <td><?= $category->name ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="categories/update/<?php echo $category->id ?>" class="btn btn-success">Update</a>
                        <form method="post" action="categories/delete"
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


<?php require APPROOT . '/views/inc/footer.php'; ?>