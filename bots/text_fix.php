<?php

namespace Publish\TextFix;

/*

use function Publish\TextFix\DoChangesToText;

*/

use function Publish\Helps\pub_test_print;
use function Publish\MdCat\Add_MdWiki_Category;

const TRADUCIDO_REF_PATTERN = '/\{\{\s*Traducido\s*ref\s*\|/';
const ENLACES_EXTERNOS_PATTERN = '/==\s*Enlaces\s+externos\s*==/i';

function sw_fixes($text)
{
    // ---

    // ---
    return $text;
}

function es_section($sourcetitle, $text, $revid)
{
    // ---
    // if text has /\{\{\s*Traducido ref\s*\|/ then return text
    preg_match('/\{\{\s*Traducido\s*ref\s*\|/', $text, $ma);
    if (!empty($ma)) {
        pub_test_print("return text;");
        return $text;
    }
    // ---
    $date = "{{subst:CURRENTDAY}} de {{subst:CURRENTMONTHNAME}} de {{subst:CURRENTYEAR}}";
    // ---
    $temp = "{{Traducido ref|mdwiki|$sourcetitle|oldid=$revid|trad=|fecha=$date}}";
    // ---
    // find /==\s*Enlaces\s*externos\s*==/ in text if exists add temp after it
    // if not exists add temp at the end of text
    // ---
    preg_match('/==\s*Enlaces\s*externos\s*==/', $text, $matches);
    // ---
    if (!empty($matches)) {
        $text = preg_replace('/==\s*Enlaces\s*externos\s*==/', "== Enlaces externos ==\n$temp\n", $text, 1);
    } else {
        $text .= "\n== Enlaces externos ==\n$temp\n";
    }
    // ---
    return $text;
}

function DoChangesToText($sourcetitle, $text, $lang, $revid)
{
    // ---
    if ($lang == 'es') {
        $text = es_section($sourcetitle, $text, $revid);
    };
    // ---
    if ($lang == 'sw') {
        $text = sw_fixes($text);
    };
    // ---
    $cat = Add_MdWiki_Category($lang);
    // ---
    if (!empty($cat)) {
        $text .= "\n$cat\n";
    }
    // ---
    return $text;
}
