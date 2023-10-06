<?php

include __DIR__ . '/../app/getClient.php';
/** @var SpinitronApiClient $client */
$shows = $client->search('shows', ['count' => 5]);

?>

<?php foreach ($shows['items'] as $show): 

    $show_title = htmlspecialchars($show['title'], ENT_NOQUOTES);
    $show_image = htmlspecialchars($show['image'], ENT_NOQUOTES);
    $show_start = (new DateTime($show['start']))->setTimezone(new DateTimeZone($show['timezone'] ?? 'America/Los_Angeles'));
    $show_end = (new DateTime($show['end']))->setTimezone(new DateTimeZone($show['timezone'] ?? 'America/Los_Angeles'));
    $time_now = (new DateTime('now'))->setTimezone(new DateTimeZone($show['timezone'] ?? 'America/Los_Angeles'));
    
    $persona_url = $show['_links']['personas'][0]['href'];
    $persona_parts = explode('/', $persona_url);
    $persona_id = end($persona_parts);
    $persona_array = $client->fetch('personas', $persona_id);
    $show_dj = $persona_array['name'];

    if ($show_start <= $time_now && $time_now <= $show_end) {
        $show_status = 'On air';
    } else {
        $show_status = 'Up next';
    }

    echo(
        '<div class="spinitron-player">
            <div class="show-image">
                <img src="' . $show_image . '" alt="' . $show_title . '" />
            </div>
            <div class="show-details">
                <p class="show-status">' . $show_status . '</p>
                <p class="show-title">' . $show_title . '</p>
                <p class="show-time">' . $show_start->format('g:i A') . ' - ' . $show_end->format('g:i A') . ' with ' . $show_dj . '</p>
            </div>
        </div>'
    );

endforeach ?>

<style>
    body {
        font-family: sans-serif;
    }

    .spinitron-player {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 600px;
        background: #f1f1f1;
        margin: 0 0 20px;
    }

    /* Left */

    .show-image img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        object-position: center;
    }


    /* Right */

    .show-details {
        flex: 1;
        padding: 20px 30px;
    }

    .show-details .show-status {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
    }

    .show-details .show-title {
        font-size: 22px;
        font-weight: 700;
        margin: 10px 0 15px;
    }

    .show-details .show-time {
        font-size: 14px;
        margin: 0;
    }
</style>