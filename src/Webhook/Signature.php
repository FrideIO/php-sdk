<?php

namespace Fride\Webhook;

class Signature
{
    public static function check(string $hookJson, string $headerSignature, string $secretKey): bool
    {
        $hookArr = json_decode($hookJson, true);
		
        if (!is_array($hookArr)) {
            return false;
        }
		
        ksort($hookArr);

        if (isset($hookArr['custom_fields'])) {
            $hookArr['custom_fields'] = (object) $hookArr['custom_fields']; // Фикс особенности PHP. Пустой объект переделывает в массив по умолчанию
        }

        $hookJsonSorted = json_encode($hookArr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		
        if ($hookJsonSorted === false) {
            return false;
        }
		
        $calculatedSignature = hash_hmac('sha256', $hookJsonSorted, $secretKey);
		
        return hash_equals($headerSignature, $calculatedSignature);
    }
}


