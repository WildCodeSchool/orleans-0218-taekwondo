<?php
/**
 * This file hold all routes definitions.
 *
 * PHP version 7
 *
 * @author   WCS <contact@wildcodeschool.fr>
 *
 * @link     https://github.com/WildCodeSchool/simple-mvc
 */

$routes = [
    'Home' => [
        ['index', '/', 'GET'],
    ],
    'Event' => [
        ['index', '/events' , 'GET'],
    ],
    'Album' => [
        ['index', '/galleries', 'GET'],
        ['gallery', '/gallery/{id:\d+}', 'GET'],
        ['adminCategoriesIndex', '/admin/albums/categories', 'GET'],
        ['adminCategoryCreate', '/admin/albums/category/create', 'POST'],
        ['adminCategoryDelete', '/admin/albums/category/delete', 'POST'],
        ['adminCategoryUpdate', '/admin/albums/category/update', 'POST']
    ],
    'Admin' => [
        ['index', '/admin', 'GET']
    ]
];
