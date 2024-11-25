<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to DNArtworks CodeIgniter 4 Starter!</title>
	<?= view_cell('MetaHeaderCell') ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<h1>DNArtworks CI4 Starter</h1>
	<p>
		Welcome, fellow developers, to DNArtworks' CodeIgniter
		<?= CodeIgniter\CodeIgniter::CI_VERSION ?> template. You may have read
		the instructions in <code>README.md</code> and I'm sure you want to
		start as fast as possible. Unfortunately, client requirements are
		growing overtime, and you may want to take care or at least take note
		of the following.
	</p>
	<h2>Sitemap and Meta Tags</h2>
	<p>
		Most websites should have <code>sitemap.xml</code> for search engine to
		understand the structure. Also, meta tags like og and twitter are useful
		for sharing the webpage in social media.
	</p>
	<p>
		Therefore, there are implementations that you need to be aware of, and
		adjust to your website:
		<ol>
			<li>
				<code>meta_header.php</code> and <code>MetaHeaderCell.php</code>
				under <code>app/Cells</code>: this is the <a href="https://codeigniter4.github.io/CodeIgniter4/outgoing/view_cells.html">View Cell</a>
				for automatically attaching the proper meta tags in each page.
				To use it, code <code>&lt;?= view_cell('MetaHeaderCell') ?&gt;</code>
				within your <code>&lt;head&gt;</code> tag. Note that for each
				page that implements this, it has to be configured for that
				page. Otherwise, an exception will occur to warn you.
			</li>
			<li>
				<code>app/Config/Sitemap.php</code> is the code where you
				configure the sitemap data. It is a associative array of:
				<ul>
					<li>
						<code>'*'</code> if you want to have default values
						for all pages
					</li>
					<li>
						<i>Any other keys</i> refers to the <code>uri_string()</code>.
					</li>
					<li>
						In the second level, you can have:
						<ul>
							<li><code>meta_title</code> (for social media)</li>
							<li><code>meta_description</code> (for social media)</li>
							<li><code>meta_image</code> (for social media)</li>
							<li><code>priority</code> (for sitemap)</li>
							<li><code>lastmod</code> (for sitemap)</li>
							<li><code>weekly</code> (for sitemap)</li>
						</ul>
					</li>
				</ul>
			</li>
			<li>
				<code>app/Controllers/Sitemap.php</code> is the controller to
				show <code>sitemap.xml</code>. You can customize this code to
				add more mappings.
			</li>
		</ol>
	</p>
	<p>That's it for now.</p>
</body>
</html>
