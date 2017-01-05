<?php
	if ($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
	    define('KEY_DOCTREE', 'local:devcms:DocTrees');
	    define('KEY_DOC_SVNLOG', 'local:devcms:docsvnlog');
	    define('CACHE_TIME_DEFAULT',60);
	} else {
	    define('KEY_DOCTREE', 'devcms:DocTrees');
	    define('KEY_DOC_SVNLOG', 'devcms:docsvnlog');
	    define('CACHE_TIME_DEFAULT',600);
	}
?>