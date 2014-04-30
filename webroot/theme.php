<?php
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 

// Configure theme
$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');

// Prepare routes
$app->router->add('', function() use ($app) {
    $app->theme->setTitle("Home");

    $content = $app->fileContent->get('loremipsum.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $content_short = $app->fileContent->get('loremipsum_short.md');
    $content_short = $app->textFilter->doFilter($content_short, 'shortcode, markdown');

    $app->views->addString($content_short, 'flash')
               ->addString($content_short, 'featured-1')
               ->addString($content_short, 'featured-2')
               ->addString($content_short, 'featured-3')
               ->addString($content, 'main')
               ->addString($content, 'sidebar')
               ->addString($content_short, 'triptych-1')
               ->addString($content_short, 'triptych-2')
               ->addString($content_short, 'triptych-3')
               ->addString($content_short, 'footer-col-1')
               ->addString($content_short, 'footer-col-2')
               ->addString($content_short, 'footer-col-3')
               ->addString($content_short, 'footer-col-4');
});

$app->router->add('regioner', function() use ($app) {
 
    $app->theme->setTitle("Regions");
 
    $app->views->addString('flash', 'flash')
               ->addString('featured-1', 'featured-1')
               ->addString('featured-2', 'featured-2')
               ->addString('featured-3', 'featured-3')
               ->addString('main', 'main')
               ->addString('sidebar', 'sidebar')
               ->addString('triptych-1', 'triptych-1')
               ->addString('triptych-2', 'triptych-2')
               ->addString('triptych-3', 'triptych-3')
               ->addString('footer-col-1', 'footer-col-1')
               ->addString('footer-col-2', 'footer-col-2')
               ->addString('footer-col-3', 'footer-col-3')
               ->addString('footer-col-4', 'footer-col-4');
 
});

$app->router->handle();

// Navigation
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

// Render the response using theme engine.
$app->theme->render();