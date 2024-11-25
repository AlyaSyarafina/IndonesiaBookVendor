<?php

namespace PNDevworks\AdminPanel\Views\Admin\Templates\footer;
$version = null;
try {
    $version = \Composer\InstalledVersions::getPrettyVersion('pndevworks/admin-panel');
} catch (\Exception $e) {
}

$adminBranding = config("AdminPanel")->brandingOptions;

?>

<footer class="mt-5 py-5 bg-light text-dark">
    <div class="container">
        <div class="row">
            <div class="col">
                <?= $adminBranding['footer'] ?>
            </div>
        </div>
        <div class="row">
            <div class="col text-muted small">
                <?= $adminBranding['site-title'] ?> <b>v<?= $version ?><b/>.
            </div>
        </div>
    </div>
</footer>