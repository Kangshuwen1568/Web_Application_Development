<nav class="container navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">E-GROCERY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Products</a>

                    <ul class="dropdown-menu">
                        <li> <a class="dropdown-item" href="product_create.php">Create Product</a></li>
                        <li> <a class="dropdown-item" href="product_read.php">Read Product</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Categories</a>

                    <ul class="dropdown-menu">
                        <li> <a class="dropdown-item" href="category_create.php">Create Category</a></li>
                        <li> <a class="dropdown-item" href="category_read.php">Read Category</a></li>
                    </ul>
                </li>

                <li class="nav-item  dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Customers</a>

                    <ul class="dropdown-menu">
                        <li> <a class="dropdown-item" href="customer_create.php">Create Customer</a></li>
                        <li> <a class="dropdown-item" href="customer_read.php">Read Customer</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Order</a>

                    <ul class="dropdown-menu">
                        <li> <a class="dropdown-item" href="order_create.php">Create Order</a></li>
                        <li> <a class="dropdown-item" href="order_read.php">Read Order</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="contact_form.php">Contact</a>
                </li>
                <?php
                if (isset($_POST['submit'])) {
                    // destroy the session 
                    session_destroy();
                    // remove all session variables
                    session_unset();
                    header("location: login.php");
                }
                ?>

                <li class="nav-item">
                    <a class="nav-link" href="login.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>