<?php
namespace Ciencia360\Helpers;

class Utils
{
    public static function countParagraphs(string $html): int
    {
        if ($html === '') return 0;
        preg_match_all('/<\/p>/i', $html, $m);
        return count($m[0]);
    }

    public static function injectAdAfterParagraph(string $html, int $after = 2, string $adHtml = ''): string
    {
        if ($adHtml === '') return $html;

        $parts = preg_split('/(<\/p>)/i', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        if (!$parts || count($parts) < 2) return $html;

        $countP = 0;
        $out = '';
        for ($i = 0; $i < count($parts); $i++) {
            $out .= $parts[$i];
            if (preg_match('/<\/p>/i', $parts[$i])) {
                $countP++;
                if ($countP === $after) {
                    $out .= $adHtml;
                }
            }
        }
        return $out;
    }

    public static function injectMultiple(string $html, array $positions, array $ads): string
    {
        if (empty($positions) || empty($ads)) return $html;
        $n = min(count($positions), count($ads));
        array_multisort($positions, SORT_ASC, $ads);

        $parts = preg_split('/(<\/p>)/i', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        if (!$parts || count($parts) < 2) return $html;

        $out = '';
        $countP = 0;
        $idx = 0;
        for ($i = 0; $i < count($parts); $i++) {
            $out .= $parts[$i];
            if ($idx >= $n) continue;
            if (preg_match('/<\/p>/i', $parts[$i])) {
                $countP++;
                while ($idx < $n && $countP === (int)$positions[$idx]) {
                    $out .= $ads[$idx];
                    $idx++;
                }
            }
        }
        return $out;
    }
}
