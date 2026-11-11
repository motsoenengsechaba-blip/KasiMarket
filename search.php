<?php
include 'config/db.php';

$search = "";
$category = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

if (isset($_GET['category'])) {
    $category = $_GET['category'];
}

$query = "SELECT * FROM products WHERE status='available'";

if (!empty($search)) {
    $query .= " AND title LIKE '%$search%'";
}

if (!empty($category)) {
    $query .= " AND category = '$category'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Products</title>
</head>
<body>

<h2>Search Products</h2>

<form method="GET">

    <input type="text" name="search" placeholder="Search products..." value="<?php echo $search; ?>">

    <select name="category">
        <option value="">All Categories</option>
        <option>Electronics</option>
        <option>Fashion</option>
        <option>Books</option>
        <option>Household</option>
        <option>Handmade</option>
    </select>

    <button type="submit">Search</button>

</form>

<hr>

<?php while($product = $result->fetch_assoc()) { ?>

    <div style="border:1px solid #ccc; padding:10px; margin:10px; width:250px;">
        <img src="uploads/<?php echo $product['image']; ?>" width="100%">
        <h3><?php echo $product['title']; ?></h3>
        <p><?php echo $product['category']; ?></p>
        <p>R<?php echo $product['price']; ?></p>

        <a href="products/product_details.php?id=<?php echo $product['id']; ?>">
            View Details
        </a>
    </div>

<?php } ?>

</body>
</html>