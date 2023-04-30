<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
$products = $data['products'];
$user_last_orders = $data['user_last_orders'];
$users = $data['users'];
?>
    <div class="row bg-light p-3">
        <?php flash('user_message');
        //        var_dump($data);
        ?>

        <div class="col-12 col-md-4">
            <div class="row border border-2 border-success m-2 p-2 h-auto">
                <div class="row"><h3>Order Details:</h3></div>
                <div id="orders" class="col-12">

                </div>
                <div class="col-12">
                    <h5>Notes:</h5>
                    <textarea name="notes" style="width: 100%" rows="5"></textarea>
                </div>

                <div class="col-12">
                    <label>Room</label>
                    <select name="room">
                        <option value="1">Room 1</option>
                        <option value="2">Room 2</option>
                        <option value="3">Room 3</option>
                    </select>
                </div>
                <hr class="my-2 ">
                <div class="col-12 alert alert-primary">
                    <h4>Total: <span id="total" class="text-success">0</span> L.E</h4>
                </div>
                <div class="col-12 my-3">
                    <button class="btn btn-success w-100" onclick="order(event)">Order</button>
                </div>
            </div>


        </div>
        <div class="col-12 col-md-8">
            <?php if (count($users) > 0) { ?>
                <h4 class="mt-3">add order to User</h4>
                <div class="row">
                    <select name="user_id">
                        <?php foreach ($users as $user) { ?>
                            <option value="<?= $user->id ?>"><?= $user->name ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <?php if (count($user_last_orders) > 0) { ?>
                <h4 class="mt-3">Latest Orders</h4>
                <div class="row">
                    <?php foreach ($user_last_orders as $prod) { ?>
                        <div class="col-6 col-md-3 col-lg-2 my-2 product position-relative">
                            <img src="https://dummyimage.com/400x400/000/fff&text=<?= $prod->name ?>"
                                 alt=""
                                 data-price="<?= $prod->price ?>" data-id="<?= $prod->id ?>"
                                 data-name="<?= $prod->name ?>"/>
                            <div
                                class="position-absolute top-0 end-0 bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <span class="text-white"><?= $prod->price ?>L.E</span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <hr>
            <h4>All Products</h4>
            <div class="row">
                <?php foreach ($products as $prod) { ?>
                    <div class="col-6 col-md-3 col-lg-2 my-2 product position-relative">
                        <img src="https://dummyimage.com/400x400/000/fff&text=<?= $prod->name ?>"
                             alt=""
                             data-price="<?= $prod->price ?>" data-id="<?= $prod->id ?>"
                             data-name="<?= $prod->name ?>"/>
                        <div
                            class="position-absolute top-0 end-0 bg-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <span class="text-white"><?= $prod->price ?>L.E</span>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>

    </div>
    <script>
        let products = [];

        function closeButton(products) {
            document.querySelectorAll(".btn-danger.remove").forEach(el => {
                el.addEventListener('click', function (event) {
                    let id = event.target.dataset.id;
                    let index = products.findIndex(p => p.id === id);
                    products.splice(index, 1);
                    drawProducts(products);
                })
            });
        }

        function activeCounters(products) {
            document.querySelectorAll(".prod-increase").forEach(el => {
                el.addEventListener('click', function (event) {
                    // console.log(event.target);
                    let id = event.target.parentElement.dataset.id;
                    document.querySelector("img[data-id='" + id + "']").click();
                    // debugger;
                })
            });
            document.querySelectorAll(".prod-decrease").forEach(el => {
                el.addEventListener('click', (event) => {
                    // console.log(event.target.parentElement.dataset.id)
                    let id = event.target.parentElement.dataset.id;
                    let index = products.findIndex(p => p.id === id);
                    if (products[index].qty > 1) {
                        products[index].qty--;
                    } else {
                        products.splice(index, 1);
                    }
                    // console.log(products);
                    drawProducts(products);

                })
            });
        }

        function drawProducts(products) {
            // console.log(products);
            let orders = document.getElementById('orders');
            let total = document.getElementById('total');
            let totalAmount = 0;
            let html = '';

            products.forEach(p => {
                html += `<div class="row text-center">
                            <div class="col-3 text-start">${p.name}</div>
                            <div class="col-2 px-0 mx-0">${p.qty} x${p.price}</div>

                            <div class="col-2 p-0 " data-id="${p.id}" data-price="${p.price}" data-name="${p.name}" >
                                <button class="w-25 p-0 text-center btn btn-outline-primary prod-increase">+</button>
                                <button class="w-25 p-0 text-center btn btn-outline-secondary prod-decrease">-</button>
                            </div>
                            <div class="col-3 mx-0 px-0">${p.price * p.qty} L.E</div>
                            <div class="col-2"><button class="btn btn-danger remove" data-id="${p.id}" >X</button></div>

                            <div class="col-12"><hr></div>
                        </div>`;
                totalAmount += p.price * p.qty;
            });
            orders.innerHTML = html;
            total.innerHTML = totalAmount;
            activeCounters(products);
            closeButton(products);

        }

        window.addEventListener('load', function () {

            document.querySelectorAll(".product").forEach(el => {
                el.addEventListener('click', function (event) {
                    if (event.target.tagName !== 'IMG') {
                        return;
                    }
                    // console.log(event.target.dataset.price);
                    // console.log(event.target.dataset.name);
                    // console.log(event.target.dataset.id);
                    let product = {
                        id: event.target.dataset.id,
                        name: event.target.dataset.name,
                        price: event.target.dataset.price,
                        qty: 1
                    };
                    let index = products.findIndex(p => p.id === product.id);
                    if (index === -1) {
                        products.push(product);
                    } else {
                        products[index].qty++;
                    }
                    // console.log(products);
                    drawProducts(products);


                })
            });
        })

        function order(event) {
            let notes = document.querySelector("textarea[name='notes']").value;
            let room = document.querySelector("select[name='room']").value;
            let total = document.querySelector("#total").innerHTML;
            let data = {
                notes: notes,
                room: room,
                total: total,
                products: products
            };
            console.log(data);
            fetch('<?= URLROOT ?>/orders/add', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(res => res.json())
                .then(res => {
                    console.log("lolll!");
                    console.log(res);
                    if (res.status === 'success') {
                        alert('Order Added Successfully');
                        window.location.href = '<?= URLROOT ?>/orders';
                    } else {
                        alert('Error');
                    }
                })
        }
    </script>

<?php require APPROOT . '/views/inc/footer.php'; ?>