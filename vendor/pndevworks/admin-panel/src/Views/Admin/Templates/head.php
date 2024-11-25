<?php

namespace PNDevworks\AdminPanel\Views\Admin\Templates;
?>
<!--head-->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?= $title ?> | <?= config("AdminPanel")->brandingOptions['site-title'] ?></title>
<link rel="stylesheet" href="<?= route_to("pnd_admin_asset", "/lib/bootstrap/css/bootstrap.min.css") ?>">
<link rel="stylesheet" href="<?= route_to("pnd_admin_asset", "/lib/font-awesome/css/fontawesome.min.css") ?>">
<link rel="stylesheet" href="<?= route_to("pnd_admin_asset", "/lib/font-awesome/css/all.min.css") ?>">

<style>
    .h-full {
        min-height: 70vh;
    }
</style>
<?php if (isset($extra_css)) : ?>
    <?php foreach ($extra_css as $css) : ?>
        <link href="<?= route_to("pnd_admin_asset", '/' . $css) ?>" rel="stylesheet">
    <?php endforeach; ?>
<?php endif; ?>
<!--/head-->