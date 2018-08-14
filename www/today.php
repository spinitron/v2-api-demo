<?php

include __DIR__ . '/../app/getClient.php';
/** @var SpinitronApiClient $client */
$result = $client->search('shows', ['end' => '+6 hour']);

?>

<?php foreach ($result['items'] as $show): ?>
    <p><?= (new DateTime($show['start']))
            ->setTimezone(new DateTimeZone($show['timezone'] ?? 'America/New_York'))
            ->format('g:ia') ?>
        <b><?= htmlspecialchars($show['title'], ENT_NOQUOTES) ?></b></p>
<?php endforeach ?>
