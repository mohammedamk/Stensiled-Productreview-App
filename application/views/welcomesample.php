<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="<?php echo site_url(); ?>assets/css/seaff.css" type="text/css" rel="stylesheet">
    <script src="https://cdn.shopify.com/s/assets/external/app.js"></script>
    <script type="text/javascript">
        ShopifyApp.init({
            apiKey: '<?php echo $api_key; ?>',
            shopOrigin: '<?php echo 'https://'  . $shop; ?>'
        });
    </script>
    <script type="text/javascript">
        ShopifyApp.ready(function() {
            ShopifyApp.Bar.initialize({
                buttons: {
                    primary: {
                        label: 'Save',
                        message: 'unicorn_form_submit',
                        loading: true
                    }
                }
            });
        });
    </script>
</head>

<body>
    <h1>Product</h1>
    <section>
        <div class="container">
            <a href="/<?= site_url('products') ?>">Products</a>
            <div class="row">
                <table class="table table-bordered">
                    <tr>
                        <th>Product id</th>
                        <th>Product image</th>
                        <th>Product title</th>
                        <th>vendor</th>
                        <th>product_type</th>
                    </tr>
                    <?php
                    // echo "<pre>";
                    // var_dump($products_list);
                    // exit;
                    foreach ($products_list->products as $product) { ?>
                        <tr>
                            <td><?php echo $product->id; ?></td>
                            <td><img src="<?php echo $product->image->src; ?>" alt="" width="100" height="70"></td>
                            <td><?php echo $product->title; ?></td>
                            <td><?php echo $product->vendor; ?></td>
                            <td><?php
                                if (!$product->product_type  == "") {
                                    echo $product->product_type;
                                } else {
                                    echo "Not Mention";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>

                </table>
            </div>
        </div>
    </section>

</body>

</html>