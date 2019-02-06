<?php

class WPML_ST_Translations_File_Registration {

	const PATH_PATTERN_SEARCH_MO  = '#(-)?([a-z]+)([_A-Z]*)\.mo$#i';
	const PATH_PATTERN_REPLACE_MO = '${1}%s.mo';

	const PATH_PATTERN_SEARCH_JSON  = '#([a-z]+)([_A-Z]*)(-[-a-z0-9]+)\.json$#i';
	const PATH_PATTERN_REPLACE_JSON = '%s${3}.json';

	/** @var WPML_ST_Translations_File_Dictionary */
	private $file_dictionary;

	/** @var WPML_File */
	private $wpml_file;

	/** @var WPML_ST_Translations_File_Component_Details */
	private $components_find;

	/** @var array */
	private $active_languages;

	/** @var array */
	private $cache = array();

	/**
	 * @param WPML_ST_Translations_File_Dictionary        $file_dictionary
	 * @param WPML_File                                   $wpml_file
	 * @param WPML_ST_Translations_File_Component_Details $components_find
	 * @param array                                       $active_languages
	 */
	public function __construct(
		WPML_ST_Translations_File_Dictionary $file_dictionary,
		WPML_File $wpml_file,
		WPML_ST_Translations_File_Component_Details $components_find,
		array $active_languages
	) {
		$this->file_dictionary  = $file_dictionary;
		$this->wpml_file        = $wpml_file;
		$this->components_find  = $components_find;
		$this->active_languages = $active_languages;
	}

	public function add_hooks() {
		add_filter( 'override_load_textdomain', array( $this, 'cached_save_mo_file_info' ), 11, 3 );
		add_filter( 'pre_load_script_translations', array( $this, 'add_json_translations_to_import_queue' ), 10, 4 );
	}

	public function cached_save_mo_file_info( $override, $domain, $mo_file_path ) {
		if ( !isset( $this->cache[ $mo_file_path ] ) ) {
			$this->cache[ $mo_file_path ] = $this->save_file_info( $override, $domain, $mo_file_path );
		}

		return $this->cache[ $mo_file_path ];
	}

	/**
	 * @param string|false $translations translations in the JED format
	 * @param string $file
	 * @param string $handle
	 * @param string $domain
	 *
	 * @return string|false
	 */
	public function add_json_translations_to_import_queue( $translations, $file, $handle, $domain ) {
		if ( $file && !isset( $this->cache[ $file ] ) ) {
			$domain               = WPML_ST_JED_Domain::get( $domain, $handle );
			$this->cache[ $file ] = $this->save_file_info( $translations, $domain, $file );
		}

		return $translations;
	}

	public function save_file_info( $override, $domain, $file_path ) {
		$file_path_pattern = $this->get_file_path_pattern( $file_path );

		foreach ( $this->active_languages as $lang_data ) {
			$file_path_in_lang = sprintf( $file_path_pattern, $lang_data['default_locale'] );
			$this->register_single_file( $domain, $file_path_in_lang );
		}

		return $override;
	}

	/**
	 * @param $file_path
	 *
	 * @return string|string[]|null
	 * @throws InvalidArgumentException
	 */
	private function get_file_path_pattern( $file_path ) {
		$pathinfo  = pathinfo( $file_path );
		$file_type = isset( $pathinfo['extension'] ) ? $pathinfo['extension'] : null;

		switch( $file_type ) {
			case 'mo':
				return preg_replace( self::PATH_PATTERN_SEARCH_MO, self::PATH_PATTERN_REPLACE_MO, $file_path );

			case 'json':
				return preg_replace( self::PATH_PATTERN_SEARCH_JSON, self::PATH_PATTERN_REPLACE_JSON, $file_path );
		}

		throw new RuntimeException( 'The "' . $file_type . '" file type is not supported for registration' );
	}

	/**
	 * @param $domain
	 * @param $file_path
	 */
	private function register_single_file( $domain, $file_path ) {
		if ( ! $this->wpml_file->file_exists( $file_path ) ) {
			return ;
		}

		$relative_path = $this->wpml_file->get_relative_path( $file_path );
		$last_modified = $this->wpml_file->get_file_modified_timestamp( $file_path );
		$file          = $this->file_dictionary->find_file_info_by_path( $relative_path );

		if ( ! $file ) {
			if ( ! $this->components_find->is_component_active( $file_path ) ) {
				return;
			}

			$file = new WPML_ST_Translations_File_Entry( $relative_path, $domain );
			$file->set_last_modified( $last_modified );

			list( $component_type, $component_id ) = $this->components_find->find_details( $file_path );
			$file->set_component_type( $component_type );
			$file->set_component_id( $component_id );

			$this->file_dictionary->save( $file );
		} elseif ( $file->get_last_modified() !== $last_modified ) {
			$file->set_status( WPML_ST_Translations_File_Entry::NOT_IMPORTED );
			$file->set_last_modified( $last_modified );
			$file->set_imported_strings_count( 0 );

			$this->file_dictionary->save( $file );
		}
	}
}

