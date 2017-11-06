<?php
/**
 * 
 * this class will be used to access files form N-Media Files for APP
 * 
 * @since 1.0
 */
 
 if( ! defined('ABSPATH') )
    die('Not allowed');
    
class NM_Files_App extends NM_WP_FileManager {
    
    var $user_files = array();
	var $only_file_titles = array();
     
    function __construct() {
        
        // lets' APIng
        add_action( 'rest_api_init', array($this, 'register_apis'));
        
    }
    
    
    public function register_apis() {
         
        // fetch all members
        register_rest_route( 'nmfiles/v1', '/get-files/', array(
		    'methods' => 'GET',
		    'callback' => array($this, 'get_files'),
		) );
		
		// fetching all users
		register_rest_route( 'nmfiles/v1', '/get-users/', array(
		    'methods' => 'GET',
		    'callback' => array($this, 'get_users'),
		) );
    }
    
    public function get_files($request) {
        
        $this -> set_headers();
        
        $parameters = $request->get_params();
        
        $file_sortby = (isset($parameters['sortby'])) ? $parameters['sortby'] : 'title' ;
		$file_order = (isset($parameters['order'])) ? $parameters['order'] : 'ASC' ;
		
		$user_id = (isset($parameters['user_id'])) ? $parameters['user_id'] : 'ALL' ;
		
		//getting author/user file
		if( $user_id != 'ALL' ){
    		$args = array(
    			'orderby'        => $file_sortby,
    			'order'          => $file_order,
    			'post_type'      => 'nm-userfiles',
    			'post_status'    => 'publish',
    			'nopaging'		 => true,
    			'author'         => $user_id,
    			'post_parent' 	=> 0,
    		);
		}else{
		    $args = array(
    			'orderby'        => $file_sortby,
    			'order'          => $file_order,
    			'post_type'      => 'nm-userfiles',
    			'post_status'    => 'publish',
    			'nopaging'		 => true,
    			'post_parent' 	=> 0,
    		);
		}
		
		$user_files = new WP_Query($args);
		
		while ( $user_files -> have_posts() ) : 
		
			$user_files -> the_post();
			
			global $post;

			// if getting shared files
			if ($shared_files != '') {
				$shared_user_ids = get_post_meta( $post->ID, 'shared_with', true );
				if ($shared_user_ids != '') {
					$arr_user_ids = explode(',', $shared_user_ids);
					if( in_array( $user_id, $arr_user_ids ) ){
						$this -> user_files[] = $this -> get_single_file_data( $post, $file_sortby, $file_order, $shared_files );
					}
				}
			} else {
				
				$this -> user_files[] = $this -> get_single_file_data( $post, $file_sortby, $file_order, $shared_files );
			}
			
			

		endwhile;
		
		$all_files = array('all' => $this -> user_files,
							'recent' => $this->only_file_titles);
		// filemanager_pa($final_files);
		if( $all_files ) {
		     
		     return new WP_REST_Response( $all_files, 200 );
		    
		 }else {
		     return new WP_Error( 'no_file_found', 'No File Found', array( 'status' => 404 ) );
		 }
    }
    
    
     public function get_users($request) {
        
        $this -> set_headers();
        
        $parameters = $request->get_params();
        
        $filter = array('fields' => array('ID', 'user_login', 'user_nicename', 'user_email', 'display_name'));
        $all_users = get_users($filter);
        
        
		if( $all_users ) {
		     
		     return new WP_REST_Response( $all_users, 200 );
		    
		 }else {
		     return new WP_Error( 'no_file_found', 'No User Found', array( 'status' => 404 ) );
		 }
    }
    
    
    
    
    /**
     * 
     * ================ Helper functions ===============
     * 
     **/
     
     // settings headers
     public function set_headers() {
     	
     	if (isset($_SERVER['HTTP_ORIGIN'])) {
	        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	        header('Access-Control-Allow-Credentials: true');
	        header('Access-Control-Max-Age: 86400');    // cache for 1 day
	    }
	
	    // Access-Control headers are received during OPTIONS requests
	    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	
	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
	            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
	
	        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
	            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
	
	        exit(0);
	    }
	    
     }
}


$appClass = new NM_Files_App();