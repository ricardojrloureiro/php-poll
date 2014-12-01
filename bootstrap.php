<?php
session_start();
session_set_cookie_params(0, '/~ei12038/proj', 'gnomo.fe.up.pt');

require 'vendor/autoload.php';
require 'helpers/helpers.php';
require 'helpers/password_hash.php';
require 'helpers/array_column.php';