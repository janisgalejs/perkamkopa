<?php

/**
 * Application debug mode
 * ************************
 * For development: E_ALL
 * For production: 0
 */
const DEBUG_MODE = E_ALL;

/**
 * Application title
 */
const APP_TITLE = 'Simple quiz';

/**
 * Views directory path
 */
const VIEWS_PATH = __DIR__ . '/../views/';

/**
 * Routes for pages
 */
const PAGE_HOME = 'home';
const PAGE_TEST = 'test';
const PAGE_COMPLETE = 'complete';