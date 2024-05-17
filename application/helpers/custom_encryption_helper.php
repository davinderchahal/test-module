<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function aes_encrypt($plain_text, $password = '')
{
    $password = ($password) ? $password : '2IaVMsT6hhaAdOMH';
    $method = 'AES-256-CBC';
    // Must be exact 32 chars (256 bit)
    $password = substr(hash('sha256', $password, true), 0, 32);

    // IV must be exact 16 chars (128 bit)
    $ivlen = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivlen);

    $raw_text = openssl_encrypt($plain_text, $method, $password, OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $raw_text, $password,  true);
    $encrypted = base64_encode($iv . $hmac . $raw_text);
    $encrypted = str_replace('+', '_pls_', $encrypted);
    $encrypted = str_replace('=', '_eql_', $encrypted);
    $encrypted = str_replace('/', '_sls_', $encrypted);
    return $encrypted;
}


function aes_decrypt($enc_text, $password = '')
{
    if ($enc_text != '') {
        $encrypted = str_replace('_pls_', '+', $enc_text);
        $encrypted = str_replace('_eql_', '=', $encrypted);
        $encrypted = str_replace('_sls_', '/', $encrypted);
        $password = ($password) ? $password : '2IaVMsT6hhaAdOMH';
        // Must be exact 32 chars (256 bit)
        $password = substr(hash('sha256', $password, true), 0, 32);

        $method = 'AES-256-CBC';
        $ciphertext = base64_decode($encrypted);
        $ivlen = openssl_cipher_iv_length($method);
        $iv = substr($ciphertext, 0, $ivlen);
        $hmac = substr($ciphertext, $ivlen, $sha2len = 32);
        $raw_text = substr($ciphertext, $ivlen + $sha2len);

        $decrypted = openssl_decrypt($raw_text, $method, $password, OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $raw_text, $password,  true);

        return hash_equals($hmac, $calcmac) ? $decrypted : ''; // timing attack safe comparison
    } else {
        return $enc_text;
    }
}
