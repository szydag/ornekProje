<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">

<head>
  <base href="<?= base_url('/') ?>">
    <title>
        EduContent - Eğitim İçerik Yönetimi
    </title>
    <meta charset="utf-8" />
    <meta content="follow, index" name="robots" />
    <link href="https://127.0.0.1:8001/metronic-tailwind-html/demo1/index.html" rel="canonical" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="@keenthemes" name="twitter:site" />
    <meta content="@keenthemes" name="twitter:creator" />
    <meta content="summary_large_image" name="twitter:card" />
    <meta content="Kurs " name="twitter:title" />
    <meta content="" name="twitter:description" />
    <meta content=<?= base_url("assets/media/app/og-image.png") ?> name="twitter:image" />
    <meta content="https://127.0.0.1:8001/metronic-tailwind-html/demo1/index.html" property="og:url" />
    <meta content="en_US" property="og:locale" />
    <meta content="website" property="og:type" />
    <meta content="@keenthemes" property="og:site_name" />
    <meta content="Kurs " property="og:title" />
    <meta content="" property="og:description" />
    <meta content=<?= base_url("assets/media/app/og-image.png") ?> property="og:image" />
    <link href=<?= base_url("assets/media/app/apple-touch-icon.png") ?> rel="apple-touch-icon" sizes="180x180" />
    <link href=<?= base_url("assets/media/app/favicon-32x32.png") ?> rel="icon" sizes="32x32" type="image/png" />
    <link href=<?= base_url("assets/media/app/favicon-16x16.png") ?> rel="icon" sizes="16x16" type="image/png" />
    <link href=<?= base_url("assets/media/app/favicon.ico") ?> rel="shortcut icon" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href=<?= base_url("assets/vendors/apexcharts/apexcharts.css") ?> rel="stylesheet" />
    <link href=<?= base_url("assets/vendors/keenicons/styles.bundle.css") ?> rel="stylesheet" />
    <link href=<?= base_url("assets/css/styles.css") ?> rel="stylesheet" />
    <style>
        .kt-container-fixed {
            max-width: 100% !important;
            margin-inline: 0 !important;
        }

        .kt-wrapper {
            min-height: 100vh;
        }

        main#content {
            width: 100%;
        }
    </style>
</head>

<body class="antialiased flex h-full text-base text-foreground bg-background demo1 kt-sidebar-fixed kt-header-fixed">
    <script>
        const defaultThemeMode = 'light';
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('kt-theme')) {
                themeMode = localStorage.getItem('kt-theme');
            } else if (
                document.documentElement.hasAttribute('data-kt-theme-mode')
            ) {
                themeMode =
                    document.documentElement.getAttribute('data-kt-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ?
                    'dark' :
                    'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>
    <div class="flex grow">

        <?= $this->include('app/layouts/sidebar') ?>
        <div class="kt-wrapper flex grow flex-col">
            <?= $this->include('app/layouts/header') ?>
            <main class="grow pt-5" id="content" role="content">
                <?= $this->renderSection('content') ?>
            </main>
            <?= $this->include('app/layouts/footer') ?>
        </div>
    </div>

    <?= $this->renderSection('modals'); ?>
    <?= $this->include('app/modals/logout-confirmation-modal') ?>


    <!-- Scripts -->
    <script src=<?= base_url("assets/js/core.bundle.js") ?>>
    </script>
    <script src=<?= base_url("assets/vendors/ktui/ktui.min.js") ?>>
    </script>
    <script src=<?= base_url("assets/vendors/apexcharts/apexcharts.min.js") ?> >
    </script>
    <script src=<?= base_url("assets/js/widgets/general.js") ?>>
    </script>
    <script src=<?= base_url("assets/js/layouts/demo1.js") ?>>
    </script>
    <?= $this->renderSection('scripts') ?>
    <!-- End of Scripts -->
</body>

</html>
