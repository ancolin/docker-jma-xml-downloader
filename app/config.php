<?php

/**
 * JMA XML Downloader
 * @author  ancolin
 * @since   2017/07/09
 */

// xml dir
$feed_dir_base = getenv('FEED_DIR');
$data_dir_base = getenv('DATA_DIR');

// set atom feed urls
$shorter = array();
$longer = array();
if (getenv('DATA_TYPE_REGULAR') == 'true') {
    $shorter[] = 'http://www.data.jma.go.jp/developer/xml/feed/regular.xml';
    $longer[] = 'http://www.data.jma.go.jp/developer/xml/feed/regular_l.xml';
}
if (getenv('DATA_TYPE_EXTRA') == 'true') {
    $shorter[] = 'http://www.data.jma.go.jp/developer/xml/feed/extra.xml';
    $longer[] = 'http://www.data.jma.go.jp/developer/xml/feed/extra_l.xml';
}
if (getenv('DATA_TYPE_EQVOL') == 'true') {
    $shorter[] = 'http://www.data.jma.go.jp/developer/xml/feed/eqvol.xml';
    $longer[] = 'http://www.data.jma.go.jp/developer/xml/feed/eqvol_l.xml';
}
if (getenv('DATA_TYPE_OTHER') == 'true') {
    $shorter[] = 'http://www.data.jma.go.jp/developer/xml/feed/other.xml';
    $longer[] = 'http://www.data.jma.go.jp/developer/xml/feed/other_l .xml';
}
