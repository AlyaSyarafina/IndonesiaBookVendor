<?php

namespace PNDevworks\AdminPanel\Views\Admin\Templates;

?>
<!--scripts-->
<script src="<?= route_to("pnd_admin_asset", "/lib/jquery/jquery.min.js") ?>"></script>
<script src="<?= route_to("pnd_admin_asset", "/lib/popper.js/umd/popper.min.js") ?>"></script>
<script src="<?= route_to("pnd_admin_asset", "/lib/bootstrap/js/bootstrap.min.js") ?>"></script>
<?php if (isset($extra_js)) : ?>
	<?php foreach ($extra_js as $js) : ?>
		<script src="<?= route_to("pnd_admin_asset", "/" . $js) ?>"></script>
	<?php endforeach; ?>
<?php endif; ?>
<script>
	function get_slug(text) {
		let slug = '',
			last_c = '';
		text = text.toLowerCase();
		for (let i = 0; i < text.length; i++) {
			let c = text.charAt(i);
			if ((c >= 'a' && c <= 'z') || (c >= '0' && c <= '9')) {
				slug += c;
				last_c = c;
			} else {
				if (last_c != '-') {
					slug += '-';
					last_c = '-';
				}
			}
		}
		return slug;
	}
	$(document).ready(function() {
		$('.autoslug').each(function() {
			let target = $(this);
			let source = $('#' + target.data('autoslug'));
			source.on('keyup change blur', function() {
				target.val(get_slug(source.val()));
			});
		});
	});

	$(document).on('keyup', function(e){
		if( e.which == 191 && $('#search_item').not(':focus')){
			$('#search_item').focus();
		}
	})
</script>
<!--/scripts-->