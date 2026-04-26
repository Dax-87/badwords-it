<?php

namespace BadwordsIt;

class Filter
{
    private array $profanity;
    private array $spam;

    public function __construct(
        ?string $profanityFile = null,
        ?string $spamFile = null
    ) {
        $this->profanity = require $profanityFile ?? __DIR__ . '/../data/profanity.php';
        $this->spam      = require $spamFile      ?? __DIR__ . '/../data/spam.php';
    }

    /**
     * Check if a plain text field contains profanity.
     */
    public function hasProfanity(string $text): bool
    {
        $t = strtolower(trim($text));

        if ($t === '') {
            return false;
        }

        if (preg_match($this->profanity['regex'], $t)) {
            return true;
        }

        foreach ($this->profanity['substrings'] as $word) {
            if (strpos($t, $word) !== false) {
                return true;
            }
        }

        foreach ($this->profanity['phrases'] as $phrase) {
            if (strpos($t, $phrase) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if an email address contains profanity in local part or domain name.
     */
    public function hasProfanityEmail(string $email): bool
    {
        $parts  = explode('@', strtolower($email));
        $local  = $parts[0] ?? '';
        $domain = explode('.', $parts[1] ?? '')[0];

        foreach ([$local, $domain] as $part) {
            if ($part === '') {
                continue;
            }
            foreach ($this->profanity['email_substrings'] as $word) {
                if (strpos($part, $word) !== false) {
                    return true;
                }
            }
            foreach ($this->profanity['phrases'] as $phrase) {
                if (strpos($part, $phrase) !== false) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if a text contains spam keywords.
     */
    public function hasSpam(string $text): bool
    {
        $t = strtolower($text);

        foreach ($this->spam['keywords'] as $keyword) {
            if (stripos($t, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check multiple text fields at once for profanity.
     * Returns true if any field triggers the filter.
     *
     * @param string[] $fields
     */
    public function checkFields(array $fields): bool
    {
        foreach ($fields as $field) {
            if ($this->hasProfanity((string) $field)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check multiple text fields at once for spam.
     *
     * @param string[] $fields
     */
    public function checkFieldsSpam(array $fields): bool
    {
        foreach ($fields as $field) {
            if ($this->hasSpam((string) $field)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Run both profanity and spam checks on multiple fields.
     * Returns an array with keys 'profanity' and 'spam'.
     *
     * @param  string[] $textFields
     * @param  string   $email
     * @return array{profanity: bool, spam: bool}
     */
    public function inspect(array $textFields, string $email = ''): array
    {
        return [
            'profanity' => $this->checkFields($textFields) || ($email !== '' && $this->hasProfanityEmail($email)),
            'spam'      => $this->checkFieldsSpam($textFields),
        ];
    }
}
