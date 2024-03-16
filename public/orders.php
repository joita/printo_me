<?php

$webhook_content = '';
$webhook = fopen('php://input' , 'rb');
while(!feof($webhook)){ //loop through the input stream while the end of file is not reached
$webhook_content .= fread($webhook, 4096); //append the content on the current iteration
}
fclose($webhook); //close the resource
error_log($webhook_content);
file_put_contents('text.txt', $webhook_content.$_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN']."dffd");
 ?>