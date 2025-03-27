<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= getSetting('site_title'); ?></title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;display=swap" rel="stylesheet">

    <link href="<?= base_url('assets/css/app.min.css'); ?>" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand text-dark" href="#!">
                <?= getSetting('site_title'); ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= route_to('route.home'); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route_to('route.user.login'); ?>">User Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route_to('route.admin.login'); ?>">Admin Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark pt-5 pb-4 mt-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center">
                <h1 class="display-4 fw-bolder text-white">Store Products</h1>
                <p class="lead fw-normal text-white-50 mb-0">Recently Added Products Of Our Store</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

                <?php if (!empty($products)) :

                    foreach ($products as $product) : ?>

                        <div class="col mb-5">
                            <div class="card h-100">
                                <?php if ($product->sold == $product->qty) : ?>
                                    <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Out Of Stock</div>
                                <?php endif; ?>
                                <img class="card-img-top" src="<?= base_url('assets/img/products/' . $product->image); ?>" alt="..." />
                                <div class="card-body p-4">
                                    <div class="text-center">

                                        <p class="mb-2"><?= $product->brand; ?></p>

                                        <h5 class="fw-bolder">
                                            <?= $product->name; ?>
                                        </h5>
                                        <?= $product->description; ?>

                                        <?= number_format($product->price); ?>৳
                                    </div>
                                </div>
                                <?php if ($product->sold != $product->qty) : ?>
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Order Now</a></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; <?= getSetting('site_title') . ' ' . date('Y'); ?></p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="<?= base_url('assets/js/app.min.js'); ?>"></script>
</body>

</html>