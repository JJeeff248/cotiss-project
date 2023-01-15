# AWS Solution for an Honest Feedback System

> Created by: Chris Sa  
> Last updated: 2023-01-15

## Table of contents

- [AWS Solution for an Honest Feedback System](#aws-solution-for-an-honest-feedback-system)
  - [Table of contents](#table-of-contents)
  - [Project overview](#project-overview)
  - [Implementation outline](#implementation-outline)
  - [Demonstration video](#demonstration-video)
  - [Files](#files)
    - [Index (frontend)](#index-frontend)
    - [Feedback (backend)](#feedback-backend)

## Project overview

The goal of level 1 is to create a simple feedback system that allows users to submit feedback and view a random piece of feedback. The system should be hosted on AWS and use DynamoDB to store the feedback.

## Implementation outline

## Demonstration video

To see a walkthrough of the project, please click [here](https://www.youtube.com/watch?v=h12FAoD_vNQ).

## Files

For this project PHP was used to create the frontend and backend. The frontend page has a simple form that allows users to submit feedback. The backend is a PHP file that stores the feedback in a DynamoDB table.

Both files need to connect to the database, to do this the following code is used:

```php
require 'vendor/autoload.php';

use Aws\DynamoDb\DynamoDbClient;

$client = DynamoDbClient::factory(array(
    'region' => 'ap-southeast-2',
    'version' => 'latest'
));

$tableName = 'Cotiss-Feedback-DB';
```

The full files can be found in the project's [GitHub repository](https://github.com/JJeeff248/cotiss-project/tree/main/website)

### Index (frontend)

The index file is the main file for the project. It should be structured as follows:

A random piece of feedback should be pulled from the database and displayed at the top of the page. This is done by using the following code:

```php
$response = $client->scan(array(
   'TableName' => $tableName
));

$items = $response->get('Items');

$feedback = $items[array_rand($items)];
```

The form should have the following fields:

- Feedback (text)
- Rating (number)

### Feedback (backend)

The feedback file is the backend file for the project. It should be structured to take the form data from the index file and store it in the database. The following code can be used to store the data:

```php
$response = $client->putItem(array(
   'Item' => array(
      'id' => array('N' => $id),
      'feedback' => array('S' => $feedback),
      'rating' => array('N' => $rating)
   ),
   'TableName' => $tableName
));
```
