<?php

Breadcrumbs::register('projects.index', function ($breadcrumbs) {
    $breadcrumbs->push('Settings');
    $breadcrumbs->push('Projects');
});

Breadcrumbs::register('projects.create', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('projects.index');
    $breadcrumbs->push('New');
});

Breadcrumbs::register('projects.edit', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('projects.index');
    $breadcrumbs->push($breadcrumb['name'], route('projects.edit', $breadcrumb['id']));
});