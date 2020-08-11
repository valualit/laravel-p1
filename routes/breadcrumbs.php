<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('Админ-панель'), route('admin.dashboard'));
});

	Breadcrumbs::for('admin.users', function ($trail) {
		$trail->parent('admin.dashboard');
		$trail->push(__('Пользователи'), route('admin.users'));
	});

		Breadcrumbs::for('admin.users.roles', function ($trail) {
			$trail->parent('admin.users');
			$trail->push(__('Роли'), route('admin.roles'));
		});
		Breadcrumbs::for('admin.users.userentities', function ($trail) {
			$trail->parent('admin.users');
			$trail->push(__('Конфигурация полей'), route('admin.users.userentities'));
		});

Breadcrumbs::for('admin.serm', function ($trail) {
	$trail->parent('admin.dashboard');
    $trail->push(__('SERM'), route('admin.serm'));
});
	Breadcrumbs::for('admin.serm.sermupdate', function ($trail) {
		$trail->parent('admin.serm');
		$trail->push(__('Синхронизация'), route('admin.serm.sermupdate'));
	});

Breadcrumbs::for('admin.entities', function ($trail) {
	$trail->parent('admin.dashboard');
    $trail->push(__('Разделы сайта'), route('admin.entities'));
});

	Breadcrumbs::for('admin.component.index', function ($trail,$section,$name) {
		$trail->parent('admin.entities');
		$trail->push(__($name), route('admin.component.index',$section));
	});

		Breadcrumbs::for('admin.entities.userentities', function ($trail,$section,$name) {
			$trail->parent('admin.component.index',$section,$name);
			$trail->push(__('Конфигурация полей'), route('admin.entities.userentities',$section,$name));
		});
		
		Breadcrumbs::for('admin.component.item.view', function ($trail,$section,$name,$id) {
			$trail->parent('admin.component.index',$section,$name);
			$trail->push(__('Карточка №').$id, route('admin.component.item.view',[$section,$id]));
		});

	Breadcrumbs::for('admin.pages.widjet', function ($trail,$section,$name) {
		$trail->parent('admin.entities',$section,$name);
		$trail->push(__($name), route('admin.pages.widjet',$section,$name));
	});

Breadcrumbs::for('admin.settings', function ($trail) {
	$trail->parent('admin.dashboard');
    $trail->push(__('Настройки'), route('admin.settings'));
});


