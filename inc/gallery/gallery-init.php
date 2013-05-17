<?php 
if( !class_exists( 'fruitful_gallery' ) )
	{	
	class fruitful_gallery
	{
		public function init() {
			add_action( 'init', array(&$this, 'register_fruitful_gallery') ); 
			add_action( 'wp_ajax_fruitful_add_new_element_action', array(&$this, 'fruitful_add_new_element'));
			
			add_filter( 'manage_edit-fruitful-gallery_columns', 			array(&$this, 'custom_gallery_columns'));
			add_filter( 'manage_edit-fruitful-gallery_sortable_columns', 	array(&$this, 'gallery_sortable_columns'));
			add_action( 'manage_fruitful-gallery_posts_custom_column', 		array(&$this, 'manage_gallery_columns'), 10, 2 );
			add_filter( 'admin_enqueue_scripts', array(&$this, 'load_scripts_and_styles'), 10);
			
			add_action( 'admin_menu', array(&$this, 'gallery_add_box'));
			add_action( 'save_post',  array(&$this, 'save_postdata') );
		
		}
		
		public function register_fruitful_gallery() {
	    	 
			$labels = array(
				'name' 			=> __('Gallery', 'fruitful'),
				'singular_name' => __('Gallery', 'fruitful'),
				'add_new' 		=> __('Add New Gallery', 	'fruitful'),
				'add_new_item' 	=> __('Add New Gallery', 	'fruitful'),
				'edit_item' 	=> __('Edit Gallery',    	'fruitful'),
				'view_item' 	=> __('View Gallery',    	'fruitful'),
				'new_item' 		=> __('New Gallery', 		'fruitful'),
				'search_items' 	=> __('Search Gallery', 	'fruitful'),
				'not_found' 			=> __('Gallery not found', 	'fruitful'),
				'not_found_in_trash' 	=> __('Gallery not found in trash', 'fruitful'),
				'parent_item_colon' 	=> ''
			);

			$args = array(
				'labels' 			 => $labels,
				'public' 			 => true,
				'publicly_queryable' => true,
				'show_ui' 			 => true,
				
				'rewrite' => array(
					'slug' => 'gallery'
				),
				'query_var' 		=> true,
				'capability_type' 	=> 'post',
				'hierarchical' 		=> false,
				'menu_position' 	=> 110,
				'supports' 			=> array('title', 'editor'),
				'menu_icon' 		=> get_stylesheet_directory_uri() . '/inc/gallery/img/gallery.png'
			  ); 
			  
			register_post_type( 'fruitful-gallery' , $args);
			flush_rewrite_rules();
		}
		
		public function save_postdata($post_id) {
			if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;
			if(!isset ($_POST['fruitful_gallery_nonce'])) 	  return;
			if(!is_admin() || !wp_verify_nonce( $_POST['fruitful_gallery_nonce'], 'fruitful_gallery' ) )
	     		return;
			
			
	     	// Check permissions
			if ( 'page' == $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post_id ) )
					return;
			} else {
			    if ( !current_user_can( 'edit_post', $post_id ) )
			    	return;
			}
			
			$old_gallery_data = get_post_meta($post_id, 'fruitful-gallery',true);
			if(isset($_POST['fruitful-gallery'])) {
				$new_data = $_POST['fruitful-gallery'];
				$this->save_meta_data($post_id, $_POST['fruitful-gallery'], $old_gallery_data, 'fruitful-gallery');
				$this->save_meta_data($post_id, $_POST['fruitful-special-grids'], 		get_post_meta($post_id, 'fruitful-special-grids', true), 'fruitful-special-grids');
				$this->save_meta_data($post_id, $_POST['fruitful-animations-type'], 	get_post_meta($post_id, 'fruitful-animations-type', true), 'fruitful-animations-type');
				$this->save_meta_data($post_id, $_POST['fruitful-rotation'], 			get_post_meta($post_id, 'fruitful-rotation', true), 'fruitful-rotation');
				$this->save_meta_data($post_id, $_POST['fruitful-paddings-hor'], 		get_post_meta($post_id, 'fruitful-paddings-hor', true), 'fruitful-paddings-hor');
				$this->save_meta_data($post_id, $_POST['fruitful-paddings-ver'], 		get_post_meta($post_id, 'fruitful-paddings-ver', true), 'fruitful-paddings-ver');
				$this->save_meta_data($post_id, $_POST['fruitful-glr-scale'], 			get_post_meta($post_id, 'fruitful-glr-scale', true), 'fruitful-glr-scale');
			}
		}
		
		public function save_meta_data($post_id, $new_data, $old_data, $name){
			if ($new_data == $old_data){ 
				add_post_meta($post_id, $name, $new_data, true);
			} else if(!$new_data){
				delete_post_meta($post_id, $name, $old_data);
			} else if($new_data != $old_data){
				update_post_meta($post_id, $name, $new_data, $old_data);
			}
		}
		
		
		public function fruitful_get_image($attachment_id) {
			
			$image_attributes = wp_get_attachment_image_src( $attachment_id, 'thumbnail');
			$image_full = wp_get_attachment_image_src( $attachment_id, 'full');
			
			$out .= '<li class="glr_item">' . "\r\n";
				$out .= '<input type="hidden" value="'. $attachment_id  .'" name="fruitful-gallery[attachment_ids][]" />';
				$out .= '<input type="hidden" value="'. $image_full[0] .'" name="fruitful-gallery[attachment_urls][]" />';
				$out .= '<img id="image-'. $attachment_id .'" src="'. $image_attributes[0] .'" alt="" />' . "\r\n";
				$out .= '<a href="javascript:void(0);" class="delete_btn_glr" title="Delete Image" title="Delete Image"></a>' . "\r\n";
			$out .= '</li>';
			
			return $out;
			die();
		}
		
		public function fruitful_add_new_element() {
			$out = "";
			if(!is_admin() || !wp_verify_nonce( $_POST['fruitful_ajax_nonce'], 'fruitful_add_img_ajax_nonce' ) ) {
				return;
			}
			
			$image_url	 = $_POST['image_url'];
			$image_id	 = $_POST['image_id'];
			$image_attributes = wp_get_attachment_image_src( $image_id, 'thumbnail');
			
			$out .= '<li class="glr_item">' . "\r\n";
				$out .= '<input type="hidden" value="'. $image_id  .'" name="fruitful-gallery[attachment_ids][]" />';
				$out .= '<input type="hidden" value="'. $image_url .'" name="fruitful-gallery[attachment_urls][]" />';
				$out .= '<img id="image-'.$image_id.'" src="'. $image_attributes[0] .'" alt="" />' . "\r\n";
				$out .= '<a href="javascript.void(0)" class="delete_btn" title="Delete Images" title=""></a>' . "\r\n";
			$out .= '</li>';
			
			echo $out;
			die();
		}
		
		public function load_scripts_and_styles($hook) {
			if ( $hook == 'post-new.php' || $hook == 'post.php' ) { 
				global $post;

				if ( 'fruitful-gallery' === $post->post_type ) {     
					  
					  if(function_exists( 'wp_enqueue_media' )){
							wp_enqueue_media();
						} else {
							wp_enqueue_style ('thickbox');
							wp_enqueue_script('media-upload');
							wp_enqueue_script('thickbox');
					    }
					  
							wp_enqueue_script	( 'fruitful-gallery-js',  get_template_directory_uri()  . '/inc/gallery/js/gallery-init.js',  array('jquery'));
							wp_enqueue_style	( 'fruitful-gallery-css', get_template_directory_uri()  . '/inc/gallery/css/gallery-admin.css' ); 
							wp_localize_script	( 'fruitful-gallery-js',  'fruitful_vars_ajax', array(
																		  'ajaxurl' 	=> admin_url( 'admin-ajax.php' ),
																		  'ajax_nonce' 	=> wp_create_nonce( 'fruitful_add_img_ajax_nonce' ),
												));
		        }
		    }
		}
		
		public function custom_gallery_columns($columns) {
				$columns = array(
									'cb' 		=> 	   '<input type="checkbox" />',
									'title' 	=> __( 'Gallery' ),
									"author" 	=> __( 'Author' ),
									'shortcode'	=> __( 'Shortcode' ),
									'date' 		=> __( 'Date' )
				);
			return $columns;
		}

		public function gallery_sortable_columns($columns) {
					   $columns['shortcode'] = 'shortcode';
				return $columns;
		}
			
		public function manage_gallery_columns( $column, $post_id ) {
			global $post;
				switch( $column ) {
					case 'shortcode' :
							if ( empty( $shortcode ) )  echo '[gallery id='.$post_id.']';
					break;
				default :
					break;
			}
		}
		
		public function gallery_add_box() {
		    global $meta_box;
		    add_meta_box('fruitful-gallery_manage',		'Images', 	array(&$this,  'fruitful_gallery_show_box'), 		  'fruitful-gallery', 'normal', 'high');
		    add_meta_box('fruitful-gallery_settings', 	'Settings', array(&$this,  'fruitful_gallery_show_settings_box'), 'fruitful-gallery', 'normal', 'low');
		}
		
		public function fruitful_gallery_show_box($currentPost, $metabox) {
			$post_id 		= $currentPost->ID;
			$gallery_data 	= get_post_meta($post_id , 'fruitful-gallery', 'true' );
			wp_nonce_field('fruitful_gallery', 'fruitful_gallery_nonce' );
			
			if($gallery_data && count($gallery_data['attachment_ids'])) {
				$j = 0;
				foreach($gallery_data['attachment_ids'] as $attachment_id) {
					$gallery_items .= $this->fruitful_get_image($attachment_id);
					$j++;
				}
			}
			
			$out .= '<div class="soratble-inner">';
			$out .= '<ul id="sortable" class="sortable-admin-gallery">';
				$out .= $gallery_items;
			$out .= '</ul>';
			$out .= '</div>';
			$out .= '<a href="#" class="button-primary add_gallery_items_button">' . __('Add Images', 'fruitful') . '</a> <br class="clear" />';
			echo $out;
		}
		
		
		public function fruitful_gallery_show_settings_box($currentPost, $metabox) {
			$post_id 			= $currentPost->ID;
			$special_grids 		= get_post_meta($post_id , 'fruitful-special-grids', 	'true' );
			$animations_type 	= get_post_meta($post_id , 'fruitful-animations-type', 	'true' );
			$animations_speed 	= get_post_meta($post_id , 'fruitful-animations-speed',	'true' );
			$rotation_corner	= get_post_meta($post_id , 'fruitful-rotation',	'true' );
			$padding_images_hor	= get_post_meta($post_id , 'fruitful-paddings-hor',	'true' );
			$padding_images_ver	= get_post_meta($post_id , 'fruitful-paddings-ver',	'true' );
			$scale				= get_post_meta($post_id , 'fruitful-glr-scale',	'true' );
			
			
			?>
			<table><tbody>		
				<tr>
					<td><label for="sapecials-grids"><?php _e('Special Grids', 'fruitful'); ?></label></td>
					<td><select id="sapecials-grids" name="fruitful-special-grids" >
						<option value="0" <?php if(!$special_grids || $special_grids =='0') { echo 'selected'; } ?>><?php _e('Random Grids', 'fruitful'); ?></option>
						<option value="2"  <?php if($special_grids=='2'){ echo 'selected'; } ?>><?php _e('2 (special grid)', 'fruitful'); ?></option>
						<option value="3"  <?php if($special_grids=='3'){ echo 'selected'; } ?>><?php _e('3 (special grid)', 'fruitful'); ?></option>
						<option value="4"  <?php if($special_grids=='4'){ echo 'selected'; } ?>><?php _e('4 (special grid)', 'fruitful'); ?></option>
						<option value="5"  <?php if($special_grids=='5'){ echo 'selected'; } ?>><?php _e('5 (special grid)', 'fruitful'); ?></option>
						<option value="6"  <?php if($special_grids=='6'){ echo 'selected'; } ?>><?php _e('6 (special grid)', 'fruitful'); ?></option>
						<option value="7"  <?php if($special_grids=='7'){ echo 'selected'; } ?>><?php _e('7 (special grid)', 'fruitful'); ?></option>
						<option value="8"  <?php if($special_grids=='8'){ echo 'selected'; } ?>><?php _e('8 (special grid)', 'fruitful'); ?></option>
						<option value="9"  <?php if($special_grids=='9'){ echo 'selected'; } ?>><?php _e('9 (special grid)', 'fruitful'); ?></option>
						<option value="10" <?php if($special_grids=='10'){ echo 'selected'; } ?>><?php _e('10 (basic grid)', 'fruitful'); ?></option>
						<option value="11" <?php if($special_grids=='11'){ echo 'selected'; } ?>><?php _e('11 (basic grid)', 'fruitful'); ?></option>
						<option value="12" <?php if($special_grids=='12'){ echo 'selected'; } ?>><?php _e('12 (basic grid)', 'fruitful'); ?></option>
						<option value="13" <?php if($special_grids=='13'){ echo 'selected'; } ?>><?php _e('13 (basic grid)', 'fruitful'); ?></option>
						<option value="14" <?php if($special_grids=='14'){ echo 'selected'; } ?>><?php _e('14 (different height grid)', 'fruitful'); ?></option>
						<option value="15" <?php if($special_grids=='15'){ echo 'selected'; } ?>><?php _e('15 (different height grid)', 'fruitful'); ?></option>
						<option value="16" <?php if($special_grids=='16'){ echo 'selected'; } ?>><?php _e('16 (different height grid)', 'fruitful'); ?></option>
						<option value="17" <?php if($special_grids=='17'){ echo 'selected'; } ?>><?php _e('17 (different height grid)', 'fruitful'); ?></option>
					</select></td>
					<td></td>
				</tr>
				
				<tr>
					<td><label for="animations-type"><?php _e('Animation Types', 'fruitful'); ?></label></td>
					<td><select id="animations-type" name="fruitful-animations-type" >
						<option value="1" <?php if(!$animations_type || $animations_type =='1'){ echo 'selected'; } ?>><?php _e('1', 'fruitful'); ?></option>
						<option value="2"  <?php if($animations_type=='2'){ echo 'selected'; } ?>><?php _e('2', 'fruitful'); ?></option>
						<option value="3"  <?php if($animations_type=='3'){ echo 'selected'; } ?>><?php _e('3', 'fruitful'); ?></option>
						<option value="4"  <?php if($animations_type=='4'){ echo 'selected'; } ?>><?php _e('4', 'fruitful'); ?></option>
						<option value="5"  <?php if($animations_type=='5'){ echo 'selected'; } ?>><?php _e('5', 'fruitful'); ?></option>
						<option value="6"  <?php if($animations_type=='6'){ echo 'selected'; } ?>><?php _e('6', 'fruitful'); ?></option>
						<option value="7"  <?php if($animations_type=='7'){ echo 'selected'; } ?>><?php _e('7', 'fruitful'); ?></option>						
					</select></td>
					<td></td>
				</tr>
				<tr>
					<td><label for="animations-speed"><?php _e('Animations Speed', 'fruitful'); ?></label></td>
					<td>
						<input id="animations-speed" name="fruitful-animations-speed" value="<?php echo ($animations_speed ? $animations_speed : '600'); ?>" />
					</td>
				</tr>
				<tr>
					<td><label for="rotation-corner"><?php _e('Rotation (99=random)', 'fruitful'); ?></label></td>
					<td>
						<input id="rotation-corner" name="fruitful-rotation" value="<?php echo ($rotation_corner ? $rotation_corner : '99'); ?>" />
					</td>
				</tr>
				<tr>
					<td><label for="padding-images"><?php _e('Paddings', 'fruitful'); ?></label></td>
					<td>
						<input id="padding-images-hor" name="fruitful-paddings-hor" value="<?php echo ($padding_images_hor ? $padding_images_hor : '10'); ?>" />
					</td>
					<td>
						<input id="padding-images-ver" name="fruitful-paddings-ver" value="<?php echo ($padding_images_ver ? $padding_images_ver : '10'); ?>" />
					</td>
				</tr>
				
				<tr>
					<td><label for="scale-image"><?php _e('Scale (0-1)', 'fruitful'); ?></label></td>
					<td>
						<input id="glr-scale" name="fruitful-glr-scale" value="<?php echo ($scale ? $scale : '0.7'); ?>" />
					</td>
				</tr>
			</tbody></table>
			<?php
		}		
	}
}		
$gallery = new fruitful_gallery();
$gallery->init();