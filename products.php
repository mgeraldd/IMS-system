<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container add-product-form">
    <h1 class="text-center">Add Product</h1>
    <form action="add-products.php" method="post">
        <div class="form-group">
            <label for="productID">Product ID:</label>
            <input type="text" id="productID" name="productID" placeholder="Enter product ID" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="productName" placeholder="Enter product name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" placeholder="Enter price" step="0.01" class="form-control" required>
        </div>
        <div class="form-group">
            <input type="submit" name="addProduct" value="Add Product" class="btn btn-success">
        </div>
    </form>
</div>

 
</body>
</html>