<?php

class WPML_ST_Translations_File_Locale {

	const PATTERN_SEARCH_LANG_MO   = '#[-]?([a-z]+[_A-Z]*)\.mo$#i';
	const PATTERN_SEARCH_LANG_JSON = '#([a-z]+[_A-Z]*)-[-a-z0-9]+\.json$#i';

	/** @var string $filepath */
	private $filepath;

	/**
	 * @param string $filepath
	 */
	public function __construct( $filepath ) {
		$this->filepath = $filepath;
	}

	/**
	 * It extracts language code from mo file path, examples
	 * '/wp-content/languages/admin-pl_PL.mo' => 'pl'
	 * '/wp-content/plugins/sitepress/sitepress-hr.mo' => 'hr'
	 * '/wp-content/languages/fr_FR-4gh5e6d3g5s33d6gg51zas2.json' => 'fr_FR'
	 *
	 * @return string
	 * @throws RuntimeException
	 */
	public function get() {
		switch( $this->get_extension() ) {
			case 'mo':
				$search = self::PATTERN_SEARCH_LANG_MO;
				break;

			case 'json':
				$search = self::PATTERN_SEARCH_LANG_JSON;
				break;

			default:
				throw new RuntimeException( 'Unable to parse the language from the translations file ' . $this->filepath );
		}

		$i = preg_match( $search, $this->filepath, $matches );
		if ( $i && isset( $matches[1] ) ) {
			return $matches[1];
		}

		throw new RuntimeException( 'Language of ' . $this->filepath. ' cannot be recognized' );
	}

	/** @return string|null */
	private function get_extension() {
		$pathinfo  = pathinfo( $this->filepath );
		return isset( $pathinfo['extension'] ) ? $pathinfo['extension'] : null;
	}
}
