<?php 
/*Import dummy data for Fruitful Theme */
include_once(ABSPATH . 'wp-admin/includes/image.php');
global $arr_img_for_post, 
	   $arr_img_for_slider;
$arr_img_for_post   = array ('1column.png', '2column.png', '3column.png', '4column.png');
$arr_img_for_slider = array ('s1.png', 's2.png', 's3.png');

function fruitful_create_custom_page($args = null) {
	$post    = array();
	$content = $title = '';
	
	if (!empty($args['post_content'])) { $content = $args['post_content']; }
	if (!empty($args['post_title']))   { $title   = esc_html($args['post_title']); }
	
	$post = array(
		'post_author'    => get_current_user_id(),
		'post_content'   => $content,
		'post_date'      => date('Y-m-d H:i:s'),
		'post_date_gmt'  => date('Y-m-d H:i:s'), 
		'post_status'    => 'publish', 
		'post_title'     =>  $title,
		'post_type'      => 'page',
		'comment_status' => 'closed'
	); 
	
	$id_ = wp_insert_post($post);
	
	return $id_;
}
 
 
function get_exists_attach($name_value) {
	global $wpdb;
	$attach_count = 0;
	$attach_count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts where post_type='attachment' and post_title like '%".$name_value."%'" );
	return  ($attach_count > 0);
	
}

function add_attachment_image($image_url, $title = null, $alt = null, $post_content = null) {
	$attach_id = 0;
	$upload_dir = wp_upload_dir();
	
	if (@fopen($image_url, "r")) {
		$image_data = file_get_contents($image_url);
		if ($image_data) {
			$filename   = basename($image_url);
			if(wp_mkdir_p($upload_dir['path']))
				$file = $upload_dir['path'] . '/' . $filename;
			else
				$file = $upload_dir['basedir'] . '/' . $filename;
					
			file_put_contents($file, $image_data);
			$wp_filetype = wp_check_filetype($filename, null );
			if ($title == '') { $title = $filename; }
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' 	 => sanitize_file_name($title),
					'post_content'   => $post_content,
					'post_status'    => 'inherit'
				);
			
			$attach_id   = wp_insert_attachment( $attachment, $file, 0 );
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
			wp_update_attachment_metadata( $attach_id, $attach_data );
			
			return $attach_id;
		} else {
			return -1;
		}
	} else {
			return -1;
	}			
}	
 		
function fruitful_create_home_page() {
	global $arr_img_for_post, $arr_img_for_slider;
	
	$i_attach_id = $content  = $file_url = '';
	$i_arr   =  $s_attach_id = $slides_array = array();
	$i_count = 1;
	
	foreach ($arr_img_for_slider as $img) {
		$file_url = get_template_directory() . '/inc/func/import_data/' . $img;
		$s_attach_id[] = add_attachment_image($file_url, basename($file_url));
	}
	
	if (!empty($s_attach_id)) {
		$options = get_option( 'fruitful_theme_options' );
		if(empty($theme_options['slides'])) {	
			foreach ($s_attach_id as $slide) {
				$slides_array['slides']['slide-'.$i_count] = array('link' => esc_url(''), 'attach_id' => intval($slide), 'is_blank' => 'off');
				$i_count++;
			}	
			$merge_array = array_merge($options,    $slides_array); 		
			update_option('fruitful_theme_options', $merge_array);
		}
	}	
	
	$content  = '[fruitful_slider]' . "\r";
	$content .= '[description]Lorem ipsum dolor sit amet, consectetur <span class="text_orange">adipiscing</span> elit. Nullam.[/description]'  . "\r";
	
	foreach ($arr_img_for_post as $img) {
		$file_url 	 = get_template_directory() . '/inc/func/import_data/' . $img;
		$i_attach_id = add_attachment_image($file_url, basename($file_url));
		$i_attach_id = wp_get_attachment_image_src( $i_attach_id, 'full');
		$i_arr[]  = esc_url($i_attach_id[0]);
	}
	
	if (!empty($i_arr)) {
		$content .= '[info_box_area]';
			$content .= sprintf('[info_box icon_url="%1$s" alt="title-1" id="inb_1" type_column="alpha" title="Title 1"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis cursus tortor. Cras feugiat urna at dui sollicitudin, ut lobortis libero auctor.[/info_box]', $i_arr[0])  . "\r";
			$content .= sprintf('[info_box icon_url="%1$s" alt="title-2" id="inb_2" type_column="" title="Title 2"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis cursus tortor. Cras feugiat urna at dui sollicitudin, ut lobortis libero auctor.[/info_box]', $i_arr[1])  . "\r";
			$content .= sprintf('[info_box icon_url="%1$s" alt="title-3" id="inb_3" type_column="omega" title="Title 3"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis cursus tortor. Cras feugiat urna at dui sollicitudin, ut lobortis libero auctor.[/info_box]', $i_arr[2])  . "\r";
		$content .= '[/info_box_area]' . "\r";
	}
	
	$content .= 'Cras nibh erat, tempor non sagittis ac, vulputate ac lectus. Praesent sed fermentum eros. Mauris sodales suscipit diam, a congue dui commodo ac. Sed convallis rutrum ligula, vitae sollicitudin nisl porttitor nec. Mauris tempor fringilla imperdiet. Pellentesque interdum, tellus nec venenatis venenatis, nisi nulla ultricies leo, tincidunt venenatis risus nisl ac dolor. Donec ante leo, elementum et faucibus tincidunt, dignissim lacinia libero. Suspendisse pharetra in augue in sodales. Etiam luctus dui blandit nisi dictum pretium.' . "\r"; 
	$args = array();
	$args = array('post_title' =>'Home', 'post_content' => $content);
	
	if (!get_option('show_on_front') != 'page') {
		$id_home = fruitful_create_custom_page($args);
		update_option('show_on_front', 'page'); 
		update_option('page_on_front',  $id_home);
		update_option('fruitful_demo_content', 1);
		return true;
	}	
}