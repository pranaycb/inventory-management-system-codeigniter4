<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?= base_url(); ?>" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= !empty($title) ? $title . ' | ' . getSetting('site_title') : getSetting('site_title'); ?></title>

    <link rel="icon" href="<?= base_url('assets/img/logo/' . getSetting('site_icon')); ?>">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Template CSS -->
    <link href="<?= base_url('assets/css/app.min.css'); ?>" rel="stylesheet">

    <?= $this->renderSection('css'); ?>

</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-behavior="sticky">
    <div class="main d-flex justify-content-center w-100">
        <main class="content d-flex p-0">
            <div class="container d-flex flex-column">
                <div class="row h-100">
                    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                        <?= $this->renderSection('content'); ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="<?= base_url('assets/js/app.min.js'); ?>"></script>

    <?= $this->renderSection('script'); ?>

</body>

</html>