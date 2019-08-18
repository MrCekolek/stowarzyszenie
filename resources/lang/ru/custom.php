<?php
return [
    "controllers" => [
        "auth" => [
            "change" => ["activated" => "Аккаунт успешно активирован."],
            "login" => [
                "no_email_or_password" => "Введенный вами адрес электронной почты или пароль неверны.",
                "not_activated" => "Аккаунт не был активирован."
            ],
            "logout" => ["logged_out" => "Вы успешно вышли из системы."],
            "row_not_found" => ["wrong_token" => "Токен недействителен."],
            "signup" => ["send_activation" => "Письмо с подтверждением отправлено."]
        ],
        "change_password" => [
            "change" => ["changed" => "Пароль был успешно изменен."],
            "row_not_found" => ["wrong_email_or_token" => "Токен или электронная почта недействительны."]
        ],
        "reset_password" => ["send_email" => ["sent" => "Письмо для смены пароля было успешно отправлено."]]
    ]
];
