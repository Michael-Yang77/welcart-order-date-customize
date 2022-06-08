<?php
/*
Plugin Name: WCEX Patch for AFC
Plugin URI: http://www.welcart.com/
Description: このプラグインはWelcart商品でAdvanced Custom Fields PROを利用できるようにするためのパッチです。
Version: 1.0.0
Author: Collne Inc.
Author URI: http://www.collne.com/
*/

if ( !defined('USCES_VERSION') ){
	return;
}

add_action( 'init', 'collne_afc_patch' );
function collne_afc_patch(){
	global $acf;
	if( $acf ){

		if( false !== strpos( $acf->settings['slug'], 'pro' ) ){
			acf_new_instance('acf_form_welcart_item_pro');
		}else{
			new acf_form_welcart_item();
		}
	}
}

if( ! class_exists('acf_form_welcart_item') ) :

class acf_form_welcart_item {
	
	var $post_id	= 0,
		$typenow	= '',
		$style		= '';
	
	
	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
	
		// actions
		add_action('admin_enqueue_scripts',				array($this, 'admin_enqueue_scripts'));
		
		
		// save
		add_filter('wp_insert_post_empty_content',		array($this, 'wp_insert_post_empty_content'), 10, 2);
		add_action('save_post', 						array($this, 'save_post'), 10, 2);
		
		
		// ajax
		add_action('wp_ajax_acf/post/get_field_groups',	array($this, 'get_field_groups'));
		
	}
	
	
	/*
	*  validate_page
	*
	*  This function will check if the current page is for a post/page edit form
	*
	*  @type	function
	*  @date	23/06/12
	*  @since	3.1.8
	*
	*  @param	n/a
	*  @return	(boolean)
	*/
	
	function validate_page() {
		
		// global
		global $post, $pagenow, $typenow;
		
		
		// vars
		$return = false;
		
		
		// validate page
		if( in_array($pagenow, array('post.php', 'post-new.php')) ) {
			
//			$return = true;
			
		}
		
		
		// update vars
		if( !empty($post) ) {
		
			$this->post_id = $post->ID;
			$this->typenow = $typenow;
			
		}
		
		
		// validate post type
		if( in_array($typenow, array('acf-field-group', 'attachment')) ) {
			
			return false;
			
		}
		
		
		// validate page (Shopp)
		if( $pagenow == "admin.php" && isset( $_GET['page'] ) && $_GET['page'] == "usces_itemedit" && isset( $_GET['post'] ) ) {
			
			$return = true;
			
			$this->post_id = absint( $_GET['post'] );
			$this->typenow = '';
			
		}
		if( $pagenow == "admin.php" && isset( $_GET['page'] ) && $_GET['page'] == "usces_itemnew" ) {
			
			$return = true;
			
//			$this->post_id = absint( $_GET['post'] );
//			$this->typenow = '';
			
		}
				
		
		// return
		return $return;
	}
	
	
	/*
	*  admin_enqueue_scripts
	*
	*  This action is run after post query but before any admin script / head actions. 
	*  It is a good place to register all actions.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @date	26/01/13
	*  @since	3.6.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function admin_enqueue_scripts() {
		
		// validate page
		if( !$this->validate_page() ) return;

		
		// load acf scripts
		acf_enqueue_scripts();
		
		
		// actions
		add_action('acf/input/admin_head',		array($this,'admin_head'));
		add_action('acf/input/admin_footer',	array($this,'admin_footer'));
	}
	
	
	/*
	*  admin_head
	*
	*  This action will find and add field groups to the current edit page
	*
	*  @type	action (admin_head)
	*  @date	23/06/12
	*  @since	3.1.8
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function admin_head() {
		
		// vars
		$style_found = false;
		
		
		// get field groups
		$field_groups = acf_get_field_groups();
		
		
		// add meta boxes
		if( !empty($field_groups) ) {
			
			foreach( $field_groups as $i => $field_group ) {
				
				// vars
				$id = "acf-{$field_group['key']}";
				$title = $field_group['title'];
				$context = $field_group['position'];
				$priority = 'high';
				$args = array( 
					'field_group'	=> $field_group,
					'visibility'	=> false
				);
				
				
				// tweaks to vars
				if( $context == 'side' ) {
					
					$priority = 'core';
				
				}
				
				
				// filter for 3rd party customization
				$priority = apply_filters('acf/input/meta_box_priority', $priority, $field_group);
				
				
				// visibility
				$args['visibility'] = acf_get_field_group_visibility( $field_group, array(
					'post_id'	=> $this->post_id, 
					'post_type'	=> $this->typenow
				));
				
				// add meta box
				add_meta_box( $id, $title, array($this, 'render_meta_box'), $this->typenow, $context, $priority, $args );
	
				
				// update style
				if( !$style_found && $args['visibility'] ) {
					
					$style_found = true;
					
					$this->style = acf_get_field_group_style( $field_group );
					
				}
				
			}
			
		}
				
		
		// Allow 'acf_after_title' metabox position
		add_action('edit_form_after_title', array($this, 'edit_form_after_title'));

		
		// remove ACF from meta postbox
		add_filter('is_protected_meta', array($this, 'is_protected_meta'), 10, 3);
		
	}
	
	
	/*
	*  edit_form_after_title
	*
	*  This action will allow ACF to render metaboxes after the title
	*
	*  @type	action
	*  @date	17/08/13
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function edit_form_after_title() {
		
		// globals
		global $post, $wp_meta_boxes;
		
		// render post data
		acf_form_data(array( 
			'post_id'	=> $this->post_id, 
			'nonce'		=> 'post',
			'ajax'		=> 1
		));
		
		
		// render
		do_meta_boxes( get_current_screen(), 'acf_after_title', $post);
		
		
		// clean up
		unset( $wp_meta_boxes['post']['acf_after_title'] );

	}
	
	
	/*
	*  render_meta_box
	*
	*  description
	*
	*  @type	function
	*  @date	20/10/13
	*  @since	5.0.0
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function render_meta_box( $post, $args ) {
		
		// extract args
		extract( $args ); // all variables from the add_meta_box function
		extract( $args ); // all variables from the args argument
		
		
		// vars
		$o = array(
			'id'			=> $id,
			'key'			=> $field_group['key'],
			'style'			=> $field_group['style'],
			'label'			=> $field_group['label_placement'],
			'edit_url'		=> '',
			'edit_title'	=> __('Edit field group', 'acf'),
			'visibility'	=> $visibility
		);
		
		
		// edit_url
		if( $field_group['ID'] && acf_current_user_can_admin() ) {
			
			$o['edit_url'] = admin_url('post.php?post=' . $field_group['ID'] . '&action=edit');
				
		}
		
			
		// load and render fields	
		if( $visibility ) {
			
			// load fields
			$fields = acf_get_fields( $field_group );
			
			
			// render
			acf_render_fields( $this->post_id, $fields, 'div', $field_group['instruction_placement'] );
		
		// render replace-me div
		} else {
			
			echo '<div class="acf-replace-with-fields"><div class="acf-loading"></div></div>';
		
		}
	
	?>
<script type="text/javascript">
if( typeof acf !== 'undefined' ) {
		
	acf.postbox.render(<?php echo json_encode($o); ?>);	

}
</script>
<?php
		
	}
	
	
	/*
	*  admin_footer
	*
	*  description
	*
	*  @type	function
	*  @date	21/10/13
	*  @since	5.0.0
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function admin_footer(){
		
		// get style of first field group
		echo '<style type="text/css" id="acf-style">' . $this->style . '</style>';
		
	}
	
	
	/*
	*  get_field_groups
	*
	*  This function will return all the JSON data needed to render new metaboxes
	*
	*  @type	function
	*  @date	21/10/13
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/

	function get_field_groups() {
		
		// options
		$options = acf_parse_args($_POST, array(
			'nonce'		=> '',
			'post_id'	=> 0,
			'ajax'		=> 1,
			'exists'	=> array()
		));
		
		
		// vars
		$json = array();
		$exists = acf_extract_var( $options, 'exists' );
		
		
		// verify nonce
		if( !acf_verify_ajax() ) die();
		
		
		// get field groups
		$field_groups = acf_get_field_groups( $options );
		
		
		// bail early if no field groups
		if( empty($field_groups) ) {
			
			wp_send_json_success( $json );
			
		}
		
		
		// loop through field groups
		foreach( $field_groups as $i => $field_group ) {
			
			// vars
			$item = array(
				//'ID'	=> $field_group['ID'], - JSON does not have ID (not used by JS anyway)
				'key'	=> $field_group['key'],
				'title'	=> $field_group['title'],
				'html'	=> '',
				'style' => ''
			);
			
			
			// style
			if( $i == 0 ) {
				
				$item['style'] = acf_get_field_group_style( $field_group );
				
			}
			
			
			// html
			if( !in_array($field_group['key'], $exists) ) {
				
				// load fields
				$fields = acf_get_fields( $field_group );

	
				// get field HTML
				ob_start();
				
				
				// render
				acf_render_fields( $options['post_id'], $fields, 'div', $field_group['instruction_placement'] );
				
				
				$item['html'] = ob_get_clean();
				
				
			}
			
			
			// append
			$json[] = $item;
			
		}
		
		
		// return
		wp_send_json_success( $json );
		
	}
	
	
	/*
	*  wp_insert_post_empty_content
	*
	*  This function will allow WP to insert a new post without title / content if ACF data exists
	*
	*  @type	function
	*  @date	16/07/2014
	*  @since	5.0.1
	*
	*  @param	$maybe_empty (bool) whether the post should be considered "empty"
	*  @param	$postarr (array) Array of post data
	*  @return	$maybe_empty
	*/
	
	function wp_insert_post_empty_content( $maybe_empty, $postarr ) {
		
		if( $maybe_empty && !empty($_POST['_acfchanged']) ) {
			
			$maybe_empty = false;
			
		}

		
		// return
		return $maybe_empty;
	}
	
	
	/*
	*  allow_save_post
	*
	*  This function will return true if the post is allowed to be saved
	*
	*  @type	function
	*  @date	26/06/2016
	*  @since	5.3.8
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function allow_save_post( $post ) {
		
		// vars
		$allow = true;
		$reject = array( 'auto-draft', 'revision', 'acf-field', 'acf-field-group' );
		$wp_preview = acf_maybe_get($_POST, 'wp-preview');
		
		
		// check post type
		if( in_array($post->post_type, $reject) ) $allow = false;
		
		
		// allow preview
		if( $post->post_type == 'revision' && $wp_preview == 'dopreview' ) $allow = true;
		
		
		// return
		return $allow;
		
	}
	
	
	/*
	*  save_post
	*
	*  This function will validate and save the $_POST data
	*
	*  @type	function
	*  @date	23/06/12
	*  @since	1.0.0
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function save_post( $post_id, $post ) {
		
		// bail ealry if no allowed to save this post type
		if( !$this->allow_save_post($post) ) return $post_id;
		
		
		// ensure saving to the correct post
//		if( !acf_verify_nonce('post', $post_id) ) return $post_id;
		
		
		// validate for published post (allow draft to save without validation)
		if( $post->post_status == 'publish' ) {
			
			// show errors
			acf_validate_save_post( true );
				
		}
		
		
		// save
		acf_save_post( $post_id );
		
		
		// save revision
		if( post_type_supports($post->post_type, 'revisions') ) {
			
			acf_save_post_revision( $post_id );
			
		}
				
		
		// return
		return $post_id;
		
	}
	
	
	/*
	*  is_protected_meta
	*
	*  This function will remove any ACF meta from showing in the meta postbox
	*
	*  @type	function
	*  @date	12/04/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function is_protected_meta( $protected, $meta_key, $meta_type ) {
		
		// if acf_get_field_reference returns a valid key, this is an acf value, so protect it!
		if( !$protected ) {
			
			$reference = acf_get_reference( $meta_key, $this->post_id );
			
			if( acf_is_field_key($reference) ) {
				
				$protected = true;
				
			} 
			
		}
		
		
		// return
		return $protected;
				
	}
			
}
endif; // class_exists check

if( ! class_exists('acf_form_welcart_item_pro') ) :

class acf_form_welcart_item_pro {
	/** @var string The first field groups style CSS. */
	var $style = '';
	
	/**
	*  __construct
	*
	*  Sets up the class functionality.
	*
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	void
	*  @return	void
	*/
	function __construct() {
		
		// initialize on post edit screens
		add_action('load-welcart-shop_page_usces_itemedit',		array($this, 'initialize'));
		add_action('load-welcart-shop_page_usces_itemnew',		array($this, 'initialize'));
		add_action('load-post.php',		array($this, 'initialize'));
		add_action('load-post-new.php',	array($this, 'initialize'));
		
		// save
		add_filter('wp_insert_post_empty_content',		array($this, 'wp_insert_post_empty_content'), 10, 2);
		add_action('save_post', 						array($this, 'save_post'), 10, 2);
	}
	
	
	/**
	*  initialize
	*
	*  Sets up Form functionality.
	*
	*  @date	19/9/18
	*  @since	5.7.6
	*
	*  @param	void
	*  @return	void
	*/
	function initialize() {
		
		// globals
		global $typenow;
		
		// restrict specific post types
		$restricted = array('acf-field-group', 'attachment');
		if( in_array($typenow, $restricted) ) {
			return;
		}
		
		// enqueue scripts
		acf_enqueue_scripts(array(
			'uploader'	=> true,
		));
		
		// actions
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'), 10, 2);
	}
	
	/**
	*  add_meta_boxes
	*
	*  Adds ACF metaboxes for the given $post_type and $post.
	*
	*  @date	19/9/18
	*  @since	5.7.6
	*
	*  @param	string $post_type The post type.
	*  @param	WP_Post $post The post being edited.
	*  @return	void
	*/
	function add_meta_boxes( $post_type, $post ) {
		
		// Get field groups for this screen.
		$field_groups = acf_get_field_groups(array(
			'post_id'	=> $post->ID, 
			'post_type'	=> $post_type
		));
		
		// Loop over field groups.
		if( $field_groups ) {
			foreach( $field_groups as $field_group ) {
					
				// vars
				$id = "acf-{$field_group['key']}";			// acf-group_123
				$title = $field_group['title'];				// Group 1
				$context = $field_group['position'];		// normal, side, acf_after_title
				$priority = 'high';							// high, core, default, low
				
				// Reduce priority for sidebar metaboxes for best position.
				if( $context == 'side' ) {
					$priority = 'core';
				}
				
				/**
				*  Filters the metabox priority.
				*
				*  @date	23/06/12
				*  @since	3.1.8
				*
				*  @param	string $priority The metabox priority (high, core, default, low).
				*  @param	array $field_group The field group array.
				*/
				$priority = apply_filters('acf/input/meta_box_priority', $priority, $field_group);
				
				// Add the meta box.
				add_meta_box( $id, $title, array($this, 'render_meta_box'), $post_type, $context, $priority, array('field_group' => $field_group) );
			}
			
			// Get style from first field group.
			$this->style = acf_get_field_group_style( $field_groups[0] );
		}
		
		// remove postcustom metabox (removes expensive SQL query)
		if( acf_get_setting('remove_wp_meta_box') ) {
			remove_meta_box( 'postcustom', false, 'normal' ); 
		}
		
		// Add hidden input fields.
		add_action('edit_form_after_title', array($this, 'edit_form_after_title'));
		
		/**
		*  Fires after metaboxes have been added. 
		*
		*  @date	13/12/18
		*  @since	5.8.0
		*
		*  @param	string $post_type The post type.
		*  @param	WP_Post $post The post being edited.
		*  @param	array $field_groups The field groups added.
		*/
		do_action('acf/add_meta_boxes', $post_type, $post, $field_groups);
	}
	
	/**
	*  edit_form_after_title
	*
	*  Called after the title adn before the content editor.
	*
	*  @date	19/9/18
	*  @since	5.7.6
	*
	*  @param	void
	*  @return	void
	*/
	function edit_form_after_title() {
		
		// globals
		global $post, $wp_meta_boxes;
		
		// render post data
		acf_form_data(array(
			'screen'	=> 'post',
			'post_id'	=> $post->ID
		));
		
		// render 'acf_after_title' metaboxes
		do_meta_boxes( get_current_screen(), 'acf_after_title', $post );
		
		// render dynamic field group style
		echo '<style type="text/css" id="acf-style">' . $this->style . '</style>';
	}
	
	/**
	*  render_meta_box
	*
	*  Renders the ACF metabox HTML.
	*
	*  @date	19/9/18
	*  @since	5.7.6
	*
	*  @param	WP_Post $post The post being edited.
	*  @param	array metabox The add_meta_box() args.
	*  @return	void
	*/
	function render_meta_box( $post, $metabox ) {
		
		// vars
		$id = $metabox['id'];
		$field_group = $metabox['args']['field_group'];
		
		// Render fields.
		$fields = acf_get_fields( $field_group );
		acf_render_fields( $fields, $post->ID, 'div', $field_group['instruction_placement'] );
		
		// Create metabox localized data.
		$data = array(
			'id'		=> $id,
			'key'		=> $field_group['key'],
			'style'		=> $field_group['style'],
			'label'		=> $field_group['label_placement'],
			'edit'		=> acf_get_field_group_edit_link( $field_group['ID'] )
		);
		
		?>
		<script type="text/javascript">
		if( typeof acf !== 'undefined' ) {
			acf.newPostbox(<?php echo wp_json_encode($data); ?>);
		}	
		</script>
		<?php
	}
	
	/**
	*  wp_insert_post_empty_content
	*
	*  Allows WP to insert a new post without title or post_content if ACF data exists.
	*
	*  @date	16/07/2014
	*  @since	5.0.1
	*
	*  @param	bool $maybe_empty Whether the post should be considered "empty".
	*  @param	array $postarr Array of post data.
	*  @return	bool
	*/
	function wp_insert_post_empty_content( $maybe_empty, $postarr ) {
		
		// return false and allow insert if '_acf_changed' exists
		if( $maybe_empty && acf_maybe_get_POST('_acf_changed') ) {
			return false;
		}

		// return
		return $maybe_empty;
	}
	
	/*
	*  allow_save_post
	*
	*  Checks if the $post is allowed to be saved.
	*  Used to avoid triggering "acf/save_post" on dynamically created posts during save.
	*
	*  @type	function
	*  @date	26/06/2016
	*  @since	5.3.8
	*
	*  @param	WP_Post $post The post to check.
	*  @return	bool
	*/
	function allow_save_post( $post ) {
		
		// vars
		$allow = true;
		
		// restrict post types
		$restrict = array( 'auto-draft', 'revision', 'acf-field', 'acf-field-group' );
		if( in_array($post->post_type, $restrict) ) {
			$allow = false;
		}
		
		// disallow if the $_POST ID value does not match the $post->ID
		$form_post_id = (int) acf_maybe_get_POST('post_ID');
		if( $form_post_id && $form_post_id !== $post->ID ) {
			$allow = false;
		}
		
		// revision (preview)
		if( $post->post_type == 'revision' ) {
			
			// allow if doing preview and this $post is a child of the $_POST ID
			if( acf_maybe_get_POST('wp-preview') == 'dopreview' && $form_post_id === $post->post_parent) {
				$allow = true;
			}
		}
		
		// return
		return $allow;
	}
	
	/*
	*  save_post
	*
	*  Triggers during the 'save_post' action to save the $_POST data.
	*
	*  @type	function
	*  @date	23/06/12
	*  @since	1.0.0
	*
	*  @param	int $post_id The post ID
	*  @param	WP_POST $post the post object.
	*  @return	int
	*/
	
	function save_post( $post_id, $post ) {
		
		// bail ealry if no allowed to save this post type
		if( !$this->allow_save_post($post) ) {
			return $post_id;
		}
		
		// verify nonce
		if( !acf_verify_nonce('post') ) {
			return $post_id;
		}
		
		// validate for published post (allow draft to save without validation)
		if( $post->post_status == 'publish' ) {
			
			// bail early if validation fails
			if( !acf_validate_save_post() ) {
				return;
			}
		}
		
		// save
		acf_save_post( $post_id );
		
		// save revision
		if( post_type_supports($post->post_type, 'revisions') ) {
			acf_save_post_revision( $post_id );
		}
		
		// return
		return $post_id;
	}
}
endif;
