<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('MYPAGE_CHECKOUT_NIP_FIELD_ID')) {
    define('MYPAGE_CHECKOUT_NIP_FIELD_ID', 'mypage/nip');
}

if (!defined('MYPAGE_CHECKOUT_NIP_INDEX')) {
    define('MYPAGE_CHECKOUT_NIP_INDEX', 31);
}

if (!function_exists('mypage_checkout_nip_label')) {
    function mypage_checkout_nip_label()
    {
        return __('NIP', 'mypage');
    }
}

if (!function_exists('mypage_checkout_nip_invalid_message')) {
    function mypage_checkout_nip_invalid_message()
    {
        return __('Podaj poprawny numer NIP.', 'mypage');
    }
}

if (!function_exists('mypage_checkout_nip_required_message')) {
    function mypage_checkout_nip_required_message()
    {
        return __('NIP jest wymagany, gdy uzupełnisz nazwe firmy.', 'mypage');
    }
}

if (!function_exists('mypage_checkout_nip_normalize')) {
    function mypage_checkout_nip_normalize($value)
    {
        if (is_array($value) || is_object($value)) {
            return '';
        }

        $value = (string) $value;
        return preg_replace('/\D+/', '', $value) ?? '';
    }
}

if (!function_exists('mypage_checkout_nip_is_valid')) {
    function mypage_checkout_nip_is_valid($value)
    {
        $nip = mypage_checkout_nip_normalize($value);

        if (!preg_match('/^\d{10}$/', $nip)) {
            return false;
        }

        $weights = [6, 5, 7, 2, 3, 4, 5, 6, 7];
        $sum = 0;

        for ($i = 0; $i < count($weights); $i++) {
            $sum += ((int) $nip[$i]) * $weights[$i];
        }

        $checksum = $sum % 11;
        if ($checksum === 10) {
            return false;
        }

        return $checksum === (int) $nip[9];
    }
}

if (!function_exists('mypage_checkout_nip_blocks_sanitize_callback')) {
    function mypage_checkout_nip_blocks_sanitize_callback($value, $field)
    {
        return mypage_checkout_nip_normalize($value);
    }
}

if (!function_exists('mypage_checkout_nip_blocks_validate_callback')) {
    function mypage_checkout_nip_blocks_validate_callback($value, $field)
    {
        $nip = mypage_checkout_nip_normalize($value);
        if ($nip === '') {
            return;
        }

        if (!mypage_checkout_nip_is_valid($nip)) {
            return new WP_Error(
                'woocommerce_invalid_checkout_field',
                mypage_checkout_nip_invalid_message()
            );
        }
    }
}

add_action('woocommerce_init', function () {
    if (!function_exists('woocommerce_register_additional_checkout_field')) {
        return;
    }

    woocommerce_register_additional_checkout_field([
        'id' => MYPAGE_CHECKOUT_NIP_FIELD_ID,
        'label' => mypage_checkout_nip_label(),
        'location' => 'address',
        'type' => 'text',
        'required' => false,
        'index' => MYPAGE_CHECKOUT_NIP_INDEX,
        'show_in_order_confirmation' => true,
        'attributes' => [
            'maxLength' => 10,
            'pattern' => '[0-9\\-\\s]*',
            'autocomplete' => 'off',
            'title' => mypage_checkout_nip_label(),
            'data-mypage-nip' => '1',
        ],
        'sanitize_callback' => 'mypage_checkout_nip_blocks_sanitize_callback',
        'validate_callback' => 'mypage_checkout_nip_blocks_validate_callback',
    ]);
}, 20);

add_action('woocommerce_blocks_validate_location_address_fields', function ($errors, $fields, $group) {
    if (!($errors instanceof WP_Error) || 'billing' !== $group) {
        return;
    }

    $company = isset($fields['company']) ? sanitize_text_field((string) $fields['company']) : '';
    $nip = mypage_checkout_nip_normalize($fields[MYPAGE_CHECKOUT_NIP_FIELD_ID] ?? '');

    if ($company !== '' && $nip === '') {
        $errors->add(
            'woocommerce_required_checkout_field',
            mypage_checkout_nip_required_message()
        );
        return;
    }

    if ($nip !== '' && !mypage_checkout_nip_is_valid($nip)) {
        $errors->add(
            'woocommerce_invalid_checkout_field',
            mypage_checkout_nip_invalid_message()
        );
    }
}, 10, 3);

add_filter('woocommerce_checkout_fields', function ($fields) {
    if (!is_array($fields)) {
        return $fields;
    }

    if (!isset($fields['billing']) || !is_array($fields['billing'])) {
        $fields['billing'] = [];
    }

    $fields['billing']['billing_nip'] = [
        'type' => 'text',
        'label' => mypage_checkout_nip_label(),
        'required' => false,
        'priority' => MYPAGE_CHECKOUT_NIP_INDEX,
        'class' => ['form-row-wide'],
        'clear' => true,
        'custom_attributes' => [
            'inputmode' => 'numeric',
            'maxlength' => 10,
            'autocomplete' => 'off',
            'data-mypage-nip' => '1',
        ],
    ];

    return $fields;
}, 20);

add_action('woocommerce_checkout_process', function () {
    $company = isset($_POST['billing_company']) ? sanitize_text_field(wp_unslash((string) $_POST['billing_company'])) : '';
    $nip = isset($_POST['billing_nip']) ? mypage_checkout_nip_normalize(wp_unslash((string) $_POST['billing_nip'])) : '';

    if (isset($_POST['billing_nip'])) {
        $_POST['billing_nip'] = $nip;
    }

    if ($company !== '' && $nip === '') {
        wc_add_notice(mypage_checkout_nip_required_message(), 'error');
        return;
    }

    if ($nip !== '' && !mypage_checkout_nip_is_valid($nip)) {
        wc_add_notice(mypage_checkout_nip_invalid_message(), 'error');
    }
});

add_action('woocommerce_checkout_create_order', function ($order, $data) {
    if (!is_a($order, 'WC_Order')) {
        return;
    }

    $nip = mypage_checkout_nip_normalize($data['billing_nip'] ?? '');

    if ($nip !== '') {
        $order->update_meta_data('_billing_nip', $nip);
    } else {
        $order->delete_meta_data('_billing_nip');
    }
}, 20, 2);

if (!function_exists('mypage_checkout_nip_get_from_order')) {
    function mypage_checkout_nip_get_from_order($order)
    {
        if (!is_a($order, 'WC_Order')) {
            return '';
        }

        $classic = mypage_checkout_nip_normalize($order->get_meta('_billing_nip', true));
        if ($classic !== '') {
            return $classic;
        }

        return mypage_checkout_nip_normalize(
            $order->get_meta('_wc_billing/' . MYPAGE_CHECKOUT_NIP_FIELD_ID, true)
        );
    }
}

add_action('woocommerce_admin_order_data_after_billing_address', function ($order) {
    if (!is_a($order, 'WC_Order') || 'store-api' === $order->get_created_via()) {
        return;
    }

    $nip = mypage_checkout_nip_get_from_order($order);
    if ($nip === '') {
        return;
    }

    echo '<p><strong>' . esc_html(mypage_checkout_nip_label()) . ':</strong> ' . esc_html($nip) . '</p>';
}, 20, 1);

add_filter('woocommerce_email_order_meta_fields', function ($fields, $sent_to_admin, $order) {
    if (!is_a($order, 'WC_Order') || 'store-api' === $order->get_created_via()) {
        return $fields;
    }

    $nip = mypage_checkout_nip_get_from_order($order);
    if ($nip === '') {
        return $fields;
    }

    $fields['billing_nip'] = [
        'label' => mypage_checkout_nip_label(),
        'value' => $nip,
    ];

    return $fields;
}, 20, 3);
