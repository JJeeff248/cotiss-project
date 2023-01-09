<?php
$feedback = $_POST['feedback'];
$rating = $_POST['rating'];

// Create connection to AWS dynamoDB
require 'vendor/autoload.php';

use Aws\DynamoDb\DynamoDbClient;

try {
    $client = DynamoDbClient::factory(array(
        'region' => 'ap-southeast-2',
        'version' => 'latest'
    ));

    $tableName = 'Cotiss-Feedback-DB';

    $response = $client->putItem(array(
        'Item' => array(
            'id' => array('N' => getUniqueId($client, $tableName)),
            'feedback' => array('S' => $feedback),
            'rating' => array('N' => $rating)
        ),
        'TableName' => $tableName
    ));

    print_r($response);
} catch (Exception $e) {
    echo $e->getMessage();
}

function getUniqueId($client, $tableName)
{
    $maxId = -1;

    try {
        $response = $client->scan(array(
            'TableName' => $tableName,
            'ProjectionExpression' => 'id'
        ));
    } catch (Exception $e) {
        return 0;
    }

    $items = $response->get('Items');
    $ids = array();

    foreach ($items as $item) {
        $ids[] = $item['id']['N'];
    }

    $maxId = max($ids);

    return (string) ($maxId + 1);
}

header('Location: /');
