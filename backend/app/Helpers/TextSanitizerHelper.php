<?php

namespace App\Helpers;

class TextSanitizerHelper
{
    private const MAX_NAME_LENGTH = 255;

    private const EMOJI_PATTERNS = [
        '/[\x{1F600}-\x{1F64F}]/u', // Emoticons
        '/[\x{1F300}-\x{1F5FF}]/u', // Misc Symbols and Pictographs
        '/[\x{1F680}-\x{1F6FF}]/u', // Transport and Map
        '/[\x{1F1E0}-\x{1F1FF}]/u', // Regional Indicator Symbols
        '/[\x{2600}-\x{26FF}]/u',   // Miscellaneous Symbols
        '/[\x{2700}-\x{27BF}]/u',   // Dingbats
    ];

    private const CONTROL_CHARS_PATTERN = '/[\x00-\x1F\x7F-\x9F]/u';
    private const WHITESPACE_NORMALIZATION_PATTERN = '/\s+/';

    public static function sanitizeContactName(?string $name): ?string
    {
        if (empty($name)) {
            return null;
        }

        $sanitized = self::removeEmojis($name);
        $sanitized = self::removeControlCharacters($sanitized);
        $sanitized = self::truncateToMaxLength($sanitized);
        $sanitized = self::normalizeWhitespace($sanitized);

        return !empty($sanitized) ? $sanitized : null;
    }

    public static function removeEmojis(string $text): string
    {
        foreach (self::EMOJI_PATTERNS as $pattern) {
            $text = preg_replace($pattern, '', $text);
        }

        return $text;
    }

    public static function removeControlCharacters(string $text): string
    {
        return preg_replace(self::CONTROL_CHARS_PATTERN, '', $text);
    }

    public static function truncateToMaxLength(string $text, int $maxLength = self::MAX_NAME_LENGTH): string
    {
        return mb_substr($text, 0, $maxLength);
    }

    public static function normalizeWhitespace(string $text): string
    {
        return trim(preg_replace(self::WHITESPACE_NORMALIZATION_PATTERN, ' ', $text));
    }

    public static function sanitizeText(?string $text, int $maxLength = self::MAX_NAME_LENGTH): ?string
    {
        if (empty($text)) {
            return null;
        }

        $sanitized = self::removeControlCharacters($text);
        $sanitized = self::truncateToMaxLength($sanitized, $maxLength);
        $sanitized = self::normalizeWhitespace($sanitized);

        return !empty($sanitized) ? $sanitized : null;
    }
}
