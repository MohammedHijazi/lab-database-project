<?php
$server_name='localhost/XE';
$user_name='proj';
$pass='proj';
$error="Connection Error : ".oci_error();

$connect= oci_connect($user_name,$pass,$server_name) or die($error);

$msg='';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insert'])) {
    $pid = $_POST['pid'];
    $date = date("y-M-d",strtotime($_POST["date"]));
    $sql = "begin cart_insert(:pid ,:date); end;";

    $query = oci_parse($connect, $sql);
    oci_bind_by_name($query, ':pid', $pid);
    oci_bind_by_name($query, ':date', $date);

    oci_execute($query);

    if ($query) {
        $msg = 'Insert Cart Done!';
    } else {
        $msg = 'You have problems';
    }
}else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $tid = $_POST['tid'];
    $sql = "begin delete_record(:tid); end;";
    $query = oci_parse($connect, $sql);
    oci_bind_by_name($query, ':tid', $tid);

    oci_execute($query);
    if ($query) {
        $msg = 'delete product Done!';
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
                        <a class="nav-link" href="../categories/categories.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../products/products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
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
                                                        <th>Product ID</th>
                                                        <th>Date</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $select = "SELECT * FROM cart";
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
                                                    <form method="post" action="cart.php" style=" display: inline-block; ">
                                                        <div class="form-group row">
                                                            <label for="name" class="col-md-6 col-form-label text-md-left">Enter Cart_ID to delete</label>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control"  name="tid"  required autofocus>
                                                            </div>
                                                        </div>
                                                        <button name="delete" type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                                    </form>
                                                    <br><br>
                                                </div>
                                                <div>
                                                    <form method="post" action="cart.php" style=" display: inline-block; ">
                                                        <div class="form-group row">
                                                            <label for="name" class="col-md-5 col-form-label text-md-left">Enter Product_ID to Add</label>
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control"  name="pid"  required autofocus>
                                                            </div>
                                                            <label for="name" class="col-md-5 col-form-label text-md-left">Enter Date</label>
                                                            <div class="col-md-4">
                                                                <input type="date" class="form-control"  name="date"  required autofocus>
                                                            </div>
                                                        </div>
                                                        <button name="insert" type="submit" class="btn btn-outline-primary btn-sm">Add</button>
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
        </div>
    </main>
</div>
<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js" ></script>
</body>
</html>


