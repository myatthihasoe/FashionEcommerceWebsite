<?php
require_once("../Style/Head.php");
require_once("../Database/Connect.php");


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

<head>
    <link rel="stylesheet" href="../css/CreateProduct.css">
</head>

<!-- Html Code  -->
<!-- <div class="container bootstrap snippets bootdey" style="margin-top: 10px" ;>
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
</div> -->


<div class="form-body">
    <div class="row">
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Create Products</h3>
                    <!-- <p>Fill in the data below.</p> -->
                    <span class="text-danger"><?php echo (isset($_GET['isCreated'])) ? "product is created." : null ?></span>
                    <!-- <form class="requires-validation" novalidate> -->
                    <form method="POST" enctype="multipart/form-data" class="requires-validation" novalidate>
                        <div class="mb-3">
                            <img id="imageView" style="width: 150px; height: 150px; object-fit: contain;" class="bg-light mb-2">
                            <br>
                            <input type="file" id="image" name="image">
                        </div>
                        <div class="col-md-12">
                            <!-- <label for="productName" class="form-label">Product Name</label> -->
                            <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter Product Name" required>
                            <div class="valid-feedback">Product name is valid!</div>
                            <div class="invalid-feedback">Product name field cannot be blank!</div>
                        </div>

                        <div class="col-md-12 mb-3">

                            <select class="form-control mt3" name="productCat" id="productCat" placeholder="Select Category" required>
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

                            <div class="valid-feedback">You selected a category!</div>
                            <div class="invalid-feedback">Please select a category!</div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <!-- <label for="productPrice" class="form-label">Product Price</label> -->
                            <input type="number" step="0.01" min="1" class="form-control" id="productPrice" name="productPrice" placeholder="Enter Pice" required>
                            <div class="valid-feedback">Price field is valid!</div>
                            <div class="invalid-feedback">Price field cannot be blank!</div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <!-- <label for="productStock" class="form-label">Product Stock</label> -->
                            <input type="number" class="form-control" id="productStock" name="productStock" placeholder="Enter Product Stock" required>
                            <div class="valid-feedback">Stock field is valid!</div>
                            <div class="invalid-feedback">Stock field cannot be blank!</div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <!-- <label for="productDes" class="form-label">Product Description</label> -->
                            <textarea type="text" class="form-control"  id="productDes" name="productDes" placeholder="Enter Product Description"></textarea>
                        </div>
                   
                        <button class="btn btn-outline-light text-light" id="create" name="create">Create</button>
                        <a href="CreateProducts.php" class="btn btn-outline-light text-light">Refresh</a>
                        <button class="btn btn-outline-light" type="reset">Clear</button>

                        <a href="ViewProducts.php" class="btn btn-outline-light" style="text-align: right;">Back to View Products</a>
                        
                    </form>

                    <script>
                        (function() {
                            'use strict'
                            const forms = document.querySelectorAll('.requires-validation')
                            Array.from(forms)
                                .forEach(function(form) {
                                    form.addEventListener('create', function(event) {
                                        if (!form.checkValidity()) {
                                            event.preventDefault()
                                            event.stopPropagation()
                                        }

                                        form.classList.add('was-validated')
                                    }, false)
                                })
                        })()
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>