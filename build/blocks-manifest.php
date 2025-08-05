<?php
// This file is generated. Do not modify it manually.
return array(
	'adsplugin-block' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'adsplugin/adsplugin-block',
		'version' => '0.1.0',
		'title' => 'Ads Plugin Block',
		'category' => 'ads-general',
		'icon' => 'megaphone',
		'description' => 'Main advertising block for displaying ads.',
		'keywords' => array(
			'ads',
			'advertising',
			'banner',
			'promotion'
		),
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'align' => array(
				'wide',
				'full'
			),
			'spacing' => array(
				'margin' => true,
				'padding' => true
			)
		),
		'attributes' => array(
			'adContent' => array(
				'type' => 'string',
				'default' => ''
			),
			'adType' => array(
				'type' => 'string',
				'default' => 'banner'
			)
		),
		'textdomain' => 'adsplugin-block',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	),
	'block-ai-product-description' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'adsplugin/block-ai-product-description',
		'version' => '0.1.0',
		'title' => 'AI Product Description Block',
		'category' => 'ads-general',
		'icon' => 'format-image',
		'description' => 'Block for generating AI-powered product descriptions.',
		'keywords' => array(
			'AI',
			'product',
			'description',
			'ads'
		),
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'align' => array(
				'wide',
				'full'
			),
			'spacing' => array(
				'margin' => true,
				'padding' => true
			),
			'background' => array(
				'backgroundImage' => true,
				'backgroundSize' => true
			)
		),
		'attributes' => array(
			'productTitle' => array(
				'type' => 'string',
				'default' => 'Welcome to Our Site'
			),
			'productSubtitle' => array(
				'type' => 'string',
				'default' => 'Discover amazing products and services'
			),
			'showAdOverlay' => array(
				'type' => 'boolean',
				'default' => false
			),
			'backgroundImage' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'textdomain' => 'adsplugin-block',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	),
	'block-contact' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'adsplugin/contact-block',
		'version' => '0.1.0',
		'title' => 'Contact Ad Block',
		'category' => 'ads-general',
		'icon' => 'email-alt',
		'description' => 'Contact form block with advertising capabilities.',
		'keywords' => array(
			'contact',
			'form',
			'ads',
			'lead generation'
		),
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'align' => array(
				'wide',
				'full'
			),
			'spacing' => array(
				'margin' => true,
				'padding' => true
			)
		),
		'attributes' => array(
			'showAdBanner' => array(
				'type' => 'boolean',
				'default' => true
			),
			'contactTitle' => array(
				'type' => 'string',
				'default' => 'Contact Us'
			)
		),
		'textdomain' => 'adsplugin-block',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	),
	'block-hero' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'adsplugin/hero-block',
		'version' => '0.1.0',
		'title' => 'Hero Ad Block',
		'category' => 'ads-general',
		'icon' => 'format-image',
		'description' => 'Hero section block with integrated advertising space.',
		'keywords' => array(
			'hero',
			'banner',
			'ads',
			'featured',
			'header'
		),
		'example' => array(
			
		),
		'supports' => array(
			'html' => false,
			'align' => array(
				'wide',
				'full'
			),
			'spacing' => array(
				'margin' => true,
				'padding' => true
			),
			'background' => array(
				'backgroundImage' => true,
				'backgroundSize' => true
			)
		),
		'attributes' => array(
			'heroTitle' => array(
				'type' => 'string',
				'default' => 'Welcome to Our Site'
			),
			'heroSubtitle' => array(
				'type' => 'string',
				'default' => 'Discover amazing products and services'
			),
			'showAdOverlay' => array(
				'type' => 'boolean',
				'default' => false
			),
			'backgroundImage' => array(
				'type' => 'string',
				'default' => ''
			)
		),
		'textdomain' => 'adsplugin-block',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	)
);
