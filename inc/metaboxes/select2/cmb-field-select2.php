<?php
/*
Plugin Name: CMB Field Type: Select2
Plugin URI: https://github.com/mustardBees/cmb-field-select2
Description: Select2 field type for Custom Metaboxes and Fields for WordPress
Version: 0.3
Author: Phil Wylie
Author URI: http://www.philwylie.co.uk/
License: GPLv2+
*/

// Useful global constants
define( 'PW_SELECT2_URL', CMB_META_BOX_URL . 'select2/' );


function pw_select2( $field, $meta ) {
	wp_enqueue_script	( 'pw-select2-field-js', 	PW_SELECT2_URL . 'js/select2/select2.min.js', array( 'jquery-ui-sortable' ), '3.4.5' );
	wp_enqueue_script	( 'pw-select2-field-init', 	PW_SELECT2_URL . 'js/select2-init.js', array( 'pw-select2-field-js' ), null );
	wp_enqueue_style	( 'pw-select2-field-css', 	PW_SELECT2_URL . 'js/select2/select2.css', array(), '3.4.5' );
	wp_enqueue_style	( 'pw-select2-field-mods',	PW_SELECT2_URL . 'css/select2.css', array(), null );

	call_user_func( $field['type'], $field, $meta );

	echo ( isset( $field['desc'] ) && ! empty( $meta ) ? '<p class="cmb_metabox_description">' . $field['desc'] . '</p>' : '' );
}
add_filter( 'cmb_render_pw_select', 'pw_select2', 10, 2 );
add_filter( 'cmb_render_pw_multiselect', 'pw_select2', 10, 2 );

/**
 * Render select box field
 */
function pw_select( $field, $meta ) {
	echo '<select name="', $field['id'], '" id="', $field['id'], '" data-placeholder="' . $field['desc'] . '" class="select2">';
	echo '<option></option>';
	if ( isset( $field['options'] ) && ! empty( $field['options'] ) ) {
		foreach ( $field['options'] as $option_key => $option ) {
			$label = isset( $option['name'] ) ? $option['name'] : $option;
			$value = isset( $option['value'] ) ? $option['value'] : $option_key;

			echo '<option value="', $value, '" ', selected( $meta == $value ) ,'>', $label, '</option>';
		}
	}
	echo '</select>';
}

/**
 * Render multi-value select box field
 */
function pw_multiselect( $field, $meta ) {
	$options = array();

	if ( isset( $field['options'] ) && ! empty( $field['options'] ) ) {
		foreach ( $field['options'] as $option_key => $option ) {
			$label = isset( $option['name'] ) ? $option['name'] : $option;
			$value = isset( $option['value'] ) ? $option['value'] : $option_key;

			$options[] = array(
				'id' => $value,
				'text' => $label
			);
		}
	}

	wp_localize_script( 'pw-select2-field-init', $field['id'] . '_data', $options );

	if ( ! empty( $meta ) ) {
		$meta = implode( ',', $meta );
	}

	echo '<input type="hidden" name="' . $field['id'] . '" id="' . $field['id'] . '" data-placeholder="' . $field['desc'] . '" class="select2" value="' . $meta . '" />';
}

/**
 * Handle saving of single and multi-value select fields
 */
function pw_select2_sanitise( $meta_value, $field ) {
	if ( empty( $meta_value ) ) {
		$meta_value = '';
	} elseif ( 'pw_multiselect' == $field['type'] ) {
		$meta_value = explode( ',', $meta_value );
	}

	return $meta_value;
}