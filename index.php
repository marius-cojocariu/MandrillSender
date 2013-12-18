<?php

require_once('vendor/autoload.php');
require_once('config.php');

if($_POST['send']) {
    try {
        $mandrill = new Mandrill($config['mandrill_api_key']);
        $message = array(
            'html' => $_POST['body_html'],
            'text' => $_POST['body_text'],
            'subject' => $_POST['subject'],
            'from_email' => $_POST['email_from'],
            'from_name' => $_POST['email_from_name'],
            'to' => array(
                array(
                    'email' => $_POST['email_to'] ,
                    'name' => $_POST['email_to_name'],
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => $_POST['email_from']),
            'important' => false,
            'track_opens' => true,
            'track_clicks' => true,
            'auto_text' => false,
            'auto_html' => false,
            'inline_css' => true,
            'url_strip_qs' => false,
            'preserve_recipients' => false,
            'view_content_link' => true,
            'bcc_address' => null,
            'tracking_domain' => $config['mandrill_track_domain'],
            'signing_domain' => null,
            'return_path_domain' => null,
            'merge' => true,
            'global_merge_vars' => array(
                /*array(
                    'name' => 'merge1',
                    'content' => 'merge1 content'
                )*/
            ),
            'merge_vars' => array(
                /*array(
                    'rcpt' => 'recipient.email@example.com',
                    'vars' => array(
                        array(
                            'name' => 'merge2',
                            'content' => 'merge2 content'
                        )
                    )
                )*/
            ),
            'tags' => array('mandrillsender'),
            'subaccount' => null,
            'google_analytics_domains' => array(),
            'google_analytics_campaign' => array(),
            'metadata' => array(),
            'recipient_metadata' => array(
                /*array(
                    'rcpt' => 'recipient.email@example.com',
                    'values' => array('user_id' => 123456)
                )*/
            ),
            'attachments' => array(
                /*array(
                    'type' => 'text/plain',
                    'name' => 'myfile.txt',
                    'content' => 'ZXhhbXBsZSBmaWxl'
                )*/
            ),
            'images' => array(
                /*array(
                    'type' => 'image/png',
                    'name' => 'IMAGECID',
                    'content' => 'ZXhhbXBsZSBmaWxl'
                )*/
            )
        );
        $async = false;
        $ip_pool = '';
        $send_at = null;
        $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        echo '<p class="result">';
        print_r($result);
        echo '</p>';
    } catch(Mandrill_Error $e) {
        echo '<p>A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage().'</p>';
        //throw $e;
    }
}

?>

<style type="text/css">
    form {
        width:800px;
        margin:50px auto;
    }
    
    form label {
        float:left;
        padding-top:7px;
    }
    
    form input, form textarea {
        float:right;
        width:685px;
    }
    
    form textarea {
        height:300px;
    }
    
    form p {
        clear:both;
    }
    
    form input[type="submit"] {
        width:65px;
    }
    
    .result {
        margin:50px auto 0;
        width:800px;
        color:red;
    }
</style>

<form action="" method="post">
    <p><label for="email_from">From</label> <input type="text" value="<?php if(isset($_POST['email_from'])) echo $_POST['email_from'] ?>" id="email_from" name="email_from" /></p>
    <p><label for="email_from_name">From Name</label> <input type="text" value="<?php if(isset($_POST['email_from_name'])) echo $_POST['email_from_name'] ?>" id="email_from_name" name="email_from_name" /></p>
    <p><label for="email_to">To</label> <input type="text" value="<?php if(isset($_POST['email_to'])) echo $_POST['email_to'] ?>" id="email_to" name="email_to" /></p>
    <p><label for="email_to_name">To Name</label> <input type="text" value="<?php if(isset($_POST['email_to_name'])) echo $_POST['email_to_name'] ?>" id="email_to_name" name="email_to_name" /></p>
    <p><label for="subject">Subject</label> <input type="text" value="<?php if(isset($_POST['subject'])) echo $_POST['subject'] ?>" id="subject" name="subject" /></p>
    <p><label for="body_html">Body HTML</label> <textarea id="body_html" name="body_html"><?php if(isset($_POST['body_html'])) echo $_POST['body_html'] ?></textarea></p>
    <p><label for="body_text">Body TEXT</label> <textarea id="body_text" name="body_text"><?php if(isset($_POST['body_text'])) echo $_POST['body_text'] ?></textarea></p>
    <p><input type="submit" name="send" value="Send" /></p>
</form>