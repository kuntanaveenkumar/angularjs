<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package     CodeIgniter
 * @author      ExpressionEngine Dev Team
 * @copyright   Copyright (c) 2008 - 2010, EllisLab, Inc.
 * @license     http://codeigniter.com/user_guide/license.html
 * @link        http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------



/**
 * Language Class (Extended) - Extended for Database use
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Language
 * @author      Anthony Steiner, Adapted from original ExpressionEngine Dev Team's work
 * @link        @todo: Update with BitBucket wiki
 *
 */
class CI_Language 
{

	// Language DB constants - REQUIRED!!! (Read Documentation)
	var $table_name		= 'language';
	var $field_id		= 'language_id';
	var $field_key		= 'language_key';
	var $field_idiom	= 'language_idiom';
	var $field_category	= 'language_category';
	var $field_text		= 'language_text';
	var $arbfield_text	= 'arblanguage_text';
	var $cache_on		= TRUE;
	var $cache_ttl		= 60;	
	// Original accessors
	var $language		= array();
	var $is_loaded		= array();

	// Extended Properties
	var $_idiom; // Language (English, Spanish, etc)
	var $_category; // This would be the DB equivalent of langfile, but more generic for our use of it


	var $_is_cache 		= FALSE;
	var $_lang_cache_path;
	var $_lang_cache_file;


	/**
	 * Constructor
	 */
	function __construct()
	{
		 //parent::__construct();    
		$_config_exists = file_exists( APPPATH . 'config/language.php' );

		if( $_config_exists )
		{
			require_once ( APPPATH . 'config/language.php' );
		}

		// .../application/config/language.php file has precedence if you choose to use it instead
		if( file_exists( APPPATH . 'config/language.php' ) && count( $config ) > 0 )
		{
			foreach( $config as $key => $val )
			{
				{
					$this->$key = $val;
				}
			}
		}
		$ci =& get_instance();
        $ci->load->helper('language');
		$site_lang = $ci->session->userdata('site_lang');
        if ($site_lang) 
		{
           $this->load('message',$ci->session->userdata('site_lang'));

        } else {
          $this->load('message','english');
        }			
		//print_r($this->language);
		log_message( 'debug', "Language (Extended) Class Initialized" );
	}
	
	
    /**
     * Getter for _lang_cache_path() and _lang_cache_file
     *
     * @access  private
     * @return  string
     */
    private function _get_lang_cache_path()
    {
        $CI = & get_instance();

        $path = $CI->config->item('cache_path');

        $cache_path = (empty($path)) ? BASEPATH.'cache/' : $path;

        if( ! is_dir( $cache_path ) || ! is_really_writable( $cache_path ) )
        {
            show_error( "Cache Directory is either does not exists or is not writable, please be sure to set it's permssions to 0777/rwxrwxrwx." );
            return;
        }

        if ( ! isset( $this->_lang_cache_file ) ) $this->_lang_cache_file = sprintf( "%s/%s+%s".EXT, $cache_path."_language", $this->_idiom, $this->_category );

        return $cache_path."_language";
    }


    // --------------------------------------------------------------------

	/**
	 * Load a language file
	 *
	 * @access	public
	 * @param	mixed	the name of the language file/category to be loaded. Can be an array
	 * @param	string	the language (english, etc.)
	 * @return	mixed
	 */
	function load( $category = '', $idiom = '', $return = FALSE )
	{
		// Substantiate class property with the requested category before it's formated
		$this->_category = $category;

		$category = str_replace( EXT, '', str_replace( '_lang.', '', $category ) ) . '_lang' . EXT;

		if( in_array( $category, $this->is_loaded, TRUE ) )
		{
			return;
		}

		if( empty( $idiom ) )
		{
			$CI = & get_instance();
			$deft_lang = $CI->config->item( 'language' );
			$idiom = ( empty( $deft_lang ) ) ? 'english' :$deft_lang;
		}

		// Substantiate class property with the requested idiom after the logic is applied
		$this->_idiom = $idiom;

		// Determine where the language file is and load it
		/*if( file_exists( APPPATH . 'language/' . $idiom . '/' . $category ) )
		{
			include ( APPPATH . 'language/' . $idiom . '/' . $category );
		}
		else
		{
			if( file_exists( BASEPATH . 'language/' . $idiom . '/' . $category ) )
			{
				include ( BASEPATH . 'language/' . $idiom . '/' . $category );
			}
			else
			{
				show_error( 'Unable to load the requested language: language/' . $category );
			}
		}*/
		$lang=array('');
		// No DB Class? Than why even bother running this? lol
		if( class_exists( 'CI_DB' ) )
		{
			
			// Set the CI super-object if not already
			if( ! isset( $CI ) )
			{
				$CI = & get_instance();
			}

			// Oh sweet, DB is loaded, but let's make sure everything is correct
			if( $this->_check() === TRUE )
			{
				$database_lang = $this->_get_db_lang();

				if( ! empty( $database_lang ) )
				{
					if( count( $lang ) > 0 )
					{
						
					}
					$lang = array_merge( $lang, $database_lang );
					//$lang = $database_lang;
					
				}
				else
				{
					if( count( $lang ) == 0 )
					{
						show_error( "Unable to load the requested language from the database: $this->_category " );
					}
				}
			}
		}

		if( ! isset( $lang ) )
		{
			log_message( 'error', 'Language contains no data: language/' . $idiom . '/' . $category );
			return;
		}
	
		if( $return == TRUE )
		{
			return $lang;
		}

		$this->is_loaded[] = $category;
		$this->language = array_merge( $this->language, $lang );
		//print_r($lang);
		unset( $lang );
		
		log_message( 'debug', 'Language file loaded: language/' . $idiom . '/' . $category );
		return TRUE;
	}

	// --------------------------------------------------------------------



	/**
	 * Fetch a single line of text from the language array
	 *
	 * @access	public
	 * @param	string	$line 	the language line
	 * @return	string
	 */
	function line( $line = '' )
	{
		$line = ( $line == '' or ! isset( $this->language[$line] ) ) ? FALSE : $this->language[$line];
		return $line;
	}

	/**
	 * Load a language from database
	 *
	 * @access	private
	 * @param 	bool 	[get language from cache?]
	 * @return	array
	 */
	private function _get_db_lang()
	{

		
		$return = array();

		/*if ( $this->_is_cache === TRUE && $this->cache_on )
		{
			return $this->_read_cache();
		}*/

		$CI = & get_instance();
		$db = $CI->db;

		$db->select( '*' );
		$db->from( $this->table_name );
		//$db->where( $this->field_idiom, $this->_idiom );
	//	$db->where( $this->field_category, $this->_category );

		$query = $db->get();
		//echo $db->last_query();
		foreach( $query->result() as $row )
		{
			$val="";
			if($this->_idiom=='arabic')
			$val=$this->arbfield_text;
			else
			$val=$this->field_text;
			$return[$row->{$this->field_key}] = $row->{$val};
		}

		unset( $query );

		if( $this->cache_on )
		{
			$this->_cache_lang( $return );
		}

		return $return;
	}


	private function _cache_lang($cached_values)
	{
		$CI = & get_instance();

		$CI->load->helper('file');

        $old_umask = umask(0);

        if ( ! is_dir($this->_lang_cache_path) )
        {
        	if ( ! mkdir($this->_lang_cache_path, 0777))
        	{
        		umask($old_umask);

                show_error( "Cannot create a language cache folder via automation.<br />
                Please create a folder labeled <em>_langauge</em> in your cache directory and make it read/writable by all (0777/rwxrwxrwx)." );
                return;
        	}
        }

        $cached_markup = sprintf("<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );\n\n \$lang = \"".htmlspecialchars( serialize( $cached_values ) )."\";\n\n?>" );

		if( ! write_file( $this->_lang_cache_file, $cached_markup , 'w+' ) )
		{
			umask( $old_umask );

			show_error( "Could not write to file, please make sure that the file is set to be read/writable by all (0777/rwxrwxrwx)." );
			return;
		}

		umask($old_umask);


	}

	private function _read_cache()
	{
		include_once ($this->_lang_cache_file);
		return unserialize(stripslashes(htmlspecialchars_decode($lang)));
	}

	/**
	 * Check to make sure we can even use the database
	 *
	 * @param 	CI_DB	[CI Database class object[
	 * @return 	bool
	 */
	private function _check()
	{
		$CI = & get_instance();

        // If we made it this far, there is not problem in substantiating these accessors
        if ( ! isset( $this->_lang_cache_path ) ) $this->_lang_cache_path = $this->_get_lang_cache_path();


        if( ! $CI->db->table_exists( $this->table_name ) )
		{
            $fields =
                 array (
                    $this->field_id =>
                        array (
                            'type' => 'INT',
                            'unsigned' => TRUE,
                            'auto_increment' => TRUE
                              ),
                    $this->field_key =>
                        array (
                            'type' => 'VARCHAR',
                            'constraint' => 100
                              ),
                    $this->field_idiom =>
                        array (
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'default' => 'english'
                              ),
                    $this->field_category =>
                        array (
                            'type' => 'VARCHAR',
                            'constraint' => 50,
                            'null' => TRUE
                              ),
                    $this->field_text =>
                        array (
                            'type' => 'TEXT',
                            'null' => TRUE
                              )
                       );

			$CI->load->dbforge();
			$CI->dbforge->add_field( $fields );
			$CI->dbforge->add_key( $this->field_id, TRUE );

			$_table_created = $CI->dbforge->create_table( $this->table_name, TRUE );

			if( ! $_table_created )
			{
				show_error( "There is no SQL table currently in your database called {$this->table_name} and
				    your permissions prevent one to be automatically created.
				    <br />To insert table manually simply run the following query:
				    <br /><br /><code>" . $CI->dbforge->db->last_query() . "</code>" );
			}
			else
			{
                show_error( "<strong>This is actually just a notification!</strong><br />The Language class went a head and created
                 a language database for you based on database constants you specified in the extended Language.php file (or language.php config file). <br /><br />
                 Query Ran: <br/>
                 <code>
                 " . $CI->dbforge->db->last_query() . "
                 </code><br /><br />
                 Simply refresh the page, and everything should work just fine!" );
			}
		}

        // Time to check the cache!
		if( file_exists( $this->_lang_cache_file ) && $this->cache_on )
		{
			$right_now = time();
			$last_modified = filemtime( $this->_lang_cache_file );

			$minutes = round(abs($right_now - $last_modified) / 60,2);

			if ($minutes < $this->cache_ttl)
			{
			     $this->_is_cache = TRUE;
			}
		}

		return TRUE;
	}

}
// END Language Class

/* End of file Language.php */
/* Location: .../application/libraries/Language.php */