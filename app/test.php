<?php
Mail::mailer("smtp")->to("alinikokherad@gmail.com")->send(new \App\Mail\NewUserNotification);
dd("done");
/*require '../vendor/autoload.php';
use \Mailjet\Resources;
$mj = new \Mailjet\Client('5c04b68c96cfc690e6aa20464160b810','427f879f251879120692090af310cc41',true,['version' => 'v3.1']);
$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => "newin4mations@gmail.com",
                'Name' => "ali"
            ],
            'To' => [
                [
                    'Email' => "newin4mations@gmail.com",
                    'Name' => "ali"
                ]
            ],
            'Subject' => "Greetings from Mailjet.",
            'TextPart' => "My first Mailjet email",
            'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
            'CustomID' => "AppGettingStartedTest"
        ]
    ]
];
$response = $mj->post(Resources::$Email, ['body' => $body]);
$response->success() && var_dump($response->getData());
dd("done");*/
