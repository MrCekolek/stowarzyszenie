<?php
return [
    "controllers" => [
        "auth" => [
            "change" => ["activated" => "Konto pomyślnie aktywowane."],
            "login" => [
                "no_email_or_password" => "Podany email lub hasło są niepoprawne.",
                "not_activated" => "Konto nie zostało aktywowane."
            ],
            "logout" => ["logged_out" => "Pomyślnie wylogowano."],
            "row_not_found" => ["wrong_token" => "Token jest niepoprawny."],
            "signup" => ["send_activation" => "Email weryfikacyjny został wysłany."]
        ],
        "change_password" => [
            "change" => ["changed" => "Hasło zostało pomyślnie zmienione."],
            "row_not_found" => ["wrong_email_or_token" => "Token lub Email są niepoprawne."]
        ],
        "reset_password" => ["send_email" => ["sent" => "Email do zmiany hasła został wysłany pomyślnie."]]
    ],
    "crud" => [
        "fail" => [
            "create" => "Błąd dodawania danych.",
            "delete" => "Błąd usuwania danych.",
            "read" => "Błąd pobierania danych.",
            "update" => "Błąd modyfikacji danych."
        ],
        "success" => [
            "create" => "Pomyślnie dodano dane.",
            "delete" => "Pomyślnie usunięto dane.",
            "read" => "Pomyślnie odczytano dane.",
            "update" => "Pomyślnie zmodyfikowano dane."
        ]
    ]
];
