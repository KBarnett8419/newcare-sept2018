<?php
/**
 *
 * @file __init__.php
 * @description Loads all the file necessary in the inc folder
 *
 * */

// Security check
defined('ABSPATH') || die();

require_once('logger.php');
require_once('migrate.php');
require_once('active-deactive.php');
