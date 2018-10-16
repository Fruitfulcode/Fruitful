# Fruitful App 

fruitful-app used to include and manage all Fruitful Code service modules in [![Fruitful Code](https://fruitfulcode.com/wp-content/uploads/2018/07/favicon_trpr16x16.png)](https://fruitfulcode.com) [Fruitful Code](https://fruitfulcode.com) [products](https://fruitfulcode.com/products/)

## To customize fruitful-app init:

Rename Fruitful[Product]App class and set variables:

	public $product_type = '{theme|plugin}';
	public $product_option_name = 'theme_options_name';

Create the Fruitful[Product]App object with root file in construct attributes.

## Interaction scheme of FruitfulCode modules

See modules_interaction_scheme.png