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
    ],
    "crud" => [
        "fail" => [
            "create" => "Error adding data.",
            "delete" => "Data delete error.",
            "read" => "Data download error.",
            "update" => "Data modification error."
        ],
        "success" => [
            "create" => "Data added successfully.",
            "delete" => "Successfully deleted data.",
            "read" => "Data read successfully.",
            "update" => "The data has been successfully modified."
        ]
    ],
    "blade" => [
        "passwordReset" => [
            "change_request" => "Change Password Request",
            "before_information" => "Click on the button below to change password.",
            "button_name" => "Reset Password",
            "after_information" => "Thanks,"
        ],
        "signUp" => [
            "signup_request" => "Account authentication",
            "before_information" => "Click on the button below to activate account.",
            "button_name" => "Activate Account",
            "after_information" => "Thanks,"
        ]
    ]
];
