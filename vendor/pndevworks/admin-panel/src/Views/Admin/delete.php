<?php

namespace PNDevworks\AdminPanel\Views\Admin;
?>
<!DOCTYPE html>
<html>

<head>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\head', ['title' => "Delete $table entry"]); ?>
</head>

<body id="delete">
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\navbar', ['active' => $table]); ?>
	<div class="container h-full">
		<div class="row">
			<div class="col">
				<?= view('PNDevworks\FlashMessages\Views\ShowMessage', ['msgChannel' => 'adminPanel']) ?>
				<form action="<?= route_to('pnd_admin_delete', $table, $row['id']) ?>" method="POST">
					Are you sure you want to delete this record?<br />
					<form action="<?= route_to('pnd_admin_delete', $table, $row['id']) ?>" method="POST">
						<input type="hidden" name="confirm" value="yes">
						<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>Yes</button>
						<a class="btn btn-secondary" href="<?= route_to('pnd_admin_index', $table, 1) ?>"><i class="fa fa-times"></i> No</a>
					</form>
					<br />
				</form>
				<?php foreach ($fields as $field) : ?>
					<div class="form-group row">
						<label for="<?= $field ?>" class="col-sm-3 col-form-label"><?= htmlspecialchars($field ?? '') ?></label>
						<div class="col-sm-9">
							<input class="form-control" id="<?= $field ?>" name="<?= $field ?>" readonly type="text" value="<?= htmlspecialchars($row[$field] ?? '') ?>" />
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\scripts'); ?>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\footer') ?>
</body>

</html>