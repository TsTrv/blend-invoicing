<?php 

Breadcrumbs::register('invoices.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard.index');
    $breadcrumbs->push('Invoices', route('invoices.index'));
});

Breadcrumbs::register('invoices.create', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('invoices.index');
    $breadcrumbs->push('New');
});

Breadcrumbs::register('invoices.edit', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('invoices.index');
});
