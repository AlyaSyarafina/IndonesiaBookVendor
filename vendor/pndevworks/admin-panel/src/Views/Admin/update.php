<?php

namespace PNDevworks\AdminPanel\Views\Admin;

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
			max-width: none;
		}

		table.table {
			width: auto;
		}
	</style>
</head>

<body id="update">
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\navbar', ['active' => $table]); ?>
	<div class="container h-full">
		<div class="row">
			<div class="col">
				<?= view('PNDevworks\FlashMessages\Views\ShowMessage', ['msgChannel' => 'adminPanel']) ?>
				<form action="<?= route_to('pnd_admin_update', $table, $row['id']) ?>" method="POST" enctype="multipart/form-data">
					<?php foreach ($fields as $field) : ?>
						<div class="form-group row">
							<label for="<?= $field ?>" class="col-sm-3 col-form-label"><?= htmlspecialchars($field ?? '') ?></label>
							<div class="col-sm-9">
								<?php if (!array_key_exists($field, $options)) : ?>
									<input class="form-control" id="<?= $field ?>" name="<?= $field ?>" disabled type="text" value="<?= htmlspecialchars($row[$field] ?? '') ?>" />
								<?php else : ?>
									<?php if (in_array($options[$field]['type'], ['text', 'email', 'tel', 'number', 'url', 'color'])) : ?>
										<input class="form-control" id="<?= $field ?>" name="<?= $field ?>" type="<?= $options[$field]['type'] ?>" value="<?= htmlspecialchars($row[$field] ?? '') ?>" <?= isset($options[$field]['required']) ? 'required="required"' : '' ?> />
										<?php if (!empty($row[$field]) && $options[$field]['type'] === 'url') : ?>
											<small><a target="_blank" href="<?= htmlspecialchars($row[$field] ?? '') ?>">Open <?= htmlspecialchars($row[$field] ?? '') ?></a></small>
										<?php endif; ?>
									<?php elseif ($options[$field]['type'] === 'password') : ?>
										<input class="form-control" id="<?= $field ?>" name="<?= $field ?>" type="password" value="" <?= key_exists('scope', $options[$field]) && $options[$field]['scope'] === 'self' && $row['id'] !== $userModel->id ? 'disabled="disabled"' : '' ?> />
									<?php elseif ($options[$field]['type'] === 'autoslug') : ?>
										<?php if (array_key_exists('readonly', $options[$field]) && $options[$field]['readonly'] === true) : ?>
											<input class="form-control autoslug" readonly id="<?= $field ?>" name="<?= $field ?>" value="<?= htmlspecialchars($row[$field] ?? '') ?>" type="text" data-autoslug="<?= $options[$field]['source'] ?>" />
										<?php else : ?>
											<input class="form-control autoslug" id="<?= $field ?>" name="<?= $field ?>" value="<?= htmlspecialchars($row[$field] ?? '') ?>" type="text" data-autoslug="<?= $options[$field]['source'] ?>" />
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
														<option value="<?= htmlspecialchars($option_row[$options[$field]['value']] ?? '') ?>" <?= $option_row[$options[$field]['value']] === $row[$field] ? 'selected' : '' ?>>
															<?= htmlspecialchars($option_row[$options[$field]['text']] ?? '') ?>
															(<?= htmlspecialchars($option_row[$options[$field]['value']] ?? '') ?>)
														</option>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php elseif (array_key_exists('options', $options[$field])) : ?>
												<?php foreach ($options[$field]['options'] as $option) : ?>
													<option value="<?= htmlspecialchars($option['value'] ?? '') ?>" <?= $option['value'] === $row[$field] ? 'selected' : '' ?>>
														<?= htmlspecialchars($option['text'] ?? '') ?>
														(<?= htmlspecialchars($option['value'] ?? '') ?>)
													</option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									<?php elseif ($options[$field]['type'] === 'datetime') : ?>
										<input type="text" class="form-control datetimepicker-input" id="<?= $field ?>" name="<?= $field ?>" data-toggle="datetimepicker" data-target="#<?= $field ?>" data-default="<?= htmlspecialchars($row[$field] ?? '') ?>"/>
									<?php elseif ($options[$field]['type'] === 'date') : ?>
										<input type="text" class="form-control datepicker-input" id="<?= $field ?>" name="<?= $field ?>" data-toggle="datetimepicker" data-target="#<?= $field ?>" data-default="<?= htmlspecialchars($row[$field] ?? '') ?>"/>
									<?php elseif ($options[$field]['type'] === 'time') : ?>
										<input type="text" class="form-control timepicker-input" id="<?= $field ?>" name="<?= $field ?>" data-toggle="datetimepicker" data-target="#<?= $field ?>" data-default="<?= htmlspecialchars($row[$field] ?? '') ?>"/>
									<?php elseif ($options[$field]['type'] === 'textarea') : ?>
										<textarea class="form-control" id="<?= $field ?>" name="<?= $field ?>" rows="5"><?= htmlspecialchars($row[$field] ?? '') ?></textarea>
									<?php elseif ($options[$field]['type'] === 'html') : ?>
										<textarea class="form-control html-input" id="<?= $field ?>" name="<?= $field ?>"><?= htmlspecialchars($row[$field] ?? '') ?></textarea>
									<?php elseif ($options[$field]['type'] === 'json') : ?>
										<textarea class="form-control" id="<?= $field ?>" name="<?= $field ?>" rows="5"><?= htmlspecialchars(json_encode(json_decode($row[$field]), JSON_PRETTY_PRINT) ?? '') ?></textarea>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
					<button type="submit" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Update</button>
					<a class="btn btn-secondary" href="<?= route_to('pnd_admin_index', $table, 1) ?>"><i class="fa fa-list"></i> Index</a>
				</form>
				<?php if (in_array('delete', $allow)) : ?>
					<p>
					<form action="<?= route_to('pnd_admin_delete', $table, $row['id']) ?>" method="POST">
						<input type="hidden" name="confirm" value="no">
						<button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
					</form>
					</p>
				<?php endif; ?>
				<?php if (array_key_exists('admin_extras', $options)) : ?>
					<?php if (array_key_exists('message', $options['admin_extras'])) : ?>
						<p class="text-info">
							<i class="fa fa-info" aria-hidden="true"></i>
							<?= htmlspecialchars($options['admin_extras']['message'] ?? '') ?>
						</p>
					<?php endif; ?>
					<?php if (array_key_exists('images', $options['admin_extras'])) : ?>
						<h5>Images</h5>
						<?php
						$images = [];
						$counter = 0;
						while (file_exists('assets/uploads/' . $table . '-images-' . $row['id'] . '-' . $counter . '.' . $options['admin_extras']['images']['target_extension'])) {
							$images[] = [
								'path' => '/assets/uploads/' . $table . '-images-' . $row['id'] . '-' . $counter . '.' . $options['admin_extras']['images']['target_extension'],
								'time' => filemtime('assets/uploads/' . $table . '-images-' . $row['id'] . '-' . $counter . '.' . $options['admin_extras']['images']['target_extension'])
							];
							$counter++;
						}
						?>
						<?php if (sizeof($images) === 0) : ?>
							<p class="text-info">
								<i class="fa fa-info" aria-hidden="true"></i>
								No images uploaded
							</p>
						<?php else : ?>
							<div class="table-responsive">
								<table class="images table">
									<tr>
										<?php foreach ($images as $i => $image) : ?>
											<td>
												<a href="<?= site_url($image['path']) ?>" target="_blank">
													<img class="thumbnail img-thumbnail" alt="Image" src="<?= site_url($image['path']) ?>"><br/>
												</a>
												<form action="<?= route_to('pnd_admin_uploadmanipulate', $table, $row['id']) ?>" method="POST">
													<input type="hidden" name="action" value="delete">
													<input type="hidden" name="index" value="<?= $i ?>">
													<input type="hidden" name="type" value="images">
													<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
												</form>
											</td>
											<?php if ($i < sizeof($images) - 1) : ?>
												<td>
													<form action="<?= route_to('pnd_admin_uploadmanipulate', $table, $row['id']) ?>" method="POST">
														<input type="hidden" name="action" value="swapwithnext">
														<input type="hidden" name="index" value="<?= $i ?>">
														<input type="hidden" name="type" value="images">
														<button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-random" aria-hidden="true"></i> </button>
													</form>
												</td>
											<?php endif; ?>
										<?php endforeach; ?>
									</tr>
								</table>
							</div>
						<?php endif; ?>
						<p>&nbsp;</p>
						<?php if (array_key_exists('max_count', $options['admin_extras']['images']) && sizeof($images) >= $options['admin_extras']['images']['max_count']) : ?>
							<p class="text-info">
								<i class="fa fa-info" aria-hidden="true"></i>
								Cannot upload image anymore since maximum number of images is reached.
							</p>
						<?php else : ?>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#images_upload_modal">
								<i class="fa fa-upload" aria-hidden="true"></i> Upload Image
							</button>
						<?php endif; ?>
					<?php endif; ?>

					<?php if (array_key_exists('files', $options['admin_extras'])) : ?>
						<h5>Files</h5>
						<?php
						$files = [];
						$counter = 0;
						while (file_exists('assets/uploads/' . $table . '-files-' . $row['id'] . '-' . $counter . '.' . $options['admin_extras']['files']['target_extension'])) {
							$files[] = [
								'path' => '/assets/uploads/' . $table . '-files-' . $row['id'] . '-' . $counter . '.' . $options['admin_extras']['files']['target_extension'],
								'time' => filemtime('assets/uploads/' . $table . '-files-' . $row['id'] . '-' . $counter . '.' . $options['admin_extras']['files']['target_extension'])
							];
							$counter++;
						}
						?>
						<?php if (sizeof($files) === 0) : ?>
							<p class="text-info">
								<i class="fa fa-info" aria-hidden="true"></i>
								No files uploaded
							</p>
						<?php else : ?>
							<div class="table-responsive">
								<table class="files table">
									<tr>
										<?php foreach ($files as $i => $file) : ?>
											<td>
												<a href="<?= site_url($file['path']) ?>" target="_blank">
													<i style="margin-bottom:1rem;" class="fas fa-3x fa-file-pdf"></i><br>
													<p>File <?= $i + 1 ?></p>
												</a>
												<form action="<?= route_to('pnd_admin_uploadmanipulate', $table, $row['id']) ?>" method="POST">
													<input type="hidden" name="action" value="delete">
													<input type="hidden" name="index" value="<?= $i ?>">
													<input type="hidden" name="type" value="files">
													<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
												</form>
											</td>
											<?php if ($i < sizeof($files) - 1) : ?>
												<td>
													<form action="<?= route_to('pnd_admin_uploadmanipulate', $table, $row['id']) ?>" method="POST">
														<input type="hidden" name="action" value="swapwithnext">
														<input type="hidden" name="index" value="<?= $i ?>">
														<input type="hidden" name="type" value="files">
														<button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-random" aria-hidden="true"></i> </button>
													</form>
												</td>
											<?php endif; ?>
										<?php endforeach; ?>
									</tr>
								</table>
							</div>
						<?php endif; ?>
						<p>&nbsp;</p>
						<?php if (array_key_exists('max_count', $options['admin_extras']['files']) && sizeof($files) >= $options['admin_extras']['files']['max_count']) : ?>
							<p class="text-info">
								<i class="fa fa-info" aria-hidden="true"></i>
								Cannot upload file anymore since maximum number of files is reached.
							</p>
						<?php else : ?>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#files_upload_modal">
								<i class="fa fa-upload" aria-hidden="true"></i> Upload
							</button>
						<?php endif; ?>
					<?php endif; ?>
					<?php if (array_key_exists('videos', $options['admin_extras'])) : ?>
						<h5>Videos</h5>
						<?php
						$videos = [];
						$counter = 0;
						while (file_exists('assets/uploads/' . $table . '-videos-' . $row['id'] . '-' . $counter . '.' . $options['admin_extras']['videos']['target_extension'])) {
							$videos[] = [
								'path' => '/assets/uploads/' . $table . '-videos-' . $row['id'] . '-' . $counter . '.' . $options['admin_extras']['videos']['target_extension'],
								'time' => filemtime('assets/uploads/' . $table . '-videos-' . $row['id'] . '-' . $counter . '.' . $options['admin_extras']['videos']['target_extension'])
							];
							$counter++;
						}
						?>
						<?php if (sizeof($videos) === 0) : ?>
							<p class="text-info">
								<i class="fa fa-info" aria-hidden="true"></i>
								No videos uploaded
							</p>
						<?php else : ?>
							<div class="table-responsive">
								<table class="videos table">
									<tr>
										<?php foreach ($videos as $i => $video) : ?>
											<td>
												<a href="<?= site_url($video['path']) ?>" target="_blank">
													<i style="margin-bottom:1rem;" class="fas fa-3x fa-film"></i><br>
													<p>Video <?= $i + 1 ?></p>
												</a>
												<form action="<?= route_to('pnd_admin_uploadmanipulate', $table, $row['id']) ?>" method="POST">
													<input type="hidden" name="action" value="delete">
													<input type="hidden" name="index" value="<?= $i ?>">
													<input type="hidden" name="type" value="videos">
													<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
												</form>
											</td>
											<?php if ($i < sizeof($videos) - 1) : ?>
												<td>
													<form action="<?= route_to('pnd_admin_uploadmanipulate', $table, $row['id']) ?>" method="POST">
														<input type="hidden" name="action" value="swapwithnext">
														<input type="hidden" name="index" value="<?= $i ?>">
														<input type="hidden" name="type" value="videos">
														<button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-random" aria-hidden="true"></i> </button>
													</form>
												</td>
											<?php endif; ?>
										<?php endforeach; ?>
									</tr>
								</table>
							</div>
						<?php endif; ?>
						<p>&nbsp;</p>
						<?php if (array_key_exists('max_count', $options['admin_extras']['videos']) && sizeof($videos) >= $options['admin_extras']['videos']['max_count']) : ?>
							<p class="text-info">
								<i class="fa fa-info" aria-hidden="true"></i>
								Cannot upload video anymore since maximum number of videos is reached.
							</p>
						<?php else : ?>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#videos_upload_modal">
								<i class="fa fa-upload" aria-hidden="true"></i> Upload
							</button>
						<?php endif; ?>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php if (array_key_exists('admin_extras', $options) && array_key_exists('images', $options['admin_extras'])) : ?>
		<div class="modal fade" id="images_upload_modal" tabindex="-1" role="dialog" aria-labelledby="images_upload_label" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form action="<?= route_to('pnd_admin_upload', $table, $row['id']) ?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
						<div class="modal-header">
							<h5 class="modal-title" id="images_upload_label">Upload Image</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="image">Upload Image File</label>
								<input type="file" class="form-control-file" id="image" name="userfile">
								<?php if (array_key_exists('allowed_types', $options['admin_extras']['images'])) : ?>
									<br /><small>Allowed types: <?= $options['admin_extras']['images']['allowed_types'] ?></small>
								<?php endif; ?>
								<?php if (array_key_exists('max_size', $options['admin_extras']['images'])) : ?>
									<br /><small>Maximum size: <?= $options['admin_extras']['images']['max_size'] ?> kilobytes</small>
								<?php endif; ?>
								<?php if (array_key_exists('max_width', $options['admin_extras']['images'])) : ?>
									<br /><small>Maximum width: <?= $options['admin_extras']['images']['max_width'] ?> pixels</small>
								<?php endif; ?>
								<?php if (array_key_exists('max_height', $options['admin_extras']['images'])) : ?>
									<br /><small>Maximum height: <?= $options['admin_extras']['images']['max_height'] ?> pixels</small>
								<?php endif; ?>
								<input type="hidden" name="type" value="images" />
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php if (array_key_exists('admin_extras', $options) && array_key_exists('files', $options['admin_extras'])) : ?>
		<div class="modal fade" id="files_upload_modal" tabindex="-1" role="dialog" aria-labelledby="files_upload_label" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form action="<?= route_to('pnd_admin_upload', $table, $row['id']) ?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
						<div class="modal-header">
							<h5 class="modal-title" id="files_upload_label">Upload File</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="file">Upload File</label>
								<input type="file" class="form-control-file" id="image" name="userfile2">
								<?php if (array_key_exists('allowed_types', $options['admin_extras']['files'])) : ?>
									<br /><small>Allowed types: <?= $options['admin_extras']['files']['allowed_types'] ?></small>
								<?php endif; ?>
								<?php if (array_key_exists('max_size', $options['admin_extras']['files'])) : ?>
									<br /><small>Maximum size: <?= $options['admin_extras']['files']['max_size'] ?> kilobytes</small>
								<?php endif; ?>
								<?php if (array_key_exists('max_width', $options['admin_extras']['files'])) : ?>
									<br /><small>Maximum width: <?= $options['admin_extras']['files']['max_width'] ?> pixels</small>
								<?php endif; ?>
								<?php if (array_key_exists('max_height', $options['admin_extras']['files'])) : ?>
									<br /><small>Maximum height: <?= $options['admin_extras']['files']['max_height'] ?> pixels</small>
								<?php endif; ?>
								<input type="hidden" name="type" value="files" />
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php if (array_key_exists('admin_extras', $options) && array_key_exists('videos', $options['admin_extras'])) : ?>
		<div class="modal fade" id="videos_upload_modal" tabindex="-1" role="dialog" aria-labelledby="videos_upload_label" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<form action="<?= route_to('pnd_admin_upload', $table, $row['id']) ?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
						<div class="modal-header">
							<h5 class="modal-title" id="videos_upload_label">Upload File</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="file">Upload Video</label>
								<input type="file" class="form-control-file" id="image" name="userfile3">
								<?php if (array_key_exists('allowed_types', $options['admin_extras']['videos'])) : ?>
									<br /><small>Allowed types: <?= $options['admin_extras']['videos']['allowed_types'] ?></small>
								<?php endif; ?>
								<?php if (array_key_exists('max_size', $options['admin_extras']['videos'])) : ?>
									<br /><small>Maximum size: <?= $options['admin_extras']['videos']['max_size'] ?> kilobytes</small>
								<?php endif; ?>
								<?php if (array_key_exists('max_width', $options['admin_extras']['videos'])) : ?>
									<br /><small>Maximum width: <?= $options['admin_extras']['videos']['max_width'] ?> pixels</small>
								<?php endif; ?>
								<?php if (array_key_exists('max_height', $options['admin_extras']['videos'])) : ?>
									<br /><small>Maximum height: <?= $options['admin_extras']['videos']['max_height'] ?> pixels</small>
								<?php endif; ?>
								<input type="hidden" name="type" value="videos" />
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	<?php endif; ?>
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
			var default_value = $(this).data('default') || null;
			var format = "YYYY-MM-DD HH:mm:ss";
			if (default_value === "0000-00-00 00:00:00") {
				default_value = null;
			}

			if (default_value) {
				default_value = moment(default_value, format);
			}

			$(this).datetimepicker({
				...dateTimePickerDefaultSettings,
				format: format,
				defaultDate: default_value,
			});
		});
		$('.datepicker-input').each(function() {
			var default_value = $(this).data('default') || null;
			var format = "YYYY-MM-DD";
			if (default_value === "0000-00-00") {
				default_value = null;
			}

			if (default_value) {
				default_value = moment(default_value, format);
			}

			$(this).datetimepicker({
				...dateTimePickerDefaultSettings,
				format: format,
				defaultDate: default_value
			});
		});
		$('.timepicker-input').each(function() {
			var default_value = $(this).data('default') || null;
			var format = "HH:mm:ss";
			if (default_value === "00:00:00") {
				default_value = null;
			}
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
								"selector" => ".html-input"
							], $editorDefault['html']['options'])
						) ?>);
	</script>
</body>

</html>