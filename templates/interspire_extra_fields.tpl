            <label for="interspire_subscribe">Subscribe</label>
            <input type="checkbox" name="interspire_subscribe" id="interspire_subscribe" value="1"{if $OPTIONS.interspire_cart_subscribe_type == 'ask yes'} checked="checked"{/if} /> {$OPTIONS.interspire_cart_subscribe_message|default:'Subscribe to our newsletter?'}<br />
            