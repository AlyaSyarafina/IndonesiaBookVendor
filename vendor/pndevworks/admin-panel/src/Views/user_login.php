<?php

namespace PNDevworks\AdminPanel\Views;

$request = \Config\Services::request();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Login | <?= config("AdminPanel")->brandingOptions['site-title'] ?></title>
	<link rel="stylesheet" href="<?= route_to("pnd_admin_asset", "lib/bootstrap/css/bootstrap.min.css") ?>">
	<link rel="stylesheet" href="<?= route_to("pnd_admin_asset", "lib/font-awesome/css/font-awesome.min.css") ?>">
</head>

<body>
	<div class="container">
		<div class="row align-items-center justify-content-center" style="height: 100vh;">
			<div class="col-sm-8 col-md-5">
				<div class="card border-0 shadow">
					<div class="card-body p-5">
						<?= view('PNDevworks\FlashMessages\Views\ShowMessage', ['msgChannel' => 'adminPanel']) ?>
						<form action="<?= route_to('pnd_login') ?>" method="POST">
							<div class="form-gorup my-2">
								<label for="email">E-mail:</label>
								<input class="form-control" id="email" name="email" type="email" />
							</div>
							<div class="form-group my-2">
								<label for="password">Password:</label>
								<input class="form-control" id="password" name="password" type="password" />
								<?php if (config("Authentication")->allowSelfResetPassword) : ?>
									<p class="form-helper"><a href="">Forgot password?</a></p>
								<?php endif; ?>
							</div>
							<?php if ($request->getGetPost('returnto')) : ?>
								<input type="hidden" name="returnto" value="<?= htmlentities($request->getGetPost('returnto')) ?>" />
							<?php endif; ?>
							<?= csrf_field() ?>

							<div class="form-gorup text-right">
								<button type="submit" class="btn btn-primary">Login</button>
							</div>
						</form>
					</div>
				</div>
				<div class="mt-4 text-center">
					<?php if ($showprivacypolicy): ?>
						<p class="text-muted small">
							<a target="_blank" href="https://dnartworks.co.id/privacy" rel="noopener noreferrer">Privacy Policy</a>
						</p>
					<?php endif; ?>
					<p class="text-muted"><?= config("AdminPanel")->brandingOptions['footer'] ?></p>
				</div>
			</div>
		</div>
	</div>
</body>

</html>