<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMXPath;

/** Small allow-list HTML sanitiser for blog content written in the admin editor. */
class Html
{
    private const ALLOWED = ['p', 'br', 'h2', 'h3', 'h4', 'strong', 'b', 'em', 'i', 'u', 's', 'a', 'ul', 'ol', 'li', 'blockquote', 'img', 'figure', 'figcaption', 'hr', 'code', 'pre', 'table', 'thead', 'tbody', 'tr', 'th', 'td', 'iframe'];

    private const ATTRS = ['a' => ['href', 'title', 'target', 'rel'], 'img' => ['src', 'alt', 'title', 'width', 'height'], 'iframe' => ['src', 'width', 'height', 'allowfullscreen'], 'th' => ['colspan'], 'td' => ['colspan']];

    public static function clean(?string $html): string
    {
        $html = trim((string) $html);
        if ($html === '') {
            return '';
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8"?><div id="root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        // drop dangerous elements entirely
        foreach ($xpath->query('//script|//style|//object|//embed|//form|//input|//button|//link|//meta') as $n) {
            $n->parentNode?->removeChild($n);
        }

        foreach (iterator_to_array($xpath->query('//*[@id="root"]//*')) as $el) {
            /** @var DOMElement $el */
            $tag = strtolower($el->tagName);
            if (! in_array($tag, self::ALLOWED, true)) {
                // unwrap unknown tags (span, div...) but keep their children
                while ($el->firstChild) {
                    $el->parentNode->insertBefore($el->firstChild, $el);
                }
                $el->parentNode->removeChild($el);

                continue;
            }
            $keep = self::ATTRS[$tag] ?? [];
            foreach (iterator_to_array($el->attributes) as $attr) {
                if (! in_array($attr->name, $keep, true)) {
                    $el->removeAttribute($attr->name);
                }
            }
            foreach (['href', 'src'] as $a) {
                if ($el->hasAttribute($a) && ! preg_match('#^(https?:|/|mailto:|tel:|\#)#i', trim($el->getAttribute($a)))) {
                    $el->removeAttribute($a);
                }
            }
            if ($tag === 'iframe' && ! preg_match('#^https://(www\.)?(youtube\.com|youtube-nocookie\.com|player\.vimeo\.com)/#i', $el->getAttribute('src'))) {
                $el->parentNode->removeChild($el);

                continue;
            }
            if ($tag === 'a' && $el->getAttribute('target') === '_blank') {
                $el->setAttribute('rel', 'noopener');
            }
            if ($tag === 'img') {
                $el->setAttribute('loading', 'lazy');
            }
        }

        $root = $dom->getElementById('root');
        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $dom->saveHTML($child);
        }

        // Quill leaves empty paragraphs behind
        return trim(preg_replace('#<p>(\s|<br\s*/?>)*</p>#i', '', $out));
    }
}
