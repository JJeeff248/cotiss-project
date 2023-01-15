<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Feedback | Cotiss</title>
    <link rel="icon" href="https://static.chris-sa.com/cotiss-logo.svg">

    <link rel="stylesheet" href="https://www.cotiss.com/hs-fs/hub/20404630/hub_generated/template_assets/54247107751/1669780009956/marketplace/kalungi_com/Atlas_Pro_SaaS_Website_Theme/css/main.min.css" />
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <img src="https://static.chris-sa.com/cotiss-logo.svg" alt="Cotiss Logo">
        <h1>Honest-Feedback</h1>
    </header>
    <main>
        <section class="feedback">
            <h1>Previous Feedback</h1>
            <?php
            require 'vendor/autoload.php';

            use Aws\DynamoDb\DynamoDbClient;

            try {
                $client = DynamoDbClient::factory(array(
                    'region' => 'ap-southeast-2',
                    'version' => 'latest'
                ));

                $tableName = 'Cotiss-Feedback-DB';

                $response = $client->scan(array(
                    'TableName' => $tableName
                ));

                $items = $response->get('Items');

                $feedback = $items[array_rand($items)];

                echo '<div class="feedback-container">';
                if ($feedback['rating']['N'] == '1') {
                    echo '<ion-icon name="thumbs-down-outline"></ion-icon>';
                } elseif ($feedback['rating']['N'] == '2') {
                    echo '<ion-icon name="remove-outline"></ion-icon>';
                } elseif ($feedback['rating']['N'] == '3') {
                    echo '<ion-icon name="thumbs-up-outline"></ion-icon>';
                }
                echo '<p>' . $feedback['feedback']['S'] . '</p></div>';
            } catch (Exception $e) {
                echo '<p>There was an error retrieving feedback</p>';
                echo '<p>' . $e->getMessage() . '</p>';
            }
            ?>
        </section>

        <section class="form">
            <h1>Honest-Feedback</h1>
            <form action="feedback.php" method="post">
                <label for="feedback">Feedback</label>
                <textarea name="feedback" id="feedback" cols="30" rows="10" required></textarea>
                <label for="rating">Rating</label>
                <span class="radio-tile-group">
                    <div class="input-container">
                        <input id="thumbs-down" type="radio" name="rating" value="1" required />
                        <div class="radio-tile" id="negative">
                            <ion-icon name="thumbs-down-outline"></ion-icon>
                            <label for="rating">Negative</label>
                        </div>
                    </div>

                    <div class="input-container">
                        <input id="thumbs-up" type="radio" name="rating" value="2" />
                        <div class="radio-tile">
                            <ion-icon name="remove-outline"></ion-icon>
                            <label for="rating">Netural</label>
                        </div>
                    </div>

                    <div class="input-container">
                        <input id="thumbs-up" type="radio" name="rating" value="3" />
                        <div class="radio-tile" id="positive">
                            <ion-icon name="thumbs-up-outline"></ion-icon>
                            <label for="rating">Positive</label>
                        </div>
                    </div>
                </span>

                <button type="submit">Submit</button>
            </form>
        </section>

    </main>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>