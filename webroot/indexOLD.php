<?php

/**
 * This is a Anax pagecontroller.
 *
 */
// Get environment & autoloader and the $app-object.
require __DIR__ . '/config.php';

// Create services and inject into the app. 
$di = new \Anax\DI\CDIFactoryDefault();

$di->set('CommentController', function() use ($di) {
    $controller = new Phpmvc\Comment\CommentController();
    $controller->setDI($di);
    return $controller;
});

$app = new \Anax\Kernel\CAnax($di);

// Set configuration for theme
$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');

// Set routing options
$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Home");

    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
});

$app->router->add('kmom01', function() use ($app) {

    $app->theme->setTitle("kmom01");

    $content = $app->fileContent->get('kmom01.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);
});

$app->router->add('source', function() use ($app) {
    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Redovisning");

    $source = new \Mos\Source\CSource([
        'secure_dir' => '..',
        'base_dir' => '..',
        'add_ignore' => ['.htaccess'],
    ]);

    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);
});

$app->router->add('kmom02', function() use ($app) {
    $app->theme->setTitle("kmom02");

    $content = $app->fileContent->get('kmom02.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
    ]);

    $app->dispatcher->forward([
        'controller' => 'comment',
        'action' => 'view',
        'params' => ['kmom02'],
    ]);

    $app->views->add('comment/form', [
        'mail' => null,
        'web' => null,
        'name' => null,
        'content' => null,
        'output' => null,
        'key' => 'kmom02',
    ]);
});

$app->router->handle();

// Navigation
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

// Add extra styling
$app->theme->addStylesheet('css/comment.css');

// Render the response using theme engine.
$app->theme->render();
