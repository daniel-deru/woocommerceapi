<?php
require __DIR__ . "/woocommerce-api.php";
if(isset($_SERVER['HTTP_REFERER'])){
    $previous_page = $_SERVER['HTTP_REFERER'];
    $from_products = preg_match("/products.php.*/", $previous_page);

    if($from_products){
        $categoriesData = json_decode($listCategories(), true);
        $categories = $categoriesData['data'];
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $product = json_decode($getProduct($id), true);

            echo "<pre>";
            print_r($product);
            echo "</pre>";
        }


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
    <link rel="stylesheet" href="./styles/addproduct.css">
    <script src="./js/editproduct.js" defer></script>
    <title>Edit Product</title>
</head>
<body>
    <header>
        <a href="#">Go back to products</a>
    </header>
    <form enctype="multipart/form-data" action="./addproduct.php" method="post">
        <div id="title-price">
            <span>
                <label for="name" >Name</label>
                <input type="text" name="name" id="name" required value="<?= $product['name']?>">
            </span>
            <span>
                <label for="regular-price">Regular Price</label>
                <input type="text" name="regular-price" id="regular-price" value="<?= $product['regular_price']?>">
            </span>
            <span>
                <label for="sale-price">Sale Price</label>
                <input type="text" name="sale-price" id="sale-price" value="<?= $product['sale_price']?>">
            </span>
        </div>

        <div id="product-settings">
            <span >
                <label for="type" ></label>
                <select name="type" id="product-type">
                    <option value="" selected disabled>Product Type</option>
                    <option value="simple">Simple Product</option>
                    <option value="grouped">Grouped Product</option>
                    <option value="external">External/Affiliate Product</option>
                    <option value="variable">Variable Product</option>
                </select>
            </span>
            <span >
                <label for="virtual" class="inline">Virtual</label>
                <input type="checkbox" name="virtual" id="virtual" >
            </span>
            <span>
                <label for="downloadable" class="inline">Downloadable</label>
                <input type="checkbox" name="downloadable" id="downloadable" >
            </span>
        </div>

        <div id="product-image">
        <label class="custom-file-upload">
            <input type="file" id="image" name="image" required/>
            Custom Upload
        </label>
            <div id="image-preview">
                <img src="<?= $product['images'][0]['src']?>" alt="" id="img">
            </div>
        </div>

        <div id="product-description">
            <label for="description">Description</label>
            <textarea name="description" cols="30" rows="10" id="description" value="<?= $product['description']?>"></textarea>
        </div>

        <div id="product-short-description">
            <label for="short-description"> Short Description</label>
            <textarea name="short-description" id="short-description" cols="30" rows="10" value="<?= $product['short_description']?>"></textarea>
        </div>

        <div id="categories-tags">

            <div id="choose-category">
                <label for="category">Choose Category</label>
                <select name="category" id="category">
                    <option value="" disabled selected>Select Category</option>
                    <?php
                        foreach($categories as $category){?>
                            <option value="<?= $category['name'], $category['id']?>"><?= $category['name']?></option>
                       <?php }
                    ?>
                </select>
                <ul id="category-items">
                <?php


                    $categoriesFilled = $product['categories'];
                        foreach($categoriesFilled as $category){?>
                            <li id="<?= $category['id']?>"><?= $category['name']?></li>
                     <?php   }

                ?>
                </ul>
            </div>



            <div id="tag-container">
                <div id="tag-form">
                    <label for="tags">Add Tags</label>
                    <span>
                        <input type="text" id="tag-input">
                        <button type="button" id="tag-button">Add</button>
                    </span>
                </div>
                <ul id="tag-items">
                <?php

                        $tags = $product['tags'];
                        foreach($tags as $tag){?>
                            <li id="<?= $tag['id']?>"><?= $tag['name']?></li>
                        <?php   }
                ?>

                </ul>
            </div>


        </div>

        <div id="sku">
            <label for="sku">SKU</label>
            <input type="text" name="sku" id="sku-input" value="<?= $product['sku']?>">
        </div>

        <div id="btn-save">
            <input type="submit" id="save-btn" value="Save">
        </div>
        <input type="hidden" name="categories" id="hidden-categories">
        <input type="hidden" name="tags" id="hidden-tags">
    </form>
    <div id="errors"></div>
</body>
</html>