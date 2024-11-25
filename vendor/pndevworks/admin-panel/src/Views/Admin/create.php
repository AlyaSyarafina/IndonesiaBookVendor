<?php

namespace PNDevworks\AdminPanel\Views\Admin;

$editorDefault = config("AdminPanel")->fieldDefaultOptions;

?>
<!DOCTYPE html>
<html>

<head>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\head', ['title' => "Create $table entry", 'extra_css' => ['lib/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css']]); ?>
	<?php helper('text'); ?>
</head>

<body id="create">
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\navbar', ['active' => $table]); ?>
	<div class="container h-full">
		<div class="row">
			<div class="col">
				<?= view('PNDevworks\FlashMessages\Views\ShowMessage', ['msgChannel' => 'adminPanel']) ?>
				<form action="<?= route_to('pnd_admin_create' . $table) ?>" method="POST" enctype="multipart/form-data">
					<?php foreach ($fields as $field) : ?>
						<div class="form-group row">
							<label for="<?= $field ?>" class="col-sm-3 col-form-label"><?= htmlspecialchars($field ?? '') ?></label>
							<div class="col-sm-9">
								<?php if (!array_key_exists($field, $options)) : ?>
									<input class="form-control" id="<?= $field ?>" name="<?= $field ?>" disabled type="text" />
								<?php else : ?>
									<?php if (in_array($options[$field]['type'], ['text', 'email', 'tel', 'number', 'url', 'color'])) : ?>
										<input class="form-control" id="<?= $field ?>" name="<?= $field ?>" type="<?= $options[$field]['type'] ?>" <?= isset($options[$field]['required']) ? 'required="required"' : '' ?> />
									<?php elseif ($options[$field]['type'] === 'password') : ?>
										<input class="form-control" id="<?= $field ?>" name="<?= $field ?>" type="text" value="<?= random_string() ?>" />
									<?php elseif ($options[$field]['type'] === 'autoslug') : ?>
										<?php if (array_key_exists('readonly', $options[$field]) && $options[$field]['readonly'] === true) : ?>
											<input class="form-control autoslug" readonly id="<?= $field ?>" name="<?= $field ?>" type="text" data-autoslug="<?= $options[$field]['source'] ?>" />
										<?php else : ?>
											<input class="form-control autoslug" id="<?= $field ?>" name="<?= $field ?>" type="text" data-autoslug="<?= $options[$field]['source'] ?>" />
										<?php endif; ?>
									<?php elseif ($options[$field]['type'] === 'select') : ?>
										<select class="form-control" name="<?= $field ?>" id="<?= $field ?>">
											<?php if (array_key_exists('allow_null', $options[$field])) : ?>
												<option value=""><i>(Not Applicable)</i></option>
											<?php endif; ?>
											<?php if (array_key_exists('table', $options[$field])) : ?>
												<?php
												$db = \Config\Database::connect();
												$builder = $db->table($options[$field]['table']);
												$builder->orderBy($options[$field]['value'], 'ASC');
												$query = $builder->get();
												$option_rows = $query->getResultArray();
												?>
												<?php foreach ($option_rows as $option_row) : ?>
													<?php if ($option_row[$options[$field]['value']] !== NULL) : ?>
														<option value="<?= htmlspecialchars($option_row[$options[$field]['value']] ?? '') ?>">
															<?= htmlspecialchars($option_row[$options[$field]['text']] ?? '') ?>
															(<?= htmlspecialchars($option_row[$options[$field]['value']] ?? '') ?>)
														</option>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php elseif (array_key_exists('options', $options[$field])) : ?>
												<?php foreach ($options[$field]['options'] as $option) : ?>
													<option value="<?= htmlspecialchars($option['value'] ?? '') ?>">
														<?= htmlspecialchars($option['text'] ?? '') ?>
														(<?= htmlspecialchars($option['value'] ?? '') ?>)
													</option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									<?php elseif ($options[$field]['type'] === 'datetime') : ?>
										<input type="text" class="form-control datetimepicker-input" id="<?= $field ?>" name="<?= $field ?>" data-toggle="datetimepicker" data-target="#<?= $field ?>" data-autofill="<?= $options[$field]['autofill'] ?? false ?>" />
									<?php elseif ($options[$field]['type'] === 'date') : ?>
										<input type="text" class="form-control datepicker-input" id="<?= $field ?>" name="<?= $field ?>" data-toggle="datetimepicker" data-target="#<?= $field ?>" data-autofill="<?= $options[$field]['autofill'] ?? false ?>" />
									<?php elseif ($options[$field]['type'] === 'time') : ?>
										<input type="text" class="form-control timepicker-input" id="<?= $field ?>" name="<?= $field ?>" data-toggle="datetimepicker" data-target="#<?= $field ?>" data-autofill="<?= $options[$field]['autofill'] ?? false ?>" />
									<?php elseif ($options[$field]['type'] === 'textarea') : ?>
										<textarea class="form-control" id="<?= $field ?>" name="<?= $field ?>"></textarea>
									<?php elseif ($options[$field]['type'] === 'html') : ?>
										<textarea class="form-control html-input" id="<?= $field ?>" name="<?= $field ?>"></textarea>
									<?php elseif ($options[$field]['type'] === 'json') : ?>
										<textarea class="form-control" id="<?= $field ?>" name="<?= $field ?>" rows="5"></textarea>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
					<button type="submit" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
					<a class="btn btn-secondary" href="<?= route_to('pnd_admin_index', $table, 1) ?>"><i class="fa fa-list"></i> Index</a>
				</form>
				<?php if (array_key_exists('admin_extras', $options)) : ?>
					<?php if (array_key_exists('message', $options['admin_extras'])) : ?>
						<p class="text-info">
							<i class="fa fa-info" aria-hidden="true"></i>
							<?= htmlspecialchars($options['admin_extras']['message'] ?? '') ?>
						</p>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\scripts', ['extra_js' => ['lib/moment/moment.min.js', 'lib/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js', 'lib/tinymce/tinymce.min.js']]); ?>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\footer') ?>

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

		$('.datetimepicker-input').each(function() {
			var default_value = null;
			var autofill = $(this).data('autofill') || false;
			var format = "YYYY-MM-DD HH:mm:ss";

			if (autofill) {
				default_value = moment(new Date(), format);
			}
			$(this).datetimepicker({
				...dateTimePickerDefaultSettings,
				format: format,
				defaultDate: default_value
			});
		});
		$('.datepicker-input').each(function() {
			var default_value = null;
			var autofill = $(this).data('autofill') || false;
			var format = "YYYY-MM-DD";

			if (autofill) {
				default_value = moment(new Date(), format);
			}

			$(this).datetimepicker({
				...dateTimePickerDefaultSettings,
				format: format,
				defaultDate: default_value
			});
		});
		$('.timepicker-input').each(function() {
			var default_value = null;
			var autofill = $(this).data('autofill') || false;
			var format = "HH:mm:ss";

			if (autofill) {
				default_value = moment(new Date(), format);
			}
			$(this).datetimepicker({
				...dateTimePickerDefaultSettings,
				format: format,
				defaultDate: default_value
			});
		});
		tinymce.init(<?= json_encode(
							array_merge([
								"selector" => ".html-input"
							], $editorDefault['html']['options'])
						) ?>);
	</script>
</body>

</html>