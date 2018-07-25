<?php

Breadcrumbs::register('users.index', function ($breadcrumbs) {
    $breadcrumbs->push('Account', route('users.index'));
    $breadcrumbs->push('Users');
});

Breadcrumbs::register('users.edit', function ($breadcrumbs, $breadcrumb) {
    $breadcrumbs->parent('users.index');
});

