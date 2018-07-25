<?php

Breadcrumbs::register('timelogs.index', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('dashboard.index'));
    $breadcrumbs->push('Time Log');
});

Breadcrumbs::register('timelogs.create', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('timelogs.index');
    $breadcrumbs->push('New');
});

Breadcrumbs::register('timelogs.edit', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('timelogs.index');
});



