<?php

/**
 * Config-file for navigation bar.
 *
 */
return [

    // Use for styling the menu
    'class' => 'navbar',
    // Here comes the menu strcture
    'items' => [

        // This is a menu item
        'home' => [
            'text' => 'Home',
            'url' => '',
            'title' => 'Me-Page'
        ],
        // This is a menu item
        'reports' => [
            'text' => 'Reports',
            'url' => null,
            'title' => 'Course assignments reports',

            // Here we add the submenu, with some menu items, as part of a existing menu item
            'submenu' => [

                'items' => [

                    // This is a menu item of the submenu
                    'item 1'  => [
                        'text'  => 'kmom01',   
                        'url'   => 'kmom01',  
                        'title' => 'kmom01 report'
                    ],

                    // This is a menu item of the submenu
                    'item 2'  => [
                        'text'  => 'kmom02',   
                        'url'   => 'kmom02',  
                        'title' => 'kmom02 report'
                    ],

                    // This is a menu item of the submenu
                    'item 3'  => [
                        'text'  => 'kmom03',   
                        'url'   => 'kmom03',  
                        'title' => 'kmom03 report'
                    ],
                ],
            ],
        ], 
        // This is a menu item
        'source' => [
            'text' => 'Source',
            'url' => 'source',
            'title' => 'Sourcecode'
        ],
    ],
    // Callback tracing the current selected menu item base on scriptname
    'callback' => function($url) {
if ($url == $this->di->get('request')->getRoute()) {
    return true;
}
},
    // Callback to create the urls
    'create_url' => function($url) {
return $this->di->get('url')->create($url);
},
];
