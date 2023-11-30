<?php
    
    require_once '../classes/product.class.php';
    require_once  '../tools/functions.php';

    //resume session here to fetch session values
    session_start();
    /*
        if user is not login then redirect to login page,
        this is to prevent users from accessing pages that requires
        authentication such as the dashboard
    */
    if (!isset($_SESSION['user']) || $_SESSION['user'] != 'staff'){
        header('location: ./index.php');
    }
    
    //if the above code is false then html below will be displayed

    if(isset($_POST['save'])){

        $product = new Product();
        //sanitize
        $product->pizzaname = htmlentities($_POST['pizzaname']);
        $product->category  = htmlentities($_POST['category']);
        $product->price = htmlentities($_POST['price']);
        $product->availability = htmlentities($_POST['availability']);
       
        if(isset($_POST['availability'])){
            $product->availability = htmlentities($_POST['availability']);
        }else{
            $product->availability = '';
        }

        //validate
        if (validate_field($product->pizzaname) &&
        validate_field($product->category) &&
        validate_field($product->price) &&
     
        validate_field($product->availability) &&
        
        validate_field($product->pizzaname) && !$product->is_pizzaname_exist()){
            if($product->add()){
                header('location: products.php');
            }else{
                echo 'An error occured while adding in the database.';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php
    $title = 'Add product';
    $product_page = 'active';
    require_once('../include/head.php');
?>
<body>
    <?php
        require_once('../include/header.admin.php')
    ?>
    <main>
        <div class="container-fluid">
            <div class="row">
                <?php
                    require_once('../include/sidepanel.php')
                ?>
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="col-12 col-lg-6 d-flex justify-content-between align-items-center">
                        <h2 class="h3 brand-color pt-3 pb-2">Add product</h2>
                        <a href="product.php" class="text-primary text-decoration-none"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                    </div>
                    <div class="col-12 col-lg-6">
                        <form method="post" action="">
                            <div class="mb-2">
                                <label for="pizzaname" class="form-label">Pizza Name</label>
                                <input type="text" class="form-control" id="pizzaname" name="pizzaname" required value="<?php if(isset($_POST['pizzaname'])) { echo $_POST['pizzaname']; } ?>">
                                <?php
                                    if(isset($_POST['pizzaname']) && !validate_field($_POST['pizzaname'])){
                                ?>
                                        <p class="text-danger my-1">Pizza name is required</p>
                                <?php
                                    }
                                ?>
                            </div>


                            <!-- Category START -->
                            <div class="form-group mb-2">
                                <label for="product-category" class="form-label">Category</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="Pizza" <?php if(isset($_POST['category']) && $_POST['category'] == 'Pizza') { echo 'selected'; } ?>>pizza</option>
                                    <option value="Beverages" <?php if(isset($_POST['category']) && $_POST['category'] == 'Beverages') { echo 'selected'; } ?>>beverages</option>
                                    
                                </select>
                                <?php
                                    if(isset($_POST['category']) && !validate_field($_POST['category'])){
                                ?>
                                        <p class="text-danger my-1">Select product category</p>
                                <?php
                                    }
                                ?>
                            </div>

                            


                            <!-- Category END -->


                            <div class="mb-2">
                                <label for="price" class="form-label">Price</label>
                                <input type="text" class="form-control" id="price" name="price" required value="<?php if(isset($_POST['price'])) { echo $_POST['price']; } ?>">
                                <?php
                                    if(isset($_POST['price']) && !validate_field($_POST['price'])){
                                ?>
                                        <p class="text-danger my-1">Pizza name is required</p>
                                <?php
                                    }
                                ?>
                            </div>


                            
                            <div class="form-group mb-2">
                                <label class="form-label">availability</label>
                                <div class="d-flex">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="availabilityActive" name="availability" value="Active" <?php if(isset($_POST['availability']) && $_POST['availability'] == 'Active') { echo 'checked'; } ?>>
                                        <label class="form-check-label" for="availabilityActive">Available</label>
                                    </div>
                                    <div class="form-check ms-3">
                                        <input type="radio" class="form-check-input" id="availabilityDeactivated" name="availability" value="Deactivated" <?php if(isset($_POST['availability']) && $_POST['availability'] == 'Deactivated') { echo 'checked'; } ?>>
                                        <label class="form-check-label" for="availabilityDeactivated">Unavailable</label>
                                    </div>
                                </div>
                                <?php
                                    if((!isset($_POST['availability']) && isset($_POST['save'])) || (isset($_POST['availability']) && !validate_field($_POST['availability']))){
                                ?>
                                        <p class="text-danger my-1">Select product availability</p>
                                <?php
                                    }
                                ?>
                            </div>
                            <button type="submit" name="save" class="btn btn-primary mt-2 mb-3 brand-bg-color" id="addproductButton">Add product</button>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </main>
    <?php
        require_once('../include/js.php')
    ?>
</body>
</html>