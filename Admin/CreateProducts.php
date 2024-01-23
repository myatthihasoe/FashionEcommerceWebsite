<?php
require_once("../Style/Head.php");
require_once("../Database/Connect.php");
// require_once("../Database/CreateTable.php");

function getImage()
{
    //get image path to store in database
    $imgPath =  "../img/" . $_FILES['image']['name'];
    //move chosen image full path into project images/folder
    $isUploaded = move_uploaded_file($_FILES['image']['tmp_name'], $imgPath);
    return $isUploaded ? $imgPath : ""; //insert empty in database
}

if (isset($_POST['create'])) {
    $name = $_POST['productName'];
    $cat = $_POST['productCat'];
    // $brand = $_POST['productBrand'];
    $price = $_POST['productPrice'];
    $stock = $_POST['productStock'];
    $description = $_POST['productDes'];

    $img = getImage();

    $create_product = "INSERT INTO products VALUES ('','$name','$cat','$price','$stock','$description','$img')";
    try {
        $pdo->exec($create_product);
        header("Location: CreateProducts.php ? isCreated = ok");
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    // alert box
    if ($create_product) {
        echo "<script>alert('done')</script>";
    } else {
        echo "<script>alert('error')</script>";
    }
}
?>

<!-- Html Code  -->
<div class="container bootstrap snippets bootdey" style="margin-top: 10px" ;>
    <a href="ViewProducts.php" class="btn btn-outline-success">View Products</a>
</div>
<div class="container mt-3 py-3 bg-danger text-light">
    <span class="text-danger"><?php echo (isset($_GET['isCreated'])) ? "product is created." : null ?></span>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <img id="imageView" style="width: 200px; height: 200px; object-fit: contain;" class="bg-light mb-2">
            <br>
            <input type="file" id="image" name="image">
        </div>
        <div class="mb-3">
            <label for="productName" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter Product Name" required>
        </div>
        <div class="mb-3">
            <label for="productCat" class="form-label">Product Category</label>
            <br>
            <select class="form-control" name="productCat" id="productCat" placeholder="Select Category" required>
                <?php
                $categories =  "SELECT * from category"; //condition par lar may yan (on category.id = products.category_id)
                $stmt = $pdo->query($categories);
                foreach ($cat = $stmt->fetchAll(PDO::FETCH_ASSOC) as $each) :
                ?>
                    <option value="<?php echo $each['id'] ?>">
                        <?php echo $each['Category'] ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="productPrice" class="form-label">Product Price</label>
            <input type="number" step="0.01" min="1" class="form-control" id="productPrice" name="productPrice" placeholder="Enter Pice" required>
        </div>
        <div class="mb-3">
            <label for="productStock" class="form-label">Product Stock</label>
            <input type="number" class="form-control" id="productStock" name="productStock" placeholder="Enter Product Stock" required>
        </div>
        <div class="mb-3">
            <label for="productDes" class="form-label">Product Description</label>
            <textarea class="form-control" id="productDes" rows="3" name="productDes" placeholder="Enter Product Description"></textarea>
        </div>

        <button class="btn btn-outline-dark text-light" name="create">Create</button>
        <a href="CreateProducts.php" class="btn btn-outline-dark text-light">Refresh</a>
        <button class="btn btn-outline-light" type="reset">Clear</button>
    </form>

    <!-- script code for product image  -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const image = document.getElementById("image");
            const imageView = document.getElementById("imageView");
            // console.log(image, imageView);

            image.addEventListener("change", () => {
                // console.log(image.files[0]);
                if (image.files[0]) {
                    const imageReader = new FileReader();

                    imageReader.onload = (ev) => {
                        imageView.src = ev.target.result;
                    }
                    imageReader.readAsDataURL(image.files[0]);
                }
            })
        });
    </script>
</div>