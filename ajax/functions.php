<?php

function lt_send_email($message)
{
    require_once LT_PATCH . '/libs/mailer/PHP_Mailer.php';

    $mail = new PHP_Mailer();

    $email = get_option('email');
    $mail->AddAddress($email); // Можно указать несколько адресов через запятую. Например "1@mail.ru, 2@mail.ru"

    $project = "Лесторг";
    $mail->Subject = "Заявка с сайта \"$project\"";
    $mail->FromName = $project;

    // other setting
    $mail->From = "noreply@" . $_SERVER['SERVER_NAME'];
    $mail->IsHTML(true);

    $mail->Body = $message;

    $result = $mail->Send();

    wp_send_json([
        'errors' => !empty($result) ? false : 'Mailer Error: ' . $mail->ErrorInfo
    ]);
}

add_action('wp_ajax_nopriv_lt_ajax_send_forms', 'lt_ajax_send_forms');
function lt_ajax_send_forms()
{
    $data = $_POST['form_data'] ?? [];
    if (!$data && !is_array($data)) return;

    $c = true;
    $message = '';
    foreach ($data as $name => $value) {

        if (!$name || !$value) continue;

        // Только для quiz
        if ($name == 'other_region') continue;
        if ($value == 'other_region') {
            $value = $data['other_region'] ?? '';
        }

        $message .= ($c = !$c) ? '<tr>' . PHP_EOL : '<tr style="background-color: #f8f8f8;">' . PHP_EOL;
        $message .= '<td style="padding: 10px; border: #dedede 1px solid;"><b>' . $name . '</b></td>' . PHP_EOL;
        $message .= '<td style="padding: 10px; border: #dedede 1px solid;">' . $value . '</td>' . PHP_EOL;
        $message .= '</tr>' . PHP_EOL;
    }

    $message = '<table style="border-collapse: collapse; border-spacing: 0;">' . $message . '</table>';

    lt_send_email($message);

    wp_die();
}
