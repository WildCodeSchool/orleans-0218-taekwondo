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
        ['index', '/events', 'GET'],
        ['adminIndex', '/admin/events', 'GET'],
        ['adminEventDelete', '/admin/event/{id:\d+}/delete', 'POST'],
        ['adminEventCreate', '/admin/event/create', 'POST'],
        ['adminEventUpdateIndex', '/admin/event/{id:\d+}/update', 'POST'],
        ['adminEventUpdate', '/admin/event/{id:\d+}/update/update', 'POST'],
    ],
    'Office' => [
        ['index', '/offices', 'GET'],
    ],
    'Album' => [
        ['index', '/galleries', 'GET'],
        ['gallery', '/gallery/{id:\d+}', 'GET'],
        ['adminCategoriesIndex', '/admin/albums/categories', 'GET'],
        ['adminCategoryCreate', '/admin/albums/category/create', 'POST'],
        ['adminCategoryDelete', '/admin/albums/category/{id:\d+}/delete', 'POST'],
        ['adminCategoryUpdate', '/admin/albums/category/{id:\d+}/update', 'POST'],
        ['adminGalleriesIndex', '/admin/albums/galleries', 'GET'],
        ['adminGalleryCreate', '/admin/albums/gallery/create', 'POST'],
        ['adminGalleryUpdateIndex', '/admin/albums/gallery/{id:\d+}/update', 'GET'],
        ['adminGalleryUpdate', '/admin/albums/gallery/{id:\d+}/update', 'POST'],
        ['adminGalleryDelete', '/admin/albums/gallery/{id:\d+}/delete', 'POST'],
        ['adminGalleryImagesUpload', '/admin/albums/gallery/{id:\d+}/images/upload', 'POST'],
        ['adminGalleryImageDelete', '/admin/albums/gallery/{galleryId:\d+}/image/{id:\d+}/delete', 'POST']
    ],
    'Admin' => [
        ['index', '/admin', 'GET']
    ],
    'BlackBelt' => [
        ['index', '/black-belts', 'GET'],
        ['adminIndex', '/admin/black-belts', 'GET'],
        ['adminBlackBeltDelete', '/admin/black-belt/{id:\d+}/delete', 'POST'],
        ['adminBlackBeltCreate', '/admin/black-belt/create', 'POST']
    ],
    'Presentation' => [
        ['index', '/presentation', 'GET']
    ]

];
