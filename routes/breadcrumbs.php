<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push(trans('lang.dashboard'), route('home'));
});
Breadcrumbs::for('flowrate.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(trans('lang.flowrate'), route('flowrate.index'));
});
Breadcrumbs::for('user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push(trans('lang.user'), route('user.index'));
});
