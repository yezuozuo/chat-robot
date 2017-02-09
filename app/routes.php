<?php

$app->get('/', function ($request, $response) {
    return $this->view->render($response, 'index.twig');
});

$app->get('/api/chat','App\Controllers\ChatController:index');

$app->get('/test/split','App\Controllers\TestController:split');
$app->get('/test/autolink','App\Controllers\TestController:autolink');

/** lab **/
$app->get('/lab/db', 'HomeController:db');

$app->get('/lab/contact', function ($request, $response) {
    return $this->view->render($response, '/module/contacts.twig');
});

$app->get('/lab/head', function ($request, $response) {
    return $this->view->render($response, '/module/head.twig');
});

$app->get('/lab/echarts', function ($request, $response) {
    return $this->view->render($response, '/module/charts/echarts.twig');
});

$app->get('/lab/echarts/bar', function ($request, $response) {
    return $this->view->render($response, '/module/charts/bar.twig');
});

$app->get('/lab/echarts/line', function ($request, $response) {
    return $this->view->render($response, '/module/charts/line.twig');
});

$app->get('/lab/echarts/pie', function ($request, $response) {
    return $this->view->render($response, '/module/charts/pie.twig');
});

$app->get('/lab/table', function ($request, $response) {
    return $this->view->render($response, '/module/table.twig');
});

$app->get('/lab/ui/tab', function ($request, $response) {
    return $this->view->render($response, '/module/ui/tab.twig');
});

$app->get('/lab/ui/modal', function ($request, $response) {
    return $this->view->render($response, '/module/ui/modal.twig');
});

$app->get('/lab/ui/pnotify', function ($request, $response) {
    return $this->view->render($response, '/module/ui/pnotify.twig');
});

$app->get('/lab/ui/notify', function ($request, $response) {
    return $this->view->render($response, '/module/ui/notify.twig');
});

$app->get('/lab/ui/calendar', function ($request, $response) {
    return $this->view->render($response, '/module/ui/calendar.twig');
});

$app->get('/lab/form/wizard', function ($request, $response) {
    return $this->view->render($response, '/module/form/wizard.twig');
});

$app->get('/lab/form/validation', function ($request, $response) {
    return $this->view->render($response, '/module/form/validation.twig');
});

$app->get('/lab/form/textareas', function ($request, $response) {
    return $this->view->render($response, '/module/form/textareas.twig');
});

$app->get('/lab/form/inputmask', function ($request, $response) {
    return $this->view->render($response, '/module/form/inputmask.twig');
});

$app->get('/lab/form/datepicker', function ($request, $response) {
    return $this->view->render($response, '/module/form/datepicker.twig');
});
/** end lab **/