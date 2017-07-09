<?php
require_once('config.php');

/**
 * JMA XML Downloader
 * @author  ancolin
 * @since   2017/07/09
 */

// select atom feed urls
$feed_urls = array();
if (isset($argv[1])) {
    if ($argv[1] == 'longer') {
        $feed_urls = $longer;
    } else if (($argv[1] == 'shorter')) {
        $feed_urls = $shorter;
    }
    if (empty($feed_urls)) {
        echo "feed url does not exist.\n";
        echo "check docker-compose.yml.\n";
        exit;
    }
} else {
    echo "error.\n";
    exit;
}

foreach ($feed_urls as $feed_url) {

    // get atom feed
    $feed_xml = getContent($feed_url);

    // analyze atom feed
    $feed = simplexml_load_string($feed_xml);
    $feed_updated = array(
        'date' => date('Ymd', strtotime($feed->updated)),
        'time' => date('His', strtotime($feed->updated)),
    );

    // save atom feed
    $feed_dir = $feed_dir_base . '/' . $feed_updated['date'];
    $feed_name = $feed_dir . '/' . $feed_updated['time'] . '_'. basename($feed_url);
    if (!file_exists($feed_name)) {
        if (!file_exists($feed_dir)) {
            mkdir($feed_dir, 0777, true);
        }
        file_put_contents($feed_name, $feed_xml);

        // check new data exists
        foreach ($feed->entry as $entry) {
            $data_url = $entry->link['href'];
            $data_updated = array(
                'date' => date('Ymd', strtotime($entry->updated)),
                'time' => date('His', strtotime($entry->updated)),
            );
            $data_dir = $data_dir_base . '/' . $data_updated['date'];
            $data_name = $data_dir . '/' . $data_updated['time'] . '_'. basename($data_url);

            // get new data
            if (!file_exists($data_name)) {
                if (!file_exists($data_dir)) {
                    mkdir($data_dir, 0777, true);
                }
                $data_xml = getContent($data_url);
                file_put_contents($data_name, $data_xml);
            }
        }
    }
}

/**
 * @param string $url
 * @return string $content
 */
function getContent(string $url) {
    // init curl
    $ch = curl_init();

    // set curl options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // get content
    $content = curl_exec($ch);
    curl_close($ch);

    return $content;
}
