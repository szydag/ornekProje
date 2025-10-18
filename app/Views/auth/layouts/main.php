<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="tr">

<head>
    <meta content="<?= $description ?? 'Kurs - Güvenli giriş sistemi' ?>" name="twitter:description" />
    <meta content="<?= $description ?? 'Kurs - Güvenli giriş sistemi' ?>" property="og:description" />
    <meta content="<?= $description ?? 'Kurs - Güvenli giriş sistemi' ?>" name="description" />
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
    <meta content="<?= $title ?? 'Kurs' ?>" name="twitter:title" />
    <meta content="/assets/media/app/og-image.png" name="twitter:image" />
    <meta content="<?= $title ?? 'Kurs' ?>" property="og:title" />
    <meta content="/assets/media/app/og-image.png" property="og:image" />
    <meta content="summary_large_image" name="twitter:card" />
    <meta content="@kurs" name="twitter:creator" />
    <meta content="Kurs" property="og:site_name" />
    <meta content="@kurs" name="twitter:site" />
    <meta content="follow, index" name="robots" />
    <meta content="website" property="og:type" />
    <meta content="tr_TR" property="og:locale" />
    <meta charset="utf-8" />

    <title><?= $title ?? 'Kurs' ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="/assets/media/app/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180" />
    <link href="/assets/media/app/favicon-32x32.png" rel="icon" sizes="32x32" type="image/png" />
    <link href="/assets/media/app/favicon-16x16.png" rel="icon" sizes="16x16" type="image/png" />
    <link href="/assets/vendors/keenicons/styles.bundle.css" rel="stylesheet" />
    <link href="/assets/vendors/apexcharts/apexcharts.css" rel="stylesheet" />
    <link href="/assets/css/styles.css" rel="stylesheet" />
    <link href="/favicon.ico" rel="shortcut icon" />

    <style>
        .auth-bg-branded {
            background-image: url('/assets/media/images/2600x1600/1.png');
        }

        .dark .auth-bg-branded {
            background-image: url('/assets/media/images/2600x1600/1-dark.png');
        }

        .auth-bg-simple {
            background-image: url('/assets/media/images/2600x1200/bg-10.png');
        }

        .dark .auth-bg-simple {
            background-image: url('/assets/media/images/2600x1200/bg-10-dark.png');
        }
    </style>

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
    
    <?= $this->renderSection('styles') ?>
</head>

<body class="antialiased flex h-full text-base text-foreground bg-background">

    <?= $this->renderSection('content') ?>

    <script src="/assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="/assets/vendors/ktui/ktui.min.js"></script>
    <script src="/assets/js/core.bundle.js"></script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>