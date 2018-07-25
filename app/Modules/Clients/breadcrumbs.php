<?php 

Breadcrumbs::register('clients.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard.index');
    $breadcrumbs->push('Clients', route('clients.index'));
});

Breadcrumbs::register('clients.show', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('clients.index');
    $breadcrumbs->push($breadcrumb['name'], route('clients.show', $breadcrumb['id']));
});

Breadcrumbs::register('clients.create', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('clients.index');
    $breadcrumbs->push('New');
});

Breadcrumbs::register('clients.edit', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('clients.index');
    $breadcrumbs->push($breadcrumb['name'], route('clients.show', $breadcrumb['id']));
});
