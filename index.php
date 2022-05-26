<?php


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title>Project</title>
    <!-- Styles -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
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
                        <a class="nav-link" href="./categories/categories.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./products/products.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./cart/cart.php">Cart</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">Dashboard</div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-4 ">
                                    <a href="./categories/categories.php" class="btn btn-lg btn-block btn-primary">
                                        Categories
                                    </a>
                                </div>
                                <div class="col-md-4 ">
                                    <a href="./products/products.php" class="btn btn-lg btn-block btn-primary">
                                        Products
                                        <br>
                                    </a>
                                </div>

                                <div class="col-md-4 ">
                                    <a href="./cart/cart.php" class="btn btn-lg btn-block btn-primary">
                                        Cart
                                        <br>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="./assets/js/jquery-3.5.1.min.js"></script>
<script src="./assets/js/bootstrap.bundle.min.js" ></script>
</body>
</html>

