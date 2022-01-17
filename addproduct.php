<?php
require __DIR__ . "/woocommerce-api.php";
if(isset($_SERVER['HTTP_REFERER'])){
    $previous_page = $_SERVER['HTTP_REFERER'];
    $from_products = preg_match("/products.php/", $previous_page);

    if($from_products){
        $categoriesData = json_decode($listCategories(), true);
        $categories = $categoriesData['data'];

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
    <script src="./js/addproduct.js" defer></script>
    <title>Add Product</title>
</head>
<body>
    <header>
        <a href="#">Go back to products</a>
    </header>
    <form action="./addproduct.php" method="post">
        <div id="title-price">
            <span>
                <label for="name">Name</label>
                <input type="text" name="name">
            </span>
            <span>
                <label for="regular_price">Regular Price</label>
                <input type="text" name="regular_price">
            </span>
            <span>
                <label for="sale_price">Sale Price</label>
                <input type="text" name="sale_price">
            </span>
        </div>

        <div id="product-settings">
            <span >
                <label for="product_type" ></label>
                <select name="product_type" id="">
                    <option value="" selected disabled>Product Type</option>
                    <option value="simple_product">Simple Product</option>
                    <option value="grouped_product">Grouped Product</option>
                    <option value="external_affiliate_product">External/Affiliate Product</option>
                    <option value="variable_product">Variable Product</option>
                </select>
            </span>
            <span >
                <label for="virtual" class="inline">Virtual</label>
                <input type="checkbox" name="virtual">
            </span>
            <span>
                <label for="downloadable" class="inline">Downloadable</label>
                <input type="checkbox" name="downloadable">
            </span>
        </div>

        <div id="product-image">
        <label class="custom-file-upload">
            <input type="file"/>
            Custom Upload
        </label>
            <div id="image-preview"></div>
        </div>

        <div id="product-description">
            <label for="description">Description</label>
            <textarea name="description" id="" cols="30" rows="10"></textarea>
        </div>

        <div id="product-short-description">
            <label for="short-description"> Short Description</label>
            <textarea name="short-description" id="" cols="30" rows="10"></textarea>
        </div>

        <div id="categories-tags">
            <div id="choose-category">
                <label for="category">Choose Category</label>
                <select name="category" id="category">
                    <option value="" disabled selected>Select Category</option>
                    <?php
                        foreach($categories as $category){?>
                            <option value="<?= $category['name']?>"><?= $category['name']?></option>
                       <?php }
                    ?>
                </select>
                <ul id="category-items"></ul>
            </div>
            <div id="tag-container">
                <div id="tag-form">
                    <label for="tags">Add Tags</label>
                    <span>
                        <input type="text" name="tags" id="tag-input">
                        <button type="button" id="tag-button">Add</button>
                    </span>
                </div>
                <ul id="tag-items"></ul>
            </div>
        </div>

        <div id="sku">
            <label for="sku">SKU</label>
            <input type="text" name="sku">
        </div>

        <div id="btn-save">
            <input type="submit" value="Save">
        </div>
    </form>
</body>
</html>