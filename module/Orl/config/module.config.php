<?php
return array (
		'controllers' => array (
				'invokables' => array (
						'Orl\Controller\Orl' => 'Orl\Controller\OrlController',
						'Orl\Controller\Secretariat' => 'Orl\Controller\SecretariatController'
				)
		),
		'router' => array (
				'routes' => array (
						'orl' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/orl[/][:action][/:val][/:id_cons]',
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'val' => '[0-9]+',
												'id_cons' => '[a-zA-Z][a-zA-Z0-9_-]*'
										),
										'defaults' => array (
												'controller' => 'Orl\Controller\Orl',
												'action' => 'liste-consultation'
										)
								)
						),
						
						'secretariat' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/secretariat[/][:action][/:id_patient][/:val]',
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id_patient' => '[a-zA-Z][a-zA-Z0-9_-]*',
												//'val' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'val' => '[0-9]+'
										),
										'defaults' => array (
												'controller' => 'Orl\Controller\Secretariat',
												'action' => 'test'
										)
								)
						)
				)
		),
		'view_manager' => array (
				'template_map' => array (
 						'layout/orl' => __DIR__ . '/../view/layout/orl.phtml',
 						'layout/menugaucheorl' => __DIR__ . '/../view/layout/menugaucheorl.phtml',
 						'layout/piedpageorl' => __DIR__ . '/../view/layout/piedpageorl.phtml'
				),
				'template_path_stack' => array (
						'orl' => __DIR__ . '/../view'
				),
				'strategies' => array(
						'ViewJsonStrategy',
				),
		)
);