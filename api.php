<?php
/**
 * Jojo CMS - Interspire API
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


Jojo::addHook('jojo_cart_success',              'jojo_cart_success',              'jojo_interspire_api');
Jojo::addHook('jojo_cart_extra_fields_billing', 'jojo_cart_extra_fields_billing', 'jojo_interspire_api');
Jojo::addFilter('jojo_cart_checkout:get_fields', 'jojo_cart_checkout_get_fields', 'jojo_interspire_api');

$_options[] = array(
    'id'          => 'interspire_api_key',
    'category'    => 'Interspire',
    'label'       => 'Interspire API key',
    'description' => 'Create an API key on the ACCOUNT menu in interspire',
    'type'        => 'text',
    'default'     => '',
    'options'     => '',
    'plugin'      => 'jojo_interspire_api'
);

$_options[] = array(
    'id'          => 'interspire_xml_url',
    'category'    => 'Interspire',
    'label'       => 'Interspire XML URL',
    'description' => 'the full web address to your Interspire XML API - eg http://www.example.com/newsletters/xml.php',
    'type'        => 'text',
    'default'     => '',
    'options'     => '',
    'plugin'      => 'jojo_interspire_api'
);

$_options[] = array(
    'id'          => 'interspire_cart_list_id',
    'category'    => 'Interspire',
    'label'       => 'Interspire List ID',
    'description' => 'Customers who place a successful order will be subscribed to this list. Must match a valid list in your interspire account',
    'type'        => 'text',
    'default'     => '',
    'options'     => '',
    'plugin'      => 'jojo_interspire_api'
);

$_options[] = array(
    'id'          => 'interspire_cart_subscribe_type',
    'category'    => 'Interspire',
    'label'       => 'Interspire Subscribe type',
    'description' => 'Automatic = customers are subscribed automatically after purchase. Ask after = customers are shown a subscribe button after purchase. Ask yes = customers are shown a tickbox defaulting to yes, Ask no = custoers are shown a tickbox defaulting to no',
    'type'        => 'radio',
    'default'     => 'automatic',
    'options'     => 'automatic,ask yes,ask no',//"ask after" option to be added also, which will display a subscribe button on the thank you page
    'plugin'      => 'jojo_interspire_api'
);

$_options[] = array(
    'id'          => 'interspire_cart_subscribe_message',
    'category'    => 'Interspire',
    'label'       => 'Interspire subscribe message',
    'description' => 'Displayed by the checkbox asking customers if they wish to subscribe eg Would you like to subscribe to our newsletter',
    'type'        => 'text',
    'default'     => '',
    'options'     => '',
    'plugin'      => 'jojo_interspire_api'
);