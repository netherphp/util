<?php

namespace Nether\Util;
use \Nether;

class File {

	static function Execute($__m_filename,$__m_scope=null) {

		// custom behaviours /////////////////////////////////////////////////

		if(strpos($__m_filename,'-') === 0) {

			// support loading via the autoloading mechanism.
			if(preg_match('/^-l\h?(.+?)$/',$__m_filename,$match)) {
				return class_exists("{$match[1]}",true);
			}

			// support some shorthand for referencing files from where the
			// framework currently resides.
			if(preg_match('/^-\//',$__m_filename) && defined('PROJECT_ROOT')) {
				$__m_filename = preg_replace(
					'/^-\//',
					sprintf('%s/',PROJECT_ROOT),
					$__m_filename
				);
			}
		}

		//////////////////////////////////////////////////////////////////////

		// check if the file we want exists.
		if(!file_exists($__m_filename) || !is_readable($__m_filename))
		return false;

		// populate the local scope if data was supplied. note this should
		// have been an associative array to actually receive proper data.
		if(is_array($__m_scope))
		extract($__m_scope);

		require($__m_filename);
		return true;
	}

}
