<?php 

/*
     *  Plugin Name: Grndwrk Term Meta
    *   Plugin URI: http://grndwrk.ca
    *   Description: Add images to term metadata
    *   Version: 1.0
    *   Author: Grndwrk
    *   Author URI: http://grndwrk.ca
    *   License: GPL2
     *
    */

	function case_categories_add_meta_fields( $taxonomy ) {
	    ?>

	    <div class="form-field term-group">
	    	<img id="case_icon_img" src="" style="width: 150px; margin-bottom: 10px;" />
	        <label for="case_icon"><?php _e( 'Case Icon', 'my-plugin' ); ?></label>
	        <input type="text" id="case_icon" name="case_icon" value="" />
	        <input type="button" id="case-icon-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'my-plugin' )?>" />
	    </div>
	    <?php
	}
	add_action( 'case_categories_add_form_fields', 'case_categories_add_meta_fields', 10, 2 );
	add_action( 'thinking_categories_add_form_fields', 'case_categories_add_meta_fields', 10, 2 );
	add_action( 'news_categories_add_form_fields', 'case_categories_add_meta_fields', 10, 2 );

	function case_categories_edit_meta_fields( $term, $taxonomy ) {
	    $my_field = get_term_meta( $term->term_id, 'case_icon', true );
	    $my_image = wp_get_attachment_image_url($my_field, $size = 'thumbnail');
	    ?>
	    <tr class="form-field term-group-wrap">
	        <th scope="row">
	            <label for="case_icon"><?php _e( 'Case Icon', 'my-plugin' ); ?></label>
	        </th>
	        <td>
	        	<img id="case_icon_img" src="<?php echo $my_image; ?>" style="width: 150px;  margin-bottom: 10px; " />
	            <input type="text" id="case_icon" name="case_icon" value="<?php echo $my_field; ?>" />
	            <input type="button" id="case-icon-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'my-plugin' )?>" />
	        </td>
	    </tr>
	    <?php
	}
	add_action( 'case_categories_edit_form_fields', 'case_categories_edit_meta_fields', 10, 2 );
	add_action( 'thinking_categories_edit_form_fields', 'case_categories_edit_meta_fields', 10, 2 );
	add_action( 'news_categories_edit_form_fields', 'case_categories_edit_meta_fields', 10, 2 );


	function prfx_image_enqueue() {
	   
	        wp_enqueue_media();
	 
	        // Registers and enqueues the required javascript.
	        wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . 'meta-box-image.js', array( 'jquery' ) );
	        wp_localize_script( 'meta-box-image', 'meta_image',
	            array(
	                'title' => __( 'Choose or Upload an Image', 'prfx-textdomain' ),
	                'button' => __( 'Use this image', 'prfx-textdomain' ),
	            )
	        );
	        wp_enqueue_script( 'meta-box-image' );
	    }
	add_action( 'admin_enqueue_scripts', 'prfx_image_enqueue' );


	//Save the field contents to the database
	function case_categories_save_taxonomy_meta( $term_id, $tag_id ) {
	    if( isset( $_POST['case_icon'] ) ) {
	        update_term_meta( $term_id, 'case_icon', esc_attr( $_POST['case_icon'] ) );
	    }
	}
	add_action( 'created_case_categories', 'case_categories_save_taxonomy_meta', 10, 2 );
	add_action( 'edited_case_categories', 'case_categories_save_taxonomy_meta', 10, 2 );
	add_action( 'created_thinking_categories', 'case_categories_save_taxonomy_meta', 10, 2 );
	add_action( 'edited_thinking_categories', 'case_categories_save_taxonomy_meta', 10, 2 );
	add_action( 'created_news_categories', 'case_categories_save_taxonomy_meta', 10, 2 );
	add_action( 'edited_news_categories', 'case_categories_save_taxonomy_meta', 10, 2 );



	function case_categories_add_field_columns( $columns ) {
	    $columns['case_icon'] = __( 'Case Icon', 'my-plugin' );

	    return $columns;
	}
	add_filter( 'manage_edit-case_categories_columns', 'case_categories_add_field_columns' );
	add_filter( 'manage_edit-thinking_categories_columns', 'case_categories_add_field_columns' );
	add_filter( 'manage_edit-news_categories_columns', 'case_categories_add_field_columns' );



	function case_categories_add_field_column_contents( $content, $column_name, $term_id ) {
	    switch( $column_name ) {
	        case 'case_icon' :
	            $content = get_term_meta( $term_id, 'case_icon', true );
	            break;
	    }

	    return $content;
	}
	add_filter( 'manage_case_categories_custom_column', 'case_categories_add_field_column_contents', 10, 3 );
	add_filter( 'manage_thinking_categories_custom_column', 'case_categories_add_field_column_contents', 10, 3 );
	add_filter( 'manage_news_categories_custom_column', 'case_categories_add_field_column_contents', 10, 3 );
	

	register_activation_hook( __FILE__, 'termmeta_activate_plugin' );
	register_deactivation_hook( __FILE__, 'termmeta_deactivate_plugin' );



 ?>