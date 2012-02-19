<?php
/**
 * Jojo CMS - interspire API
 *
 * Copyright 2011 Jojo CMS
 *
 * See the enclosed file license.txt for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Harvey Kane <code@ragepank.com>
 * @license http://www.fsf.org/copyleft/lgpl.html GNU Lesser General Public License
 * @link    http://www.jojocms.org JojoCMS
 */

class Jojo_Plugin_Jojo_Interspire_API extends Jojo_Plugin
{
    function subscribe($email, $list_id=false, $merge_vars=NULL)
    {
        if (!$list_id) $list_id = Jojo::getOption('interspire_cart_list_id', false);
        if (empty($list_id)) return false;
        
        $url = Jojo::getOption('interspire_xml_url', false);
        if (empty($url)) return false;

        if (!Jojo::checkEmailFormat($email)) return false;
        
        $key = Jojo::getOption('interspire_api_key', false);
        if (empty($key)) return false;

        $firstname = (!empty($merge_vars['firstname'])) ? $merge_vars['firstname'] : false;
        $lastname  = (!empty($merge_vars['lastname']))  ? $merge_vars['lastname']  : false;
        
        $xml = '<xmlrequest>
<username>gardenpost</username>
<usertoken>'.$key.'</usertoken>
<requesttype>subscribers</requesttype>
<requestmethod>AddSubscriberToList</requestmethod>
<details>
<emailaddress>'.$email.'</emailaddress>
<mailinglist>'.$list_id.'</mailinglist>
<format>html</format>
<confirmed>yes</confirmed>
<customfields>
<item>
<fieldid>2</fieldid>
<value>'.$firstname.'</value>
</item>
<item>
<fieldid>3</fieldid>
<value>'.$lastname.'</value>
</item>
</customfields>
</details>
</xmlrequest>
';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $result = @curl_exec($ch);
        if($result === false) {
            //echo "Error performing request";
            return false;
        } else {
            $xml_doc = simplexml_load_string($result);
            echo 'Status is ', $xml_doc->status, '<br/>';
            if ($xml_doc->status == 'SUCCESS') {
                //echo 'Data is ', $xml_doc->data, '<br/>';
                return true;
            } else {
                //echo 'Error is ', $xml_doc->errormessage, '<br/>';
                return false;
            }
        }
    }
    
    function jojo_cart_success($cart)
    {
        $list_id = Jojo::getOption('interspire_cart_list_id', false);
        if (!$list_id) return false; //an empty value means customers aren't to be added to any list
        
        $subscribe_type = Jojo::getOption('interspire_cart_subscribe_type', 'automatic');
        
        if (($subscribe_type == 'automatic') || !empty($cart->fields['interspire_subscribe'])) {
            /* get billing email address from cart */
            $email = $cart->fields['billing_email'];
            if (empty($email) || !Jojo::checkEmailFormat($email)) return false; //one would hope email address is valid at this point
            
            /* attempt to subscribe */
            return self::subscribe($email, $list_id, array('firstname' => $cart->fields['billing_firstname'], 'lastname' => $cart->fields['billing_lastname']));
        }
        return false;        
    }
    
    function jojo_cart_extra_fields_billing()
    {
        global $smarty;
        $subscribe_type = Jojo::getOption('interspire_cart_subscribe_type', 'automatic');
        if (($subscribe_type == 'ask yes') || ($subscribe_type == 'ask no')) {
            return $smarty->fetch('interspire_extra_fields.tpl');
        }
        return '';
    }
    
    function jojo_cart_checkout_get_fields($fields)
    {
        $fields[] = 'interspire_subscribe';
        return $fields;
    }
    
}