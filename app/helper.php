<?php

/**
 * @param $email
 * @return string
 */
function encryptEmail($email): string
{
    $prefix = explode('@', $email)[0];
    $len = strlen($prefix);
    $half_len = round($len / 2);
    return str_pad(substr($prefix, 0, $half_len), $len, "*") . '@' . explode('@', $email)[1];
}
