<?php if ($metaDescription !== null): ?><meta name="description" content="<?= esc($metaDescription) ?>"><?php endif; ?>

<meta property="og:type" content="website">
<?php if ($metaTitle !== null): ?><meta property="og:title" content="<?= esc($metaTitle) ?>"/><?php endif; ?>
<?php if ($metaDescription !== null): ?><meta property="og:description" content="<?= esc($metaDescription) ?>"><?php endif; ?>
<?php if ($url !== null): ?><meta property="og:url" content="<?= esc($url) ?>"><?php endif; ?>
<?php if ($metaImage !== null): ?><meta property="og:image" content="<?= esc($metaImage) ?>"><?php endif; ?>

<meta property="twitter:card" content="summary_large_image">
<?php if ($metaTitle !== null): ?><meta property="twitter:title" content="<?= esc($metaTitle) ?>"/><?php endif; ?>
<?php if ($metaDescription !== null): ?><meta property="twitter:description" content="<?= esc($metaDescription) ?>"><?php endif; ?>
<?php if ($metaImage !== null): ?><meta property="twitter:image" content="<?= esc($metaImage) ?>"><?php endif; ?>
