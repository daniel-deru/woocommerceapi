<?php 
require __DIR__ . "/woocommerce-api.php";
function displayData($data){
    if($data){
        return $data;
    }
    else {
        return "Not Set";
    }
}

global $categories;
if(isset($_SERVER['HTTP_REFERER'])){
    
    $previous_page = $_SERVER['HTTP_REFERER'];
    $from_login = preg_match("/login.php$/", $previous_page);
    $from_products = preg_match("/products.php\?page=[1-9]{1,5}/", $previous_page);

    $page = 1;
    if($from_login){

        $productsData = json_decode($listProducts($page), true);
        $categoriesData = json_decode($listCategories(), true);
        $products = $productsData['data'];
        $categories = $categoriesData['data'];
        $productsHeaders = $productsData['headers'];

    }
    else if($from_products) {
        if(isset($_GET['page'])){
            $page = intval($_GET['page']);
        }
        $productsData = json_decode($listProducts($page), true);
        $categoriesData = json_decode($listCategories(), true);
        $products = $productsData['data'];
        $categories = $categoriesData['data'];
        $productsHeaders = $productsData['headers'];
    }
}
else {
    header("Location: http://localhost/product/secret/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/products.css">
    <title>Products</title>
</head>
<body>
    <header>
        <select name="categories" id="category-select">
            <?php
                if(isset($categories)){
                    foreach($categories as $category){?>

                        <option value="<?php echo $category['slug']?>"><?php echo $category['name']?></option>
                    <?php }
                }
            ?>
        </select>
        <a href="./addproduct.php">Add New Product</a>
    </header>
    <main id="product-grid">
        <?php
        
                if(isset($products)){
                    foreach($products as $product){?>

                        <div class="product-container">
                            <img src="<?php echo $product['images'][0]['src']?>" alt="" class="product-image">
                            <div class="title"><?php echo $product['name']?></div>
                            <div class="price">R <?php echo $product['regular_price']?></div>
                            <div class="SKU-categories">
                                <span class="SKU"><b>SKU: </b><?php echo displayData($product['sku'])?></span>
                                <span class="Categories"><b>Categories: </b><?php echo $product['categories'][0]['name']?></span>
                            </div>
                            <a href="#" class="edit-product">Edit Product</a>
                        </div>
                   <?php }
                }
        
        ?>
    </main>
    <div id="pagination">
        <div>Showing page <?=$page?> of 
            <?= $productsHeaders['X-WP-TotalPages']?>
        </div>
        <ul id="page-list">
            <?php 
                for($i = 1; $i <= $productsHeaders['X-WP-TotalPages']; $i++){?>
                    <li class="page">
                        <a href="./products.php?page=<?=$i?>"><?= $i?></a>
                    </li>
               <?php
                }
            ?>
        </ul>
    </div>
</body>
</html>