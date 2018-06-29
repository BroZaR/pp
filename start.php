<?php
session_start();

if ( isset( $_SESSION[ 'user' ][ 'right' ] ) && $_SESSION[ 'user' ][ 'right' ] == 'teacher' ) {
	$way_to_controller = 'backend/controllers';
	$way_to_models = 'backend/models';
} else {
	$way_to_controller = 'frontend/controllers';
	$way_to_models = 'frontend/models';
}

set_include_path( get_include_path() .
                  PATH_SEPARATOR . 'core' .
                  PATH_SEPARATOR . $way_to_controller .
                  PATH_SEPARATOR . $way_to_models .
                  PATH_SEPARATOR . 'common/models' .
                  PATH_SEPARATOR . 'common/config' .
                  PATH_SEPARATOR . 'common/db'
);
spl_autoload_extensions( '.php' );
spl_autoload_register();

define( 'NAME' , 'pp.local/' );
define( 'DIR' , 'D:\PhpProject\pp.local\\' );
define( 'DIR_USER' , DIR . 'frontend\views\\' );
define( 'DIR_ADMIN' , DIR . 'backend\views\\' );
define( 'MAIN_LAYOUT' , 'main' );
define( 'HOST' , 'localhost' );
define( 'USER' , 'root' );
define( 'PASSWORD' , '' );
define( 'BD' , 'pp' );