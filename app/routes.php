<?php
	
	$w_routes = array(
		['GET|POST', '/', 'Default#home', 'home'],
		['GET', '/farm', 'Game#displayFarm', 'game_farm'],
		['GET', '/subscription', 'Default#subscription', 'subscription'],
		['GET', '/recovery-password', 'Default#recoveryPassword', 'recovery-password'],
		['GET', '/deconnect', 'Game#logOut', 'game_log_out'],
	);