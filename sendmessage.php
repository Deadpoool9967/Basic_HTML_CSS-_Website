<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = '';
    foreach ($_POST as $key => $value) {
        if ($value) {
            $content .= "<b>$key</b>: <i>$value</i>\n";
        }
    }

    if (trim($content)) {
        $content = "<b>Message from site:</b>\n" . $content;
        $apiToken = "6716252915:AAGqfNmbrscREHmvKrpa2tjhG04m53epKFQ";
        $data = [
            'chat_id' => '@orphelporg',
            'text' => $content,
            'parse_mode' => 'HTML'
        ];

        $url = "https://api.telegram.org/bot$apiToken/sendMessage?" . http_build_query($data);

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if ($result !== false) {
            $responseData = json_decode($result, true);

            if ($responseData && isset($responseData['ok']) && $responseData['ok']) {
                echo 'Form sent successfully!';
            } else {
                echo 'Error sending form!';
            }
        } else {
            // Handle file_get_contents error
            echo 'Error with file_get_contents';
        }
    }
} else {
    // Return an error for other methods
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>
