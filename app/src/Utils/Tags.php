<?php

namespace MediaSuite\Utils;

/**
 * Simple Tag extractor utility
 */
class Tags
{

    /**
     * @var string[]
     */
    private static $stopWords = [
        '#',
        'p',
        's',
        '##',
        'a',
        'about',
        'above',
        'after',
        'again',
        'against',
        'all',
        'am',
        'an',
        'and',
        'any',
        'are',
        'aren\'t',
        'as',
        'at',
        'be',
        'because',
        'been',
        'before',
        'being',
        'below',
        'between',
        'both',
        'but',
        'by',
        'can\'t',
        'cannot',
        'could',
        'couldn\'t',
        'did',
        'didn\'t',
        'do',
        'does',
        'doesn\'t',
        'doing',
        'don\'t',
        'down',
        'during',
        'each',
        'few',
        'for',
        'from',
        'further',
        'had',
        'hadn\'t',
        'has',
        'hasn\'t',
        'have',
        'haven\'t',
        'having',
        'he',
        'he\'d',
        'he\'ll',
        'he\'s',
        'her',
        'here',
        'here\'s',
        'hers',
        'herself',
        'him',
        'himself',
        'his',
        'how',
        'how\'s',
        'i',
        'i\'d',
        'i\'ll',
        'i\'m',
        'i\'ve',
        'if',
        'in',
        'into',
        'is',
        'isn\'t',
        'it',
        'it\'s',
        'its',
        'itself',
        'let\'s',
        'me',
        'more',
        'most',
        'mustn\'t',
        'my',
        'myself',
        'no',
        'nor',
        'not',
        'of',
        'off',
        'on',
        'once',
        'only',
        'or',
        'other',
        'ought',
        'our',
        'ours',
        'ourselves',
        'out',
        'over',
        'own',
        'same',
        'shan\'t',
        'she',
        'she\'d',
        'she\'ll',
        'she\'s',
        'should',
        'shouldn\'t',
        'so',
        'some',
        'such',
        'than',
        'that',
        'that\'s',
        'the',
        'their',
        'theirs',
        'them',
        'themselves',
        'then',
        'there',
        'there\'s',
        'these',
        'they',
        'they\'d',
        'they\'ll',
        'they\'re',
        'they\'ve',
        'this',
        'those',
        'through',
        'to',
        'too',
        'under',
        'until',
        'up',
        'very',
        'was',
        'wasn\'t',
        'we',
        'we\'d',
        'we\'ll',
        'we\'re',
        'we\'ve',
        'were',
        'weren\'t',
        'what',
        'what\'s',
        'when',
        'when\'s',
        'where',
        'where\'s',
        'which',
        'while',
        'who',
        'who\'s',
        'whom',
        'why',
        'why\'s',
        'with',
        'won\'t',
        'would',
        'wouldn\'t',
        'you',
        'you\'d',
        'you\'ll',
        'you\'re',
        'you\'ve',
        'your',
        'yours',
        'yourself',
        'yourselves',
    ];

    /**
     * This function returns a list of the top `tagCount` frequently used words in the blog post.
     * These words should not include any words from the `stopWords` array, and should also exclude
     * strings relating to markdown.
     */
    static function getTopWords($bodyText, $tagCount = 5)
    {
        $string = strtolower($bodyText);

        $words = str_word_count($string, 1);
        $words = array_diff($words, self::$stopWords);
        $words = array_count_values($words);

        arsort($words);

        return array_slice($words, 0, $tagCount);

    }

}

