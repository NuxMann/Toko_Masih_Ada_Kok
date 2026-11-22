<?php defined('BASEPATH') OR exit('No direct script access allowed');
$config['midtrans_server_key'] = getenv('MIDTRANS_SERVER_KEY') ?: '';
$config['midtrans_client_key'] = getenv('MIDTRANS_CLIENT_KEY') ?: '';
$config['midtrans_is_production'] = filter_var(getenv('MIDTRANS_IS_PRODUCTION') ?: 'false', FILTER_VALIDATE_BOOLEAN);
