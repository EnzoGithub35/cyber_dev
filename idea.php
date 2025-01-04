<?php

session_start();

// Initialize errors and form variables

// Handle the URL input and fetch data if 'url' parameter is set
$dataFetched = "";
if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // Define a whitelist of allowed URLs
    $allowed_urls = [
        'http://example.com',
        'https://example.com',
        // Add other allowed URLs here
    ];

    // Check if the URL is in the whitelist
    if (!in_array($url, $allowed_urls)) {
        die('URL not allowed');
    }

    // Validate the URL
    if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
        die('Invalid URL');
    }

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); // Verify SSL certificate

    // Execute cURL session and fetch data
    $dataFetched = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo '<div class="error">Error fetching data: ' . curl_error($ch) . '</div>';
    } else {
        echo '<div><strong>Fetched Data:</strong></div>';
        echo '<div class="error">' . htmlspecialchars($dataFetched) . '</div>';
    }

    // Close cURL session
    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSRF Vulnerability Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
            color: white;
            padding: 14px 16px;
        }

        .navbar a {
            float: left;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .main {
            margin: 15px;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .error {
            color: red;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="index.php">Hacker Stories</a>
        <!-- Add other navigation items here if needed -->
    </div>

    <div class="main">
        <h2>Get Idea</h2>
        <form action="idea.php" method="GET">
            <label for="url">Enter URL to fetch data from:</label>
            <input type="text" id="url" name="url" placeholder="http://example.com">
            <button type="submit">Fetch Data</button>
        </form>
        <?php
        if (isset($_GET['url'])) {
            $url = $_GET['url'];

            // Define a whitelist of allowed URLs
            $allowed_urls = [
                'http://example.com',
                'https://example.com',
                // Add other allowed URLs here
            ];

            // Check if the URL is in the whitelist
            if (!in_array($url, $allowed_urls)) {
                echo '<div class="error">URL not allowed</div>';
            } else {
                // Validate the URL
                if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
                    echo '<div class="error">Invalid URL</div>';
                } else {
                    // Initialize cURL session
                    $ch = curl_init();

                    // Set cURL options
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); // Verify SSL certificate

                    // Execute cURL session and fetch data
                    $dataFetched = curl_exec($ch);

                    // Check for cURL errors
                    if (curl_errno($ch)) {
                        echo '<div class="error">Error fetching data: ' . curl_error($ch) . '</div>';
                    } else {
                        echo '<div><strong>Fetched Data:</strong></div>';
                        echo '<div class="error">' . htmlspecialchars($dataFetched) . '</div>';
                    }

                    // Close cURL session
                    curl_close($ch);
                }
            }
        }
        ?>
    </div>
</body>

</html>