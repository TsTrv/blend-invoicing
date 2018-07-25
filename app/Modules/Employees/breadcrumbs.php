<?php 

Breadcrumbs::register('employees.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard.index');
    $breadcrumbs->push('Employees', route('employees.index'));
});

Breadcrumbs::register('employees.create', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('employees.index');
    $breadcrumbs->push('New');
});

Breadcrumbs::register('employees.edit', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('employees.index');
    $breadcrumbs->push($breadcrumb['name'], route('employees.show', $breadcrumb['id']));
});

Breadcrumbs::register('employees.show', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('employees.index');
    $breadcrumbs->push($breadcrumb['name'], route('employees.show', $breadcrumb['id']));
});