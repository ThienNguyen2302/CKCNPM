<?php
    require_once('./product_db.php');
    $products = get_product();
    echo json_encode($products);

?>