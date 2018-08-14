<?php
require 'token.php';
session_start();
if(isset($_GET['token']) && $_GET['token'] == $token)
    $_SESSION['auth'] = 1;
if(!isset($_SESSION['auth']))
    exit();
$words = file_get_contents(__DIR__ . '/word.json');
$words = json_decode($words);
$tags = [];
$finish = [];
$unFinish = [];
$unReview = [];
foreach($words as $word) {
    foreach($word->tags as $tag)
        if(!in_array($tag, $tags))
            $tags[] = $tag;
    if($word->finish)
        $finish[] = $word;
    else
        $unFinish[] = $word;
    if(strtotime($word->reviewAt) + 3600 * 24 * 5 <  time())
        $unReview[] = $word;
}

function wordExists($newWord) {
    global $words;
    foreach($words as $word)
        if($newWord['word'] == $word->word)
            return true;
}

function wordKeyExists($key) {
    global $words;
    foreach($words as $word)
        if($key == $word->word)
            return true; 
}

function addWord($word) {
    global $words;
    if(!wordExists($word)) {
        $word['finish'] = isset($word['finish']) && $word['finish'] ? true : false;
        $word['reviewAt'] = date('Y-m-d');
        $words[] = (object) $word;
        saveWords();
        return true;
    }
}

function saveWord($toSave) {
    global $words;
    $count = count($words);
    for($i = 0;$i < $count;$i++) {
        if($toSave['word'] == $words[$i]->word) {
            unset($words[$i]);
            $words = array_values($words);
            addWord($toSave);
            return true;
        }
    }
}

function deleteWord($word) {
    global $words;
    if(wordKeyExists($word)) {
        $count = count($words);
        for($i = 0;$i < $count;$i++) {
            if($word == $words[$i]->word) {
                unset($words[$i]);
                $words = array_values($words);
                saveWords();
                return true;
            }
        }
    }
}

function addWordRollBack() {
    global $words;
    array_pop($words);
    saveWords();
}

function saveWords() {
    global $words;
    file_put_contents(__DIR__ . '/word.json', json_encode($words, 128|256));
}

function getWord($find) {
    global $words;
    foreach($words as $word)
        if($word->word == $find)
            return $word;
}

function forget($find) {
    $word = getWord($find);
    $word->reviewAt = date('Y-m-d', time() - 3600 * 24 * 4);
    saveWords();
}

function review($find) {
    $word = getWord($find);
    $word->reviewAt = date('Y-m-d');
    saveWords();
}

function finish($find) {
    $word = getWord($find);
    $word->finish = true;
    saveWords();
}