<?php

namespace PNDevworks\AdminPanel\Views\Admin\Templates;
?>
<?php foreach (['success', 'info', 'warning', 'danger'] as $id) : ?>
	<?php if (session()->get($id) !== NULL) : ?>
		<div class="alert alert-<?= $id ?>">
			<?= session()->get($id) ?>
		</div>
	<?php endif; ?>
<?php endforeach; ?>