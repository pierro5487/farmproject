<?php
	
	$w_routes = array(
		['GET|POST', '/', 'Default#home', 'home'],
		['GET', '/farm', 'Game#displayFarm', 'game_farm'],
		['GET|POST', '/subscription', 'Default#subscription', 'subscription'],
		['GET|POST', '/recovery-password', 'Default#recoveryPassword', 'recovery-password'],
		['GET', '/deconnect', 'Game#logOut', 'game_log_out'],
		['GET|POST', '/new-password', 'Default#setNewPassword', 'game_new_pass'],
	);