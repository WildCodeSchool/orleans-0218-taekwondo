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
        ['contactCreate', '/contact/create', 'POST'],

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
        ['adminIndex', '/admin/offices', 'GET'],
        ['adminOfficeUpdate', '/admin/office/{id:\d+}/update', ['GET', 'POST']],
        ['adminOfficeDelete', '/admin/office/{id:\d+}/delete', 'POST'],
        ['adminOfficeCreate', '/admin/office/create', 'POST'],
        ['adminTeacherIndex', '/admin/teachers', 'GET'],
        ['adminTeacherUpdate', '/admin/teacher/{id:\d+}/update', ['GET', 'POST']],
        ['adminTeacherDelete', '/admin/teacher/{id:\d+}/delete', 'POST'],
        ['adminTeacherCreate', '/admin/teacher/create', 'POST'],

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
        ['adminBlackBeltUpdate', '/admin/black-belt/{id:\d+}/update', ['GET', 'POST']],
        ['adminBlackBeltDelete', '/admin/black-belt/{id:\d+}/delete', 'POST'],
        ['adminBlackBeltCreate', '/admin/black-belt/create', 'POST']
    ],

    'Register' => [
        ['index', '/register', 'GET'],
        ],

    'Footer' => [
        ['adminIndex', '/admin/footer', 'GET'],
        ['adminFooterDelete', '/admin/Footer/{id:\d+}/delete', 'POST'],
        ['adminFooterCreate', '/admin/link/create', 'POST']

    ],
    'Presentation' => [
        ['index', '/presentation', 'GET'],
    ]
];
