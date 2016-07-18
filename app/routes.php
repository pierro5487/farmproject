<?php
	
	$w_routes = array(
		['GET|POST', '/', 'Default#home', 'home'],
		['GET', '/farm', 'Farm#displayFarm', 'game_farm'],
		['GET|POST', '/subscription', 'Default#subscription', 'subscription'],
		['GET|POST', '/recovery-password', 'Default#recoveryPassword', 'recovery-password'],
		['GET', '/deconnect', 'Default#logOut', 'game_log_out'],
		['GET|POST', '/new-password', 'Default#setNewPassword', 'game_new_pass'],
		['GET', '/animals', 'Animals#displayAnimals', 'game_animals'],
		['GET', '/ajax/refresh', 'Ajax#animalsRefreshList', 'ajax_refresh_animals'],
		['GET|POST', '/building', 'Building#displayBuilding', 'game_building'],
		['GET', '/field', 'Field#displayField', 'game_field'],
		['GET|POST', '/buildingsUpgrade', 'Building#upgradeBuilding', 'ajax_upgrade_buldings'],

	);