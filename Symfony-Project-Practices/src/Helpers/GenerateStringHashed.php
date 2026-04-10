<?php 

namespace App\Helpers;

class GenerateStringHashed
{
    public static function generate(string $input, int $rounds, int $length): string
    {
        $hash = hash('sha256', $input);
        for ($i = 1; $i < $rounds; $i++) {
            $hash = hash('sha256', $hash);
        }
        return substr($hash, 0, $length);
    }
}