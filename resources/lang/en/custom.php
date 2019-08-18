<?php
return [
    "controllers" => [
        "auth" => [
            "change" => ["activated" => "Account successfully activated."],
            "login" => [
                "no_email_or_password" => "The email or password you entered is incorrect.",
                "not_activated" => "Account has not been activated."
            ],
            "logout" => ["logged_out" => "You have successfully logged out."],
            "row_not_found" => ["wrong_token" => "The token is invalid."],
            "signup" => ["send_activation" => "A verification email has been sent."]
        ],
        "change_password" => [
            "change" => ["changed" => "Password has been successfully changed."],
            "row_not_found" => ["wrong_email_or_token" => "Token or Email are invalid."]
        ],
        "reset_password" => [
            "send_email" => ["sent" => "Email to change password has been sent successfully."]
        ]
    ]
];
