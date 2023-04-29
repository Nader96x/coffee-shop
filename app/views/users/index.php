<?php require APPROOT . '/views/inc/header.php'; ?>
<?php var_dump($data); ?>
<section class="content">
    <?php flash('user_message'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a class="btn btn-primary btn-sm" href="<?= URLROOT ?>/users/create/">
                    <i class="fas fa-plus">
                    </i>
                    Add User
                </a>
            </h3>

        </div>
        <div class="card-body p-3">
            <table class="table table-bordered table-light table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Room</th>
                        <th scope="col">image</th>
                        <th scope="col">Ext.</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($data as $user) { ?>
                        <tr>
                            <th class="align-middle" scope="row"><?= $i++ ?></th>
                            <td><?= $user->name ?></td>
                            <td>room</td>
                            <td><img width="50" src="<?= $user->avatar ?>" alt="<?= $user->name ?>"></td>
                            <td>Ext</td>
                            <td>
                                <a href="<?= URLROOT ?>/users/edit/<?= $user->id ?>" class="btn btn-primary">Edit</a>
                                <a href="<?= URLROOT ?>/users/delete/<?= $user->id ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <h4>total users: <?= count($data) ?></h4>
        </div>
    </div>


</section>

<?php require APPROOT . '/views/inc/footer.php'; ?>