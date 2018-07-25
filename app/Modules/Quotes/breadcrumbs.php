<?php 

Breadcrumbs::register('quotes.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard.index');
    $breadcrumbs->push('Quotes', route('quotes.index'));
});

Breadcrumbs::register('quotes.create', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('quotes.index');
    $breadcrumbs->push('New');
});

Breadcrumbs::register('quotes.edit', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('quotes.index');
});
