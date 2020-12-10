<?php

include __DIR__ . '/Mailchimp/Mailchimp.php';
include __DIR__ . '/Mailjet/Mailjet.php';
include __DIR__ . '/SendGrid/SendGrid.php';
include __DIR__ . '/SendinBlue/SendinBlue.php';
include __DIR__ . '/Hubspot/Hubspot.php';
include __DIR__ . '/ActiveCampaign/ActiveCampaign.php';
include __DIR__ . '/ConvertKit/ConvertKit.php';
include __DIR__ . '/GetResponse/GetResponse.php';
include __DIR__ . '/ConstantContact/ConstantContact.php';
include __DIR__ . '/Webhook/Webhook.php';
include __DIR__ . '/AWeber/AWeber.php';
include __DIR__ . '/Zoho/Zoho.php';
include __DIR__ . '/Zoho/ZohoCRM.php';
include __DIR__ . '/MailerLite/MailerLite.php';
include __DIR__ . '/Moosend/Moosend.php';
include __DIR__ . '/CampaignMonitor/CampaignMonitor.php';
include __DIR__ . '/MailPoet/MailPoet.php';
include __DIR__ . '/TNP/TNP.php';
include __DIR__ . '/Klaviyo/Klaviyo.php';
include __DIR__ . '/Pabbly/Pabbly.php';
include __DIR__ . '/Ontraport/Ontraport.php';
include __DIR__ . '/SendPulse/SendPulse.php';
if(file_exists(__DIR__ . '/Validators/emailvalidator.php')){
   include __DIR__ . '/Validators/emailvalidator.php';
}
if(file_exists(__DIR__ . '/_Advanced/init.php')){
   include __DIR__ . '/_Advanced/init.php';
}