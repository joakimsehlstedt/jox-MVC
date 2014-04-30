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
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

// Set routing options
$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Home");

    $content = $app->fileContent->get('me.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('theme/page', [
        'content' => $content,
        'byline' => $byline,
        ]);
    //$app->views->addString($content, 'main');   
});

$app->router->add('kmom01', function() use ($app) {

    $app->theme->setTitle("kmom01");

    $content = $app->fileContent->get('kmom01.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('theme/page', [
        'content' => $content,
        'byline' => $byline,
        ]);
});

$app->router->add('kmom02', function() use ($app) {
    $app->theme->setTitle("kmom02");

    $content = $app->fileContent->get('kmom02.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->add('theme/page', [
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

$app->router->add('kmom03', function() use ($app) {

    $app->theme->setTitle("kmom03");
    $app->theme->setVariable('htmlclass', 'green')
               ->setVariable('bodyclass', 'new')
               ->setVariable('wrapperclass', 'grid');

    $content = $app->fileContent->get('kmom03.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $content_short = $app->fileContent->get('loremipsum_short.md');
    $content_short = $app->textFilter->doFilter($content_short, 'shortcode, markdown');

    $content_footer = $app->fileContent->get('footer_test.md');
    $content_footer = $app->textFilter->doFilter($content_footer, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');

    $app->views->addString('! This is the most recent report !', 'flash')
               ->addString($content_short, 'featured-1')
               ->addString($content_short, 'featured-2')
               ->addString($content_short, 'featured-3')
               ->addString($content_footer, 'footer-col-1')
               ->addString($content_footer, 'footer-col-2')
               ->addString($content_footer, 'footer-col-3')
               ->addString($content_footer, 'footer-col-4');

    $app->views->add('theme/page', [
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

    $app->router->handle();

// Navigation
    $app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

// Add extra styling
    $app->theme->addStylesheet('css/comment.css');

// Render the response using theme engine.
    $app->theme->render();
