<?php

namespace PNDevworks\AdminPanel\Views\Admin\Templates;

use PNDevworks\AdminPanel\Models\UserModel;

helper("admin");
$navbar = admin_build_navbar($active);

?>
<!--navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<div class="container">
		<a class="navbar-brand" href="<?= route_to('pnd_admin') ?>">
			<?php if (config("AdminPanel")->brandingOptions['navbarUseLogo']) : ?>
				<img src="<?= config("AdminPanel")->brandingOptions['logo'] ?>" alt="<?= config("AdminPanel")->brandingOptions['site-title'] ?>">
			<?php else : ?>
				<?= config("AdminPanel")->brandingOptions['site-title'] ?>
			<?php endif; ?>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminmenu" aria-controls="adminmenu" aria-expanded="false" aria-label="Toggle menu">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="adminmenu">
			<ul class="navbar-nav flex-wrap">
				<?php foreach ($navbar as $table => $extra) : ?>
					<li class="nav-item<?= $extra['active'] ? ' active' : '' ?><?= !empty($extra['child']) ? ' dropdown' : '' ?>">
						<a class="nav-link<?= !empty($extra['child']) ? ' dropdown-toggle' : '' ?>" href="<?= $extra['link'] ?>" <?= !empty($extra['child']) ? 'role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : '' ?>>
							<?= $extra['label'] ?>
						</a>
						<?php if (!empty($extra['child'])) : ?>
							<div class="dropdown-menu">
								<?php foreach ($extra['child'] as $tab) : ?>
									<a class="dropdown-item<?= $tab['active'] ? ' active' : '' ?>" href="<?= $tab['link'] ?>">
										<?= $tab['label'] ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="user-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Hi <?= htmlspecialchars(UserModel::getCurrent()->first_name ?? '') ?>!
					</a>
					<div class="dropdown-menu" aria-labelledby="user-menu">
						<form action="<?= route_to('pnd_logout') ?>" method="POST">
							<input type="submit" value="Logout" class="dropdown-item" />
							<input type="hidden" name="returnto" value="<?= htmlentities($_SERVER['REQUEST_URI']) ?>" />
						</form>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
<p>&nbsp;</p>
<!--/navbar-->