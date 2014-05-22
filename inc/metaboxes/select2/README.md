# CMB Field Type: Select2

## Description

[Select2](http://ivaynberg.github.io/select2/) field type for [Custom Metaboxes and Fields for WordPress](https://github.com/WebDevStudios/Custom-Metaboxes-and-Fields-for-WordPress).

This plugin gives you two CMB field types based on the Select2 script:

1. The `pw_select` field acts much like the default `select` field. However, it adds typeahead-style search allowing you to quickly make a selection from a large list
2. The `pw_multiselect` field allows you to select multiple values with typeahead-style search. The values can be dragged and dropped to reorder

## Usage

`pw_select` - Select box with with typeahead-style search. Example:
```php
array(
	'name' => 'Cooking time',
	'id' => $prefix . 'cooking_time',
	'desc' => 'Cooking time',
	'options' => array(
		'5' => '5 minutes',
		'10' => '10 minutes',
		'30' => 'Half an hour',
		'60' => '1 hour',
	),
	'type' => 'pw_select',
	'sanitization_cb' => 'pw_select2_sanitise',
),
```

`pw_multiselect` - Multi-value select box with drag and drop reordering. Example:
```php
array(
	'name' => 'Ingredients',
	'id' => $prefix . 'ingredients',
	'desc' => 'Select ingredients. Drag to reorder.',
	'options' => array(
		'flour' => 'Flour',
		'salt' => 'Salt',
		'eggs' => 'Eggs',
		'milk' => 'Milk',
		'butter' => 'Butter',
	),
	'type' => 'pw_multiselect',
	'sanitization_cb' => 'pw_select2_sanitise',
),
```

## Screenshots

### Select box

![Image](screenshot-1.png?raw=true)

### Multi-value select box

![Image](screenshot-2.png?raw=true)

![Image](screenshot-3.png?raw=true)

![Image](screenshot-4.png?raw=true)