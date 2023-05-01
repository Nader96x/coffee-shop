<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
$orders = $data['orders'];
// var_dump($orders);
$products_data = $data['products'];
// var_dump($products_data);
$products = [];
foreach ($products_data as $product) {

    $products[$product->id] = $product;
}
// var_dump($products);


// die();
?>
<section class="content">
    <?php flash('order_message');
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
                        <th scope="col">User Name</th>
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
                            <form class="d-inline-block"
                                action="<?php echo URLROOT; ?>/orders/deliver/<?php echo $order->id; ?>" method="post">
                                <input type="text" name="id" value="<?= $order->id ?>" hidden>
                                <?php

                                    //enum('Processing', 'out for delivery', 'done')
                                    if ($order->status == 'Processing') {
                                        echo '<input type="submit" value="Deliver" class="btn btn-outline-primary">';
                                    } elseif ($order->status == 'out for delivery') {
                                        echo '<input type="submit" value="Mark as Done" class="btn btn-primary">';
                                    } else {
                                        echo '<p class="btn btn-success">Delivered</p>';
                                    }
                                    ?>
                            </form>
                        </td>
                    <tr class="accordion">
                        <td colspan="7">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?php echo $order->id; ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse<?php echo $order->id; ?>" aria-expanded="false"
                                        aria-controls="collapse<?php echo $order->id; ?>">
                                        Order #<?php echo $order->id; ?>
                                    </button>
                                </h2>
                                <div id="collapse<?php echo $order->id; ?>" class="accordion-collapse collapse"
                                    aria-labelledby="heading<?php echo $order->id; ?>"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <?php foreach ($order->products as $p) {

                                                    $prod = $products[$p->product_id];
                                                    $prod->quantity = $p->quantity;
                                                    //                                                    var_dump($prod);
                                                    //                                                    die();
                                                ?>
                                            <div class="col-6 col-md-3 col-lg-2 my-2 product position-relative">
                                                <img src="https://dummyimage.com/400x400/000/fff&text=<?= $prod->name ?>"
                                                    alt="" data-price="<?= $prod->price ?>" data-id="<?= $prod->id ?>"
                                                    data-name="<?= $prod->name ?>" />
                                                <div class="position-absolute top-0 end-0 bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px;">
                                                    <span class="text-white"><?= $prod->price ?>L.E</span>
                                                </div>
                                                <div class="text-center">
                                                    <?= $prod->name . " (" . $prod->quantity . ")" ?></div>
                                            </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                        </td>
                    </tr>
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