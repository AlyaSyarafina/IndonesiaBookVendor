<?php

namespace App\Controllers;

class Sitemap extends BaseController
{
	public function index()
	{
		$entries = [];
		$sitemap = \Config('Sitemap')->sitemap;

		$base_entry = [];
		if (array_key_exists('*', $sitemap)) {
			$defaults = $sitemap['*'];
			if (array_key_exists('priority', $defaults)) {
				$base_entry['priority'] = $defaults['priority'];
			}
			if (array_key_exists('lastmod', $defaults)) {
				$base_entry['lastmod'] = $defaults['lastmod'];
			}
			if (array_key_exists('changefreq', $defaults)) {
				$base_entry['changefreq'] = $defaults['changefreq'];
			}
		}

		foreach ($sitemap as $path => $attributes) {
			if ($path === '*') {
				continue;
			}
			$current = $attributes;
			while (is_string($current)) {
				$current = $sitemap[$current];
			}
			$entry = $base_entry;
			$entry['loc'] = site_url($path);
			if (array_key_exists('priority', $current)) {
				$entry['priority'] = $current['priority'];
			}
			if (array_key_exists('lastmod', $current)) {
				$entry['lastmod'] = $current['lastmod'];
			}
			if (array_key_exists('changefreq', $current)) {
				$entry['changefreq'] = $current['changefreq'];
			}
			$entries[] = $entry;
		}

		// Add your own entries here, e.g. news list

		$domtree = new \DOMDocument('1.0', 'UTF-8');

		/** @var \DOMElement */
		$urlsetObj = $domtree->appendChild($domtree->createElement("urlset"));
		$urlsetObj->setAttribute("xmlns", "http://www.sitemaps.org/schemas/sitemap/0.9");

		foreach ($entries as $entry) {
			$urlObj = $domtree->createElement("url");
			$urlObj = $urlsetObj->appendChild($urlObj);

			foreach ($entry as $key => $val) {
				if (!$val) {
					continue;
				}
				$urlProps = $domtree->createElement($key, $val);
				$urlProps = $urlObj->appendChild($urlProps);
			}
		}

		// Using echo to avoid debugbar filter
		$this->response->setContentType('text/xml');
		echo $domtree->saveXML();
	}
}
