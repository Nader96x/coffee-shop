<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
$orders = $data['orders'];
?>
    <section class="content">
        <?php flash('user_message');
        //        var_dump($data);
        ?>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <a class="btn btn-primary btn-sm" href="<?= URLROOT ?>/orders/create/">
                        <i class="fas fa-plus">
                        </i>
                        new order
                    </a>
                </h3>

            </div>
            <div class="card-body p-3">
                <h1>Orders</h1>
                <table class="table table-bordered table-light table-striped text-center">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Order Total</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    foreach ($orders

                             as $order) {
                        ?>
                        <tr>
                            <th class="align-middle" scope="row"><?php echo $i++; ?></th>
                            <td><?php echo $order->id; ?></td>
                            <td><?php echo $order->user_name; ?></td>
                            <td><?php echo $order->date; ?></td>
                            <td><?php echo $order->status; ?></td>
                            <td><?php echo $order->price; ?></td>
                            <td>
                                <a href="<?php echo URLROOT; ?>/orders/show/<?php echo $order->id; ?>"
                                   class="btn btn-primary">Show</a>
                                <a href="<?php echo URLROOT; ?>/orders/edit/<?php echo $order->id; ?>"
                                   class="btn btn-warning">Edit</a>
                                <form class="d-inline-block"
                                      action="<?php echo URLROOT; ?>/orders/delete/<?php echo $order->id; ?>"
                                      method="post">
                                    <input type="submit" value="Delete" class="btn btn-danger">
                                </form>
                            </td>
                        <tr class="accordion">
                            <td colspan="7">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?php echo $order->id; ?>">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse<?php echo $order->id; ?>"
                                                aria-expanded="false"
                                                aria-controls="collapse<?php echo $order->id; ?>">
                                            Order #<?php echo $order->id; ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?php echo $order->id; ?>" class="accordion-collapse collapse"
                                         aria-labelledby="heading<?php echo $order->id; ?>"
                                         data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>This is the first item's accordion body.</strong> It is shown by
                                            default, until the collapse plugin adds the appropriate classes that we use
                                            to
                                            style each element. These classes control the overall appearance, as well as
                                            the
                                            showing and hiding via CSS transitions. You can modify any of this with
                                            custom
                                            CSS or overriding our default variables. It's also worth noting that just
                                            about
                                            any HTML can go within the <code>.accordion-body</code>, though the
                                            transition
                                            does limit overflow.
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </div>

            <div class="card-footer">
                <h4>total Orders: <?= count($orders) ?></h4>
            </div>
        </div>
    </section>

<?php require APPROOT . '/views/inc/footer.php'; ?>