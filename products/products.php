<?php
$server_name='localhost/XE';
$user_name='proj';
$pass='proj';
$error="Connection Error : ".oci_error();

$connect= oci_connect($user_name,$pass,$server_name) or die($error);

$msg='';
$result='';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert_product'])) {
    //Insert product
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price=$_POST['price'];

    $sql = "begin prod_insert(:name,:parent_cat ,:price); end;";

    $query = oci_parse($connect, $sql);
    oci_bind_by_name($query, ':name', $name);
    oci_bind_by_name($query, ':parent_cat', $category_id);
    oci_bind_by_name($query, ':price', $price);

    oci_execute($query);

    if ($query) {
        $msg = 'Insert product Done!';
    } else {
        $msg = 'You have problems';
    }
}else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_name'])) {
    //Update product name
    $name= $_POST['name'];
    $new_name=$_POST['new_name'];

    $sql = "begin update_prod_name(:name,:new_name); end;";

    $query = oci_parse($connect, $sql);
    oci_bind_by_name($query, ':name', $name);
    oci_bind_by_name($query, ':new_name', $new_name);

    oci_execute($query);
    if ($query) {
        $msg = 'Update name Done!';
    } else {
        $msg = 'You have problems';
    }

}else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
    //Delete Product
    $pid = $_POST['pid'];

    $sql = "begin delete_record(:pid); end;";

    $query = oci_parse($connect, $sql);
    oci_bind_by_name($query, ':pid', $pid);

    oci_execute($query);
    if ($query) {
        $msg = 'delete product Done!';
    } else {
        $msg = 'You have problems';
    }
}else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $pid = $_POST['pid'];

    $sql = "begin :result := getAllData(:id); end;";

    $query = oci_parse($connect, $sql);
    oci_bind_by_name($query, ':id', $pid);
    oci_bind_by_name($query, ':result', $result , 500 ,SQLT_CHR);

    oci_execute($query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title>Project</title>
    <!-- Styles -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                Home
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->

                    <li class="nav-item">
                        <a class="nav-link" href="../categories/categories.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../cart/cart.php">Cart</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card" style="width: 900px">
                        <div class="card-header" style=" display: flex; justify-content: space-between; align-content: center; align-items: center;">Manage Products
                            <a class="btn btn-primary" href="create-products.php" role="button">ADD</a>
                        </div>
                        <div class="card-body">
                            <div class="container bootstrap snippets bootdey">
                                <div class="row" >
                                    <div class="col-md-12 personal-info">
                                        <div class="panel panel-border panel-primary" >
                                            <div class="panel-heading">
                                            </div>
                                            <div class="panel-body" >
                                                <table id="datatable-fixed-header"
                                                       class="table table-striped table-bordered success">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Category ID</th>
                                                        <th>Price</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $select = "SELECT * FROM product";
                                                    $query = oci_parse($connect, $select);
                                                    oci_execute($query);

                                                    while (($row = oci_fetch_array($query, OCI_ASSOC)) != false) {
                                                        echo "<tr>";
                                                        foreach ($row as $columnName => $columnValue) {
                                                            echo "<td>" . $columnValue . "</td>";
                                                        }
                                                        echo "</tr>";
                                                    }
                                                    ?>

                                                    </tbody>
                                                </table>
                                                <div>
                                                    <form method="post" action="products.php" style=" display: inline-block; ">
                                                        <div class="form-group row">
                                                            <label for="name" class="col-md-6 col-form-label text-md-left">Enter Product_ID to delete</label>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control"  name="pid"  required autofocus>
                                                            </div>
                                                        </div>
                                                        <button name="delete_product" type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                                    </form>
                                                    <br><br>
                                                </div>
                                                <div>
                                                    <form method="post" action="products.php" style=" display: inline-block; ">
                                                        <div class="form-group row">
                                                            <label for="name" class="col-md-5 col-form-label text-md-left">Enter Product_Name to edit</label>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control"  name="name"  required autofocus>
                                                            </div>
                                                            <label for="name" class="col-md-5 col-form-label text-md-left">Enter new Product_Name</label>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control"  name="new_name"  required autofocus>
                                                            </div>
                                                        </div>
                                                        <button name="edit_name" type="submit" class="btn btn-outline-primary btn-sm">Edit</button>
                                                    </form>
                                                    <br><br>
                                                </div>
                                                <div>
                                                    <form method="post" action="products.php" style=" display: inline-block; ">
                                                        <div class="form-group row">
                                                            <label for="name" class="col-md-6 col-form-label text-md-left">Enter Product_ID to search</label>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"  name="pid"  required autofocus>
                                                            </div>

                                                        </div>
                                                        <button name="search" type="submit" class="btn btn-outline-primary btn-sm">Search</button>
                                                    </form>
                                                    <br><br>
                                                </div>
                                                <h4><?php if($result) echo $result?></h4>
                                                <h5><?php if ($msg) echo $msg?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js" ></script>
</body>
</html>


