<?php
$server_name='localhost/XE';
$user_name='proj';
$pass='proj';
$error="Connection Error : ".oci_error();

$connect= oci_connect($user_name,$pass,$server_name) or die($error);

$msg='';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    $name = $_POST['name'];
    $desc = $_POST['description'];

    $sql = "begin categ_insert(:name ,:description); end;";

    $query = oci_parse($connect, $sql);
    oci_bind_by_name($query, ':name', $name);
    oci_bind_by_name($query, ':description', $desc);

    oci_execute($query);

    if ($query) {
        $msg = 'Insert Done!';
    } else {
        $msg = 'You have problems';
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $cid = $_POST['cid'];

    $sql = "begin delete_record(:cid); end;";

    $query = oci_parse($connect, $sql);
    oci_bind_by_name($query, ':cid', $cid);

    oci_execute($query);
    if ($query) {
        $msg = 'delete Done!';
    } else {
        $msg = 'You have problems';
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_desc'])) {
    $desc= $_POST['desc'];
    $new_desc=$_POST['new_desc'];

    $sql = "begin update_cat_desc(:desc,:new_desc); end;";

    $query = oci_parse($connect, $sql);
    oci_bind_by_name($query, ':desc', $desc);
    oci_bind_by_name($query, ':new_desc', $new_desc);

    oci_execute($query);
    if ($query) {
        $msg = 'Update desc Done!';
    } else {

        $msg = 'You have problems';
    }
}else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_name'])) {
    $name= $_POST['name'];
    $new_name=$_POST['new_name'];

    $sql = "begin update_cat_name(:name,:new_name); end;";

    $query = oci_parse($connect, $sql);
    oci_bind_by_name($query, ':name', $name);
    oci_bind_by_name($query, ':new_name', $new_name);

    oci_execute($query);
    if ($query) {
        $msg = 'Update name Done!';
    } else {
        $msg = 'You have problems';
    }
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
                        <a class="nav-link" href="categories.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../products/products.php">Products</a>
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
                        <div class="card-header" style=" display: flex; justify-content: space-between; align-content: center; align-items: center;">Manage Categories

                            <a class="btn btn-primary" href="create-category.php" role="button">ADD</a>

                        </div>

                        <div class="card-body">

                            <div class="container bootstrap snippets bootdey">

                                <div class="row" >
                                    <!-- left column -->


                                    <!-- edit form column -->
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
                                                        <th>Description</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php

                                                    $select = "SELECT * FROM category";
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
                                                    <form method="post" action="categories.php" style=" display: inline-block; ">
                                                        <div class="form-group row">
                                                            <label for="name" class="col-md-6 col-form-label text-md-left">Enter Category_ID to delete</label>
                                                            <div class="col-md-2">
                                                                <input id="cid" type="text" class="form-control"  name="cid"  required autocomplete="name" autofocus>
                                                            </div>
                                                        </div>
                                                        <button name="delete" type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                                    </form>
                                                    <br><br>
                                                </div>
                                            </div>
                                            <div>
                                                <form method="post" action="categories.php" style=" display: inline-block; ">
                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-7 col-form-label text-md-left">Enter Category_Description to edit</label>
                                                        <div class="col-md-7">
                                                            <input id="desc" type="text" class="form-control"  name="desc"  required autofocus>
                                                        </div>
                                                        <label for="name" class="col-md-7 col-form-label text-md-left">Enter new Category_Description</label>
                                                        <div class="col-md-7">
                                                            <input id="new_desc" type="text" class="form-control"  name="new_desc"  required autofocus>
                                                        </div>
                                                    </div>
                                                    <button name="edit_desc" type="submit" class="btn btn-outline-primary btn-sm">Edit</button>
                                                </form>
                                                <br><br>
                                            </div>
                                            <div>
                                                <form method="post" action="categories.php" style=" display: inline-block; ">
                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-5 col-form-label text-md-left">Enter Category_Name to edit</label>
                                                        <div class="col-md-3">
                                                            <input id="name" type="text" class="form-control"  name="name"  required autofocus>
                                                        </div>
                                                        <label for="name" class="col-md-5 col-form-label text-md-left">Enter new Category_Description</label>
                                                        <div class="col-md-3">
                                                            <input id="new_desc" type="text" class="form-control"  name="new_name"  required autofocus>
                                                        </div>
                                                    </div>
                                                    <button name="edit_name" type="submit" class="btn btn-outline-primary btn-sm">Edit</button>
                                                </form>
                                                <br><br>
                                            </div>
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
    </main>
</div>
<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js" ></script>
</body>
</html>


