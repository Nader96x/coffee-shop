<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
$products = $data['products'];
$user_last_orders = $data['user_last_orders'];
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
                <div class="col-12">
                    <h4>Total: <span id="total" class="text-success">0</span></h4>
                </div>
            </div>


        </div>
        <div class="col-12 col-md-8">
            <h4>Latest Orders</h4>
            <div class="row">
                <?php foreach ($user_last_orders as $prod) { ?>
                    <div class="col-6 col-md-3 col-lg-2 my-2 product">
                        <img src="https://dummyimage.com/400x400/000/fff&text=<?= $prod->name ?>"
                             alt=""
                             data-price="<?= $prod->price ?>" data-id="<?= $prod->id ?>"
                             data-name="<?= $prod->name ?>"/>
                    </div>
                <?php } ?>


            </div>
            <hr>
            <h4>All Products</h4>
            <div class="row">
                <?php foreach ($products as $prod) { ?>
                    <div class="col-6 col-md-3 col-lg-2 my-2 product">
                        <img src="https://dummyimage.com/400x400/000/fff&text=<?= $prod->name ?>"
                             alt=""
                             data-price="<?= $prod->price ?>" data-id="<?= $prod->id ?>"
                             data-name="<?= $prod->name ?>"/>
                    </div>
                <?php } ?>


            </div>

        </div>

    </div>
    <script>
        function closeButton(products) {
            document.querySelectorAll(".btn-danger.remove").forEach(el => {
                el.addEventListener('click', function (event) {
                    let id = event.target.parentElement.dataset.id;
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
                    console.log(event.target.parentElement.dataset.id)
                    let id = event.target.parentElement.dataset.id;
                    let index = products.findIndex(p => p.id === id);
                    if (products[index].qty > 1) {
                        products[index].qty--;
                    } else {
                        products.splice(index, 1);
                    }
                    console.log(products);
                    drawProducts(products);

                })
            });
        }

        function drawProducts(products) {
            let orders = document.getElementById('orders');
            let total = document.getElementById('total');
            let totalAmount = 0;
            let html = '';

            products.forEach(p => {
                html += `<div class="row text-center">
                            <div class="col-3 text-start">${p.name}</div>
                            <div class="col-2">${p.qty}</div>

                            <div class="col-2 p-0 " data-id="${p.id}" data-price="${p.price}" data-name="${p.name}" >
                                <button class="w-25 p-0 text-center btn btn-outline-primary prod-increase">+</button>
                                <button class="w-25 p-0 text-center btn btn-outline-secondary prod-decrease">-</button>
                            </div>
                            <div class="col-3">${p.price * p.qty} L.E</div>
                            <div class="col-2"><button class="btn btn-danger remove">X</button></div>

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
            let products = [];

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
    </script>

<?php require APPROOT . '/views/inc/footer.php'; ?>