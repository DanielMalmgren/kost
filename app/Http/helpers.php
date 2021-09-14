<?php

function str_word_count_utf8(string $str, int $format = 0) {
    if($format === 1) {
        return preg_split('~[^\p{L}\p{N}\'-]+~u',$str);
    }
    return count(preg_split('~[^\p{L}\p{N}\'-]+~u',$str));
}
