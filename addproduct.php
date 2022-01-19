<?php
require __DIR__ . "/woocommerce-api.php";
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
$link = "https";
else $link = "http";

$link .= "://" . $_SERVER['HTTP_HOST'];
if(isset($_SERVER['HTTP_REFERER'])){
    $previous_page = $_SERVER['HTTP_REFERER'];
    $from_products = preg_match("/products.php/", $previous_page);

    if($from_products){
        $categoriesData = json_decode($listCategories(), true);
        $categories = $categoriesData['data'];

    }
}
else {
    header("Location: " . $link . "/product/secret/login.php");
    exit;
}

?>

<?php
    if(isset($_POST['name']) && isset($_FILES['image'])){

        if($_POST['categories']){
            $categoriesArray = [];
            $categoriesSelected = explode("%", $_POST['categories']);
            for($i = 0; $i < count($categoriesSelected); $i++){
                $categoriesArray[$i] = array(
                    'id' => $categoriesSelected[$i]
                );
            }
        }

        if($_POST['tags']){
            $tagsArray = [];
            $tags = explode("%", $_POST['tags']);
            for($i = 0; $i < count($tags); $i++){
                $tagsArray[$i] = array(
                    'name' => $tags[$i]
                );
            }
        }

        $downloadable = $_POST['downloadable'] ? true : false;
        $virtual = $_POST['virtual'] ? true : false;
        
        
        
        move_uploaded_file($_FILES['image']['tmp_name'], "./images/".$_FILES['image']['name']);
        $image = "http://" . $_SERVER['HTTP_HOST'] . preg_replace("/addproduct.php.*/", "", $_SERVER['REQUEST_URI'], ) . "images/" . $_FILES['image']['name'];

        $data = array(
            'name' => $_POST['name'],
            'regular_price' => $_POST['regular-price'],
            'sale_price' => $_POST['sale-price'],
            'description' => $_POST['description'],
            'short_description' => $_POST['short-description'],
            'downloadable' => $downloadable,
            'virtual' => $virtual,
            'type' => $_POST['type'],
            'sku' => $_POST['sku'],
            'categories' => $categoriesArray,
            'tags' => $tagsArray,
            'images' => array(
                array(
                    'src' => $image,
                )
            )
        );
        $saveProduct = json_decode($addProduct($data), true);

        $imageFolder = "./images";

        $files = glob($imageFolder . "/*");
        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
            }
        }
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
        <a href="./products.php">Go back to products</a>
    </header>
    <form enctype="multipart/form-data" action="./addproduct.php" method="post">
        <div id="title-price">
            <span>
                <label for="name" >Name</label>
                <input type="text" name="name" id="name" required>
            </span>
            <span>
                <label for="regular-price">Regular Price</label>
                <input type="text" name="regular-price" id="regular-price">
            </span>
            <span>
                <label for="sale-price">Sale Price</label>
                <input type="text" name="sale-price" id="sale-price">
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
                <input type="checkbox" name="virtual" id="virtual">
            </span>
            <span>
                <label for="downloadable" class="inline">Downloadable</label>
                <input type="checkbox" name="downloadable" id="downloadable">
            </span>
        </div>

        <div id="product-image">
        <label class="custom-file-upload">
            <input type="file" id="image" name="image" required/>
            Custom Upload
        </label>
            <div id="image-preview">
                <img src="" alt="" id="img">
            </div>
        </div>

        <div id="product-description">
            <label for="description">Description</label>
            <textarea name="description" cols="30" rows="10" id="description"></textarea>
        </div>

        <div id="product-short-description">
            <label for="short-description"> Short Description</label>
            <textarea name="short-description" id="short-description" cols="30" rows="10"></textarea>
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
                <ul id="category-items"></ul>
            </div>
            <div id="tag-container">
                <div id="tag-form">
                    <label for="tags">Add Tags</label>
                    <span>
                        <input type="text" id="tag-input">
                        <button type="button" id="tag-button">Add</button>
                    </span>
                </div>
                <ul id="tag-items"></ul>
            </div>
        </div>

        <div id="sku">
            <label for="sku">SKU</label>
            <input type="text" name="sku" id="sku-input">
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

