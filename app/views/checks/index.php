<?php require APPROOT . '/views/inc/header.php'; ?>

<?php

$orders = $data['orders'];
$products_data = $data['products'];

$products = [];
foreach ($products_data as $product) {
    $products[$product->id] = $product;
}
$users = [];
foreach ($orders as $order) {
    $user = $order->user_name;
    if (!isset($users[$user])) {
        $users[$user] = [
            'name' => $order->user_name,
            'total_orders' => 0,
            'total_price' => 0,
        ];
    }
    $users[$user]['total_orders'] += 1;
    $users[$user]['total_price'] += $order->price;
}

?>
<section class="content">
    <?php flash('order_message'); ?>
    <form action="" method="get">
        <!-- checks -->
        <div class="row g-4 m-2">
            <div class="col-5 ">
                <label for="startDate">Date From</label>
                <input id="startDate" name="startDate" class="form-control" type="date" />
            </div>
            <div class="col-5">
                <label for="EndDate">Date To</label>
                <input id="EndDate" name="endDate" class="form-control" type="date" />
            </div>
        </div>

        <div class="row g-4 m-2">
            <div class="col ">
                <button class="btn btn-lg btn-primary" type="submit">submit</button>
            </div>
        </div>
    </form>


    <!-- tables -->
    <div class="card-body p-3">
        <h1>Orders</h1>
        <table class="table table-bordered table-light table-striped text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Total Orders</th>
                    <th scope="col">Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($users

                    as $user) {
                ?>
                <tr>
                    <th class="align-middle" scope="row"><?php echo $i++; ?></th>
                    <td><?php echo $user['name']; ?></td>
                    <td><?= $user['total_orders'] ?></td>
                    <td><?= $user['total_price'] ?></td>

                    <?php
                        foreach ($orders as $order) {
                            if ($order->user_name == $user['name']) {
                        ?>
                <tr class="accordion">
                    <td colspan="7">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?php echo $order->id; ?>">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse<?php echo $order->id; ?>" aria-expanded="false"
                                    aria-controls="collapse<?php echo $order->id; ?>">
                                    <?php echo "Order Date: <h3>" . $order->date . "</h3>"; ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php echo "Order Price: <h3>" . $order->price . " EGP </h3>";
                                        ?>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $order->id; ?>" class="accordion-collapse collapse"
                                aria-labelledby="heading<?php echo $order->id; ?>" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <?php foreach ($order->products as $p) {

                                                $prod = $products[$p->product_id];
                                                $prod->quantity = $p->quantity;

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
                <?php }
                        }
            ?>
                </tr>
                <?php } ?>

            </tbody>
        </table>

    </div>
</section>

<?php require APPROOT . '/views/inc/footer.php'; ?>