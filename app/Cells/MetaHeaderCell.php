<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class MetaHeaderCell extends Cell
{
	private $url = null;
	protected $metaTitle = null;
	protected $metaDescription = null;
	protected $metaImage = null;

	public function mount(): void
	{
		$sitemap = \Config('Sitemap')->sitemap;
		if (array_key_exists('*', $sitemap)) {
			$defaults = $sitemap['*'];
			if (array_key_exists('meta_title', $defaults)) {
				if ($this->metaTitle == null) $this->metaTitle = $defaults['meta_title'];
			}
			if (array_key_exists('meta_description', $defaults)) {
				if ($this->metaDescription == null) $this->metaDescription = $defaults['meta_description'];
			}
			if (array_key_exists('meta_image', $defaults)) {
				if ($this->metaImage == null) $this->metaImage = $defaults['meta_image'];
			}
		}
		if (array_key_exists(uri_string(), $sitemap)) {
			$current = $sitemap[uri_string()];
			// Hyperlink to other sitemap data
			while (is_string($current)) {
				$current = $sitemap[$current];
			}
			if (array_key_exists('meta_title', $current)) {
				$this->metaTitle = $current['meta_title'];
			}
			if (array_key_exists('meta_description', $current)) {
				$this->metaDescription = $current['meta_description'];
			}
			if (array_key_exists('meta_image', $current)) {
				$this->metaImage = $current['meta_image'];
			}
		} else {
			throw new \Exception(uri_string() . ' is not registered. Developer please check Config/Sitemap.php');
		}
		$this->url = current_url();

	}

	public function getUrlProperty() {
		return $this->url;
	}
	public function getMetaDescriptionProperty(): ?string {
		return $this->metaDescription;
	}
	public function getMetaTitleProperty() {
		return $this->metaTitle;
	}
	public function getMetaImageProperty() {
		return base_url($this->metaImage);
	}
}
