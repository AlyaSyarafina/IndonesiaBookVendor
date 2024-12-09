<?php

namespace PNDevworks\AdminPanel\Views\Admin;
$request = \Config\Services::request();
?>
<!DOCTYPE html>
<html>

<head>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\head', ['title' => "Index of $table"]); ?>
</head>

<body id="index">
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\navbar', ['active' => $table]); ?>
	<div class="container h-full">
		<div class="row">
			<div class="col">
				<?= view('PNDevworks\FlashMessages\Views\ShowMessage', ['msgChannel' => 'adminPanel']) ?>
				
				<?php if (array_key_exists('search', $extra['index']) && $extra['index']['search']['enabled'] != false) : ?>
					<form class="my-3" method="get" action="<?= route_to('pnd_admin_index', $table, 1) ?>">
						<div class=" form-group input-group col-xs-4">
							<input class="form-control" id="search_item" name="search_item" type="search" placeholder="search" value="<?= isset($_GET['search_item'])? htmlentities($_GET['search_item'])  : ''?>">
							<div class="input-group-append">
								<button class="btn btn-primary">
									Search
								</button>
							</div>
						</div>
					</form>
					<p> <small>Press "/" to highlight the searchbar</small> </p>
				<?php endif; ?>

				<?php if ($self_group_by_exists && (!empty($self_group_by_data))) : ?>
					<?php if (array_key_exists('options', $self_group_by_data)) : ?>
						<form>
							<h2>Filter By</h2>
							<div class="form-group row">
								<div class="col-sm-4">
									<select class="form-control" name="self_group_by_col">
										<?php foreach ($self_group_by_data['options'] as $option) : ?>
											<option value="<?= $option ?>" <?= ($option === $self_group_by_col) ? 'selected' : '' ?>><?= $option ?></option>
										<?php endforeach ?>
									</select>
								</div>
								<div class="col-sm-2">
									<input class="btn btn-primary" type="submit" value="Filter">
								</div>
							</div>
						</form>
					<?php endif ?>
					<table class="table table-striped table-hover table-responsive">
						<thead>
							<tr>
								<th scope="col"><?= $self_group_by_data['col'] ?></th>
								<th scope="col">count_<?= $self_group_by_data['counter'] ?></th>
								<th scope="col">view</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($rows as $row) : ?>
								<tr>
									<td><?= $row->{$self_group_by_data['col']} ?></td>
									<td><?= $row->{'count_' . $self_group_by_data['counter']} ?></td>
									<td><a class="btn btn-primary" href="<?= route_to('pnd_admin_index', $table, 1) . ('?self_group_by=' . $self_group_by_data['col'] . '&self_group_by_value=' . $row->{$self_group_by_data['col']}) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php elseif ($group_by_exists && $table_group_by !== $table) : ?>
					<table class="table table-striped table-hover table-responsive">
						<thead>
							<tr>
								<th scope="col"><?= $label ?></th>
								<th scope="col">total</th>
								<th scope="col">view</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($rows as $row) : ?>
								<tr>
									<td><?= $row->$label ?></td>
									<td><?= $row->total ?></td>
									<td><a class="btn btn-primary" href="<?= route_to('pnd_admin_index', $table, 1) . ('?group_by=' . $group_by_next . '&' . $id_table . '=' . $row->id) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<p><b>Total: <?php echo $totals; ?> records<b></p>
					<?php if ($total_page > 1) : ?>
						<nav aria-label="Page navigation d-flex justify-content-center">
							<ul class="pagination">
								<li class="page-item <?= $from === "1" ? 'disabled' : '' ?>">
									<a class="page-link" href="<?= route_to('pnd_admin_index', $table, ($from - 1)) . ('?group_by=' . $table_group_by . ($current_no_group_by > 0 ? ($previous_id_table !== '' ? '&' . $previous_id_table . '=' . $this->input->get($previous_id_table) : '') : '')) ?>" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
										<span class="sr-only">Previous</span>
									</a>
								</li>
								<?php for ($i = 1; $i <= $total_page; $i++) : ?>
									<li class="page-item <?= $from === "$i" ? 'active ' : '' ?><?= $i > 10 ? 'd-none' : '' ?>" id="page<?= $i ?>"><a class="page-link" href=<?= route_to('pnd_admin_index', $table, $i . '?group_by=' . $table_group_by . ($current_no_group_by > 0 ? ($previous_id_table !== '' ? '&' . $previous_id_table . '=' . $this->input->get($previous_id_table) : '') : '')) ?>><?= $i ?></a></li>
								<?php endfor; ?>
								<li class="page-item <?= $from === "$total_page" ? 'disabled' : '' ?>">
									<a class="page-link" href="<?= route_to('pnd_admin_index', $table, ($from + 1)) . ('?group_by=' . $table_group_by . ($current_no_group_by > 0 ? ($previous_id_table !== '' ? '&' . $previous_id_table . '=' . $this->input->get($previous_id_table) : '') : '')) ?>" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
										<span class="sr-only">Next</span>
									</a>
								</li>
							</ul>
						</nav>
					<?php endif; ?>
				<?php else : ?>
					<table class="table table-striped table-hover table-responsive">
						<thead>
							<tr>
								<?php foreach ($cols as $col) : ?>
									<th scope="col"><?= $col ?></th>
								<?php endforeach; ?>
								<?php if (in_array('update', $allow)) : ?>
									<th scope="col">view/edit</th>
								<?php endif; ?>
								<?php if (in_array('delete', $allow)) : ?>
									<th scope="col">delete</th>
								<?php endif; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($rows as $row) : ?>
								<tr>
									<?php foreach ($cols as $i => $col) : ?>
										<?php if ($i === 0) : ?>
											<th scope="row">
												<?= htmlspecialchars($row[$cols[$i]] ?? '') ?>
												<?php if (array_key_exists($cols[$i], $links) && !empty($row[$cols[$i]])) : ?>
													/ <?= htmlspecialchars($row[$links[$cols[$i]]['table'] . '_' . $links[$cols[$i]]['label']] ?? '') ?>
													<a class="btn btn-secondary" href="<?= route_to('pnd_admin_update', $links[$cols[$i]]['table'], $row[$cols[$i]]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
												<?php endif; ?>
											</th>
										<?php else : ?><td>
												<?= htmlspecialchars($row[$cols[$i]] ?? '') ?>
												<?php if (array_key_exists($cols[$i], $links) && !empty($row[$cols[$i]])) : ?>
													/ <?= htmlspecialchars($row[$links[$cols[$i]]['table'] . '_' . $links[$cols[$i]]['label']] ?? '') ?>
													<a class="btn btn-secondary" href="<?= route_to('pnd_admin_update', $links[$cols[$i]]['table'], $row[$cols[$i]]) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a>
												<?php endif; ?>
											</td>
										<?php endif; ?>
									<?php endforeach; ?>
									<?php if (in_array('update', $allow)) : ?>
										<td><a class="btn btn-primary" href="<?= route_to('pnd_admin_update', $table, $row['id']) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
									<?php endif; ?>
									<?php if (in_array('delete', $allow)) : ?>
										<td>
											<form action="<?= route_to('pnd_admin_delete', $table, $row['id']) ?>" method="POST">
												<input type="hidden" name="confirm" value="no">
												<button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
											</form>
										</td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>
				<?php if ($total_page > 1) : ?>
					<nav aria-label="Page navigation">
						<ul class="pagination">
							<li class="page-item <?= $from === "1" ? 'disabled' : '' ?>">
								<a class="page-link" href="<?= route_to('pnd_admin_index', $table, (1)) . ('?' . $request->getServer('QUERY_STRING')) ?>" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
									<span class="sr-only">First</span>
								</a>
							</li>
							<li class="page-item <?= $from === "1" ? 'disabled' : '' ?>">
								<a class="page-link" href="<?= route_to('pnd_admin_index', $table, ($from - 1)) . ('?' . $request->getServer('QUERY_STRING')) ?>" aria-label="Previous">
									<span aria-hidden="true">&lt;</span>
									<span class="sr-only">Previous</span>
								</a>
							</li>
							<?php
							// Pagination Stepper
							if ($total_page > 10) {
								$pagination_start = min(max(1, $from - 3), ($total_page - 10));
								$pagination_stop = $pagination_start + $pagination_steps;
							} else {
								$pagination_start = 1;
								$pagination_stop = $total_page;
							}
							?>
							<?php for ($i = $pagination_start; $i <= $pagination_stop; $i++) : ?>
								<li class="page-item <?= $from === "$i" ? 'active ' : '' ?>" id="page<?= $i ?>"><a class="page-link" href=<?= route_to('pnd_admin_index', $table, $i) . ('?' . $request->getServer('QUERY_STRING')) ?>><?= $i ?></a></li>
							<?php endfor; ?>
							<li class="page-item <?= $from === "$total_page" ? 'disabled' : '' ?>">
								<a class="page-link" href="<?= route_to('pnd_admin_index', $table, ($from + 1)) . '?' . $request->getServer('QUERY_STRING') ?>" aria-label="Next">
									<span aria-hidden="true">&gt;</span>
									<span class="sr-only">Next</span>
								</a>
							</li>
							<li class="page-item <?= $from === "$total_page" ? 'disabled' : '' ?>">
								<a class="page-link" href="<?= route_to('pnd_admin_index', $table, ($total_page)) . '?' . $request->getServer('QUERY_STRING') ?>" aria-label="Last">
									<span aria-hidden="true">&raquo;</span>
									<span class="sr-only">Last</span>
								</a>
							</li>
						</ul>
					</nav>
				<?php endif; ?>
				<p>Total: <b><?= $total_records; ?></b> records and served in <b><?= $total_page ?></b> pages.</p>
				<?php if (in_array('create', $allow)) : ?>
					<a class="btn btn-primary" href="<?= route_to('pnd_admin_create', $table) ?>"><i class="fa fa-plus" aria-hidden="true"></i> Create new entry</a>
				<?php endif; ?>
				<?php if (in_array('csv', $allow)) : ?>
					<a class="btn btn-primary" href="<?= route_to('pnd_admin_csv', $table) ?>"><i class="fa fa-file" aria-hidden="true"></i> Export to CSV</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\scripts'); ?>
	<?php echo view('PNDevworks\AdminPanel\Views\Admin\Templates\footer') ?>
</body>

</html>