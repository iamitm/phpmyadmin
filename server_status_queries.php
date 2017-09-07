<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */

/**
 * Displays query statistics for the server
 *
 * @package PhpMyAdmin
 */

use PhpMyAdmin\Response;
use PhpMyAdmin\Message;
use PhpMyAdmin\Server\Status\Data;

require_once 'libraries/common.inc.php';
require_once 'libraries/server_common.inc.php';
require_once 'libraries/server_status_queries.lib.php';
require_once 'libraries/replication.inc.php';
require_once 'libraries/replication_gui.lib.php';

$serverStatusData = new Data();

$response = Response::getInstance();
$header   = $response->getHeader();
$scripts  = $header->getScripts();

// for charting
$scripts->addFile('chart.js');
$scripts->addFile('vendor/jqplot/jquery.jqplot.js');
$scripts->addFile('vendor/jqplot/plugins/jqplot.pieRenderer.js');
$scripts->addFile('vendor/jqplot/plugins/jqplot.highlighter.js');
$scripts->addFile('vendor/jqplot/plugins/jqplot.enhancedPieLegendRenderer.js');
$scripts->addFile('vendor/jquery/jquery.tablesorter.js');
$scripts->addFile('server_status_sorter.js');
$scripts->addFile('server_status_queries.js');

// Add the html content to the response
$response->addHTML('<div>');
$response->addHTML($serverStatusData->getMenuHtml());
if ($serverStatusData->dataLoaded) {
    $response->addHTML(PMA_getHtmlForQueryStatistics($serverStatusData));
} else {
    $response->addHTML(
        Message::error(
            __('Not enough privilege to view query statistics.')
        )->getDisplay()
    );
}
$response->addHTML('</div>');
exit;
