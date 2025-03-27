<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= getSetting('site_title') . ' | Dashboard'; ?></title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Remix Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.min.css" />

    <!-- Template CSS -->
    <link href="<?= base_url('assets/css/app.min.css'); ?>" rel="stylesheet">

    <!-- Custom Css -->
    <style>
        .select2-results__group {
            text-indent: 0rem !important;
        }

        .select2-results__option {
            text-indent: 1rem !important;
        }

        .is-invalid .ql-container,
        .is-invalid .ql-toolbar,
        .is-invalid .select2-selection,
        .is-invalid .select2-container--bootstrap4 .select2-dropdown {
            border-color: var(--bs-form-invalid-border-color) !important;
        }

        body>.skiptranslate {
            display: none;
        }

        .goog-te-combo {
            color: #333;
            border: 1px solid var(--bs-border-color);
            border-radius: 5px;
            padding: 5px;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
    </style>

    <?= $this->renderSection('css'); ?>

</head>

<body data-sidebar-position="left" data-sidebar-behavior="sticky">

    <div class="wrapper">

        <?= $this->include('dashboard/layout/sidebar'); ?>

        <div class="main">

            <?= $this->include('dashboard/layout/header'); ?>

            <main class="content">
                <?= $this->renderSection('content'); ?>
            </main>

            <?= $this->include('dashboard/layout/footer'); ?>
        </div>
    </div>

    <!-- Template JS -->
    <script src="<?= base_url('assets/js/app.min.js'); ?>"></script>

    <!-- Sweet Alert -->
    <script src="<?= base_url('assets/js/sweetalert.min.js'); ?>"></script>

    <script>
        function translateInit() {

            new google.translate.TranslateElement({
                pageLanguage: 'en',
            }, 'translate_element');

            var $googleDiv = $("#translate_element .skiptranslate");
            var $googleDivChild = $("#translate_element .skiptranslate div");
            $googleDivChild.next().remove();

            $googleDiv.contents().filter(function() {
                return this.nodeType === 3 && $.trim(this.nodeValue) !== '';
            }).remove();
        };
    </script>

    <!-- Google Translator -->
    <script src="https://translate.google.com/translate_a/element.js?cb=translateInit"></script>

    <!-- Custom Javascript -->
    <?= $this->renderSection('script'); ?>

</body>

</html>