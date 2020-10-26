<?php

declare(strict_types=1);

namespace App\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class ShortTextExtension
 * @package App\Extension
 */
class ShortTextExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('short', [$this, 'getShortText']),
        ];
    }

    /**
     * @param string $text
     * @param int $length
     * @return string
     */
    public function getShortText(string $text, int $length = 200): string
    {
        $text = strip_tags(html_entity_decode($text));
        return $this->truncate($text, $length, true);
    }

    /**
     * @param string $str
     * @param int $chars
     * @param bool $to_space
     * @param string $replacement
     * @return string
     */
    protected function truncate(string $str, int $chars, bool $to_space, string $replacement = "..."): string
    {
        if ($chars > strlen($str)) {
            return $str;
        }

        $str = substr($str, 0, $chars);
        $space_pos = strrpos($str, " ");
        if ($to_space && $space_pos >= 0) {
            $str = substr($str, 0, strrpos($str, " "));
        }

        return $str . $replacement;
    }
}
