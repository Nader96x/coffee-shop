<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Update Category</h2>

            <form method="post" action="categories/update/<?php echo $category->id ?>">
                <div class="form-group">
                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $category->name; ?>">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $category->name; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>

        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>