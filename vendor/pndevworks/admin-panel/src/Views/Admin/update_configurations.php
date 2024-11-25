<?php

namespace PNDevworks\AdminPanel\Views\Admin;

$facebookModel = model('\App\Models\FacebookModel');
$editorDefault = config("AdminPanel")->fieldDefaultOptions;
?>
<!DOCTYPE html>
<html>

<head>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\head', ['title' => "Update $table entry", 'extra_css' => ['lib/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css']]); ?>
	<style>
		img.thumbnail {
			height: 10rem;
			width: auto;
		}

		.facebook-login {
			width: 250px;
		}
	</style>
</head>

<body id="update">
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\navbar', ['active' => $table]); ?>
	<div class="container">
		<div class="row">
			<div class="col">
				<?= view('PNDevworks\FlashMessages\Views\ShowMessage', ['msgChannel' => 'adminPanel']) ?>
				<form action="<?= route_to('pnd_admin_update', $table, $row['id']) ?>" method="POST">
					<div class="form-group row">
						<label for="<?= $row['id'] ?>" class="col-sm-5 col-form-label"><?= htmlspecialchars($row['name']) ?></label>
						<div class="col-sm-7">
							<input class="form-control" id="<?= $row['id'] ?>" name="<?= $row['id'] ?>" <?= $row['input_attributes'] ?> value="<?= $row['value'] ?>" />
						</div>
					</div>
					<button type="submit" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
					<a class="btn btn-secondary" href="<?= route_to('pnd_admin_index', $table, 1) ?>"><i class="fa fa-list"></i> Index</a>
					<?php if ($row['id'] === 'custom_facebook_accesstoken' && $row['value'] !== '') : ?>
						<a class="btn btn-danger" href="<?= site_url('admin/panel/custom_facebook/disconnect') ?>"><i class="fa fa-sign-out"></i> Disconnect from Facebook</a>
					<?php endif ?>
				</form>
			</div>
		</div>
	</div>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\scripts', ['extra_js' => ['lib/moment/moment.min.js', 'lib/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js', 'lib/tinymce/tinymce.min.js']]); ?>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\footer'); ?>

	<script>
		let dateTimePickerDefaultSettings = {
			icons: {
				time: 'far fa-clock',
				date: 'fas fa-calendar',
				up: 'fa fa-arrow-up',
				down: 'fa fa-arrow-down',
				previous: 'fa fa-chevron-left',
				next: 'fa fa-chevron-right',
				today: 'far fa-calendar-check',
				clear: 'far fa-trash-alt',
				close: 'fa fa-times'
			}
		}

		$('[ui=datetimepicker]').each(function() {
			var default_value = $(this).val();
			var format = 'YYYY-MM-DD HH:mm:ss';

			if (default_value === "0000-00-00 00:00:00") {
				default_value = null;
			}

			$(this).addClass('datetimepicker-input');

			if (default_value) {
				default_value = moment(default_value, format);
			}


			$(this).datetimepicker({
				...dateTimePickerDefaultSettings,
				format: format,
				defaultDate: default_value
			});
		});

		$('[ui=datepicker]').each(function() {
			var default_value = $(this).val();
			var format = "YYYY-MM-DD";
			if (default_value === "0000-00-00") {
				default_value = null;
			}
			$(this).addClass('datepicker-input');

			if (default_value) {
				default_value = moment(default_value, format);
			}

			$(this).datetimepicker({
				...dateTimePickerDefaultSettings,
				format: format,
				defaultDate: default_value
			});
		});

		$('[ui=timepicker]').each(function() {
			var default_value = $(this).val();
			var format = "HH:mm:ss";
			if (default_value === "00:00:00") {
				default_value = null;
			}
			$(this).addClass('timepicker-input');

			if (default_value) {
				default_value = moment(default_value, format);
			}

			$(this).datetimepicker({
				...dateTimePickerDefaultSettings,
				format: format,
				defaultDate: default_value
			});
		});

		tinymce.init(<?= json_encode(
							array_merge([
								"selector" => "[ui=htmleditor]"
							], $editorDefault['html']['options'])
						) ?>);
	</script>
</body>

</html>