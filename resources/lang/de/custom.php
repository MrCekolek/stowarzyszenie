<?php
return [
    "controllers" => [
        "auth" => [
            "change" => ["activated" => "Konto erfolgreich aktiviert."],
            "login" => [
                "no_email_or_password" => "Die eingegebene E-Mail-Adresse oder das eingegebene Passwort ist falsch.",
                "not_activated" => "Konto wurde nicht aktiviert."
            ],
            "logout" => ["logged_out" => "Sie haben sich erfolgreich abgemeldet."],
            "row_not_found" => ["wrong_token" => "Das Token ist ungültig."],
            "signup" => ["send_activation" => "Eine Bestätigungs-E-Mail wurde gesendet."]
        ],
        "change_password" => [
            "change" => ["changed" => "Passwort wurde erfolgreich geändert."],
            "row_not_found" => ["wrong_email_or_token" => "Token oder E-Mail sind ungültig."]
        ],
        "reset_password" => [
            "send_email" => ["sent" => "E-Mail zum Ändern des Passworts wurde erfolgreich gesendet."]
        ]
    ],
    "crud" => [
        "fail" => [
            "create" => "Fehler beim Hinzufügen der Daten.",
            "delete" => "Fehler beim Löschen der Daten.",
            "read" => "Fehler beim Herunterladen der Daten.",
            "update" => "Datenänderungsfehler."
        ],
        "success" => [
            "create" => "Daten erfolgreich hinzugefügt.",
            "delete" => "Daten erfolgreich gelöscht.",
            "read" => "Daten erfolgreich gelesen.",
            "update" => "Die Daten wurden erfolgreich geändert."
        ]
    ]
];
