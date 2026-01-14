<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custom_encrypt
{

    private $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_'; // Ganti kalau mau custom lain (PASTI 64 UNIK!)

    public function encode($data)
    {
        $string = (string)$data; // Pastikan string
        $encoded = base64_encode($string);
        $encoded = str_replace(['+', '/', '='], ['-', '_', ''], $encoded); // URL-safe + hilangkan padding
        $standard = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        return strtr($encoded, $standard, $this->alphabet);
    }

    public function decode($data)
    {
        $standard = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        $restored = strtr($data, $this->alphabet, $standard);
        // Tambah padding kembali
        $padding = strlen($restored) % 4;
        if ($padding) {
            $restored .= str_repeat('=', 4 - $padding);
        }
        $decoded = base64_decode($restored);
        // Kembalikan ke integer kalau angka murni
        if (is_numeric($decoded) && strpos($decoded, '.') === false && (int)$decoded == $decoded) {
            return (int)$decoded;
        }
        return $decoded;
    }
}
