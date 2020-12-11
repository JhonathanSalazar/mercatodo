<?php


namespace App\Constants;

class Permissions
{
    /**
     * Products permissions.
     */
    const VIEW_PRODUCTS = 'View products';
    const CREATE_PRODUCTS = 'Create products';
    const UPDATE_PRODUCTS = 'Update products';
    const DELETE_PRODUCTS = 'Delete products';

    /**
     * Users permissions.
     */
    const VIEW_USERS = 'View users';
    const UPDATE_USERS = 'Update users';

    /**
     * Report permissions.
     */
    const VIEW_REPORTS = 'View reports';
    const DOWNLOAD_REPORTS = 'Download reports';
    const DELETE_REPORTS = 'Delete reports';

    /**
     * Export and import permissions.
     */
    const EXPORT = 'Exports';
    const IMPORT = 'Import';
}
