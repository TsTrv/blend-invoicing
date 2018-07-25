<?php
Breadcrumbs::register('currencies.index', function ($breadcrumbs) {
	$breadcrumbs->push('Settings');
    $breadcrumbs->push('Currencies', route('currencies.index'));
});
