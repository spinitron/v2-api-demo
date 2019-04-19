<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Spinitron v2 API demo</title>
    <meta name="Description" content="Demonstrates using the Spinitron v2 API with PHP and AJAX refresh.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
<div class="main-container">
    <div class="main">

        <div class="widget-box">
            <h2>Recent spins</h2>

            <div id="spin-recent"><?php include(__DIR__ . '/recent.php') ?></div>

            <h2>Coming up later today</h2>

            <div id="spin-shows"><?php include(__DIR__ . '/today.php') ?></div>
        </div>

        <div class="widget-docs">
            <h1>Spinitron API demo in PHP</h1>

            <p class="github">
                <a href="https://github.com/spinitron/v2-api-demo">Source code</a> for this demo
                web site is on Github
            </p>

            <p>This page shows how to use the
                <a href="https://spinitron.github.io/v2api/">Spinitron v2 API</a> in a web page
                using PHP directly and with JavaScript and Ajax to update a page automatically
                from the browser.</p>

            <p>For integration of content from Spinitron using iframe and JavaScript widgets see the
                <a href="https://spinitron.github.io/v2-web-integration/">v2 Web Intragration Demo</a></p>

            <p>In the yellow box, the recent spins and upcoming shows use API data.
                When the server generates this page, it renders two PHP partial views,
                <code>recent.php</code> and <code>today.php</code>.
                These fetch data from the API and render it as HTML.
                Additionally, a client-side JavaScript refreshes the recent spins every five
                seconds with an Ajax request to <code>recent.php</code>.</p>

            <h2>Overview</h2>

            <p>The files in this demo are organized as follows:</p>

            <pre>├── app
│   ├── getClient.php
│   └── SpinitronApiClient.php
├── cache
└── www
    ├── css
    ├── index.php
    ├── recent.php
    └── today.php</pre>

            <ul>
                <li><code>app</code> has a simple caching client class for the
                    Spinitron v2 API and a script that instantiates it with your API key.
                </li>
                <li><code>cache</code> holds the temporary cache data files.</li>
                <li><code>www</code> has this page and the two partial views <code>recent.php</code>
                    and <code>today.php</code>.
                </li>
            </ul>

            <h2>Try it yourself</h2>

            <p>If you have a computer with PHP, you can run this demo locally and modify it:</p>
            <ul>
                <li>Download and upzip the <a href="https://github.com/spinitron/v2-api-demo/archive/master.zip">zip
                        file</a> (or clone the repo)</li>

                <li>Create a file <code>api-key.txt</code> in the root directory (beside the <code>app</code> and
                    <code>www</code> directories) containing
                    your API key, which you can find in the admin area of Spinitron v2</li>

                <li>Open a command shell and in the <code>www</code> directory start a test PHP web server:
                    <pre><code>php -S localhost:8000</code></pre></li>

                <li>Go to <code>http://localhost:8000/</code> in a browser.</li>
            </ul>

            <p>To use this approach in your web site, adapt the examples in the <code>www</code> directory.
                Make sure the <code>app</code> and <code>cache</code> directories
                are outside your web server's document root. If you move the <code>app</code> directory
                relative to <code>www</code> then update the line that includes <code>getClient.php</code>
                in the partial views.</p>

            <p><code>SpinitronApiClient.php</code> is not complex so if you know PHP, take a look.</p>

            <h2>How it works</h2>

            <p><code>index.php</code> is this page. It is ordinary HTML with only two interesting parts. First,
                inside the <code>&lt;div class="widget-box"&gt;</code> block are two PHP blocks that render the
                output of <code>recent.php</code> and <code>today.php</code> into this page as it is loaded.
                Second, at the bottom of the page is
                a JavaScript that uses AJAX to replace the content of the
                <code>&lt;div id="spin-recent"&gt;</code> block every five seconds.</p>

            <p><code>recent.php</code> and <code>today.php</code> are <em>partial views</em>, which means they output
                fragments of HTML to be placed inside something else. In our case the fragments are put into
                <code>&lt;div&gt;</code> blocks on this page.
                Look in <code>recent.php</code>. First it loads the client. Next it
                uses the client to get data from the API. Finally it uses a
                <a href="http://php.net/manual/en/control-structures.alternative-syntax.php">PHP
                    <code>foreach</code></a>
                loop to generate a number of
                <code>&lt;p&gt;</code> elements, each containing text describing a recent spin.
                <code>today.php</code> is very similar.</p>

            <p>If you have the test web server running, as described above, you can view the output of these partial
                views in your browser by navigating to and viewing the page source of the following URLs:

            <pre><code>http://localhost:8000/recent.php
http://localhost:8000/today.php</code></pre>

            <p>Both partial views use the following line to bootstrap a <code>SpinitronApiClient</code>.</p>

            <pre><code>include __DIR__ . '/../app/getClient.php';</code></pre>

            <p><code>getClient.php</code> instantiates a <code>SpinitronApiClient</code> object
                using your API key and saves it to the global variable <code>$client</code>.
                It offers simple generic methods <code>search()</code> and <code>fetch()</code> to get
                data from the API. <code>recent.php</code> loads the most recent three songs
                with <code>$client->search('spins', ['count' => 3])</code> and
                <code>today.php</code> loads the upcoming schedule in a similar way.
                Read <code>SpinitronApiClient</code> itself for more detail—it's not complex.
                See also the <a href="https://spinitron.github.io/v2api/">API documentation</a>.</p>

            <h3>To summarize</h3>

            <p>The two partial views <code>recent.php</code> and <code>today.php</code>:</p>
            <ol>
                <li>include <code>getClient.php</code>, which provides a <code>SpinitronApiClient</code> object,</li>
                <li>use the client to get data from Spinitron,</li>
                <li>generate fragments of HTML (to display the data) as output.</li>
            </ol>
            <p>The main web page <code>index.php</code>:</p>
            <ol>
                <li>on initial page load, inserts the HTML fragments output by the partial views into the page using PHP
                    <code>include()</code>,
                </li>
                <li>initializes a JavaScript in the client's web browser that to
                    replace the list of recent spins with freshly loaded output of <code>recent.php</code>
                    every five seconds.
                </li>
            </ol>

            <h2>Garbage collection</h2>

            <p><code>SpinitronApiClient</code> doesn't collect garbage, i.e. it does not delete expired cache files.
                If, like this demo, all your queries use static parameters, e.g. <code>['spins', 3]</code>
                or <code>['end', '+6 hour']</code>, then you don't
                need garbage collection since stale cache files will not proliferate.
                But if your queries have variable parameters, e.g. date-times, then you probably need it.</p>

            <p>Searching through cache files to find expired ones can take time so it's good to decouple it from
                page request processing, which is the only time <code>SpinitronApiClient</code> is used in this demo.
                So <code>SpinitronApiClient</code> collects cache files together according to their lifetimes.
                The name of each top level directory in the cache is the expiration time in seconds of
                the cache files it contains, e.g.</p>

            <pre>/var/www/v2-api-demo/cache
├── 30
│   └── spins?count=3
└── 900
    └── shows?end=%2B6+hour</pre>

            <p>This allows other programs to figure which files are expired.
                For example, I put this in <code>/etc/cron.hourly</code> of the Debian system running this demo
                (not that the demo actually needs it)</p>

            <pre><code>#!/bin/bash

d=/var/www/v2-api-demo/cache
for f in `ls $d`; do
    let m=($f+59)/60
    find "$d/$f" -type f -mmin +$m -delete
done</code></pre>

            <h2>Caveat</h2>

            <p><code>SpinitronApiClient</code> is very basic. It has no dependencies and should work on older
                versions of PHP. It was designed to demonstrate making API requests and file caching so you could
                adapt it to your needs. It is not supposed to be a robust API client. Feel free to use it if it
                works for you but consider also using
                <a href="https://duckduckgo.com/?q=rest+api+client+guzzle&ia=web">other API and HTTP clients</a>.</p>

            <h2>In closing</h2>

            <p>Spinitron's terms of service require that you have access credentials in order to use the API
                and that you don't share them with other entities. We also require that you use a cache. This
                demo uses a file-based cache.</p>

            <p>As always, for support contact Eva at Spinitron on 617 233 3115 or by email at
                <a href="mailto:eva@spinitron.com">eva@spinitron.com</a>.</p>
        </div>
    </div>
</div>

<script>
    (function () {
        // We stop the timer after some time as this is just a demo.
        var iterations = 50;
        var fetch = function () {
            var request = new XMLHttpRequest();
            request.onload = function () {
                document.querySelector('#spin-recent').innerHTML = request.responseText;

                iterations -= 1;
                if (iterations <= 0) {
                    return;
                }

                setTimeout(fetch, 5000);
            };
            request.open('GET', 'recent.php', true);
            request.send();
        };
        fetch();
    }());
</script>
</body>
</html>
