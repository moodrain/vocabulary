<?php
require 'common.php';
if(empty($unReview)) {
    header('Location: /');
    exit();
}
$word = $unReview[array_rand($unReview)];
$relateds = [];
foreach($words as $w)
    foreach($word->tags as $tag)
        if(in_array($tag, $w->tags))
            $relateds[$w->word] = $w;
if(isset($_GET['remember'])) {
    review($_GET['remember']);
    exit();
} else if(isset($_GET['forget'])) {
    forget($_GET['forget']);
    exit();
} else if(isset($_GET['finish'])) {
    review($_GET['finish']);
    finish($_GET['finish']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://s1.moodrain.cn/lib/muyu/index.css">
    <title>Learn | Muyu Vocabulary</title>
</head>
<body>
    <div class="container">
        <br />
        <ul class="list-group">
            <li class="list-group-item"><span class="badge"><?php echo count($unReview); ?></span>Unreviewed: </li>
            <li class="list-group-item"><span class="badge"><?php echo count($unFinish); ?></span>Unfinished: </li>
        </ul>
        <div class="panel panel-default container">
            <h3 id="word-h3" class="text-center" <?php echo $word->finish ? '' : 'style="color: blue;"';  ?>><?php echo $word->word; ?></h3>
            <hr />
            <div id="hidden-div" style="display: none;">
                <p><?php echo $word->mean; ?></p>
                <p><?php foreach($word->tags as $tag) { ?>
                    <a target="_blank" href="list.php?view=tag&tag=<?php echo $tag; ?>" class="label label-primary"><?php echo $tag; ?></a>
                <?php } ?></p>
                <p><?php echo $word->sentence; ?></p>
                <p><?php foreach($relateds as $related) { ?>
                    <?php echo $related == $word ? '' : '<a href="https://www.bing.com/dict/search?q=' . $related->word . '" target="_blank">' . $related->word . '</a>' . '<span>、</span>'; ?>
                <?php } ?></p>
            </div>
            <hr />
            <div class="text-center">
                <a id="finish-a" class="btn btn-default" <?php echo $word->finish ? 'style="dispay: none;"' : ''; ?>>Finish</a>
                <a id="forget-a" class="btn btn-info">Forget</a>
                <a id="remember-a" class="btn btn-success">Remember</a>
                <a id="next-a" class="btn btn-primary" style="display: none;">Next</a>
            </div>
            <br />
        </div>
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <a class="btn btn-default">Search</a>
                <a href="add.php" class="btn btn-default">New</a>
                <a href="/" class="btn btn-default">Home</a>
            </div>
        </div>
    </div>
    <script src="https://s1.moodrain.cn/lib/muyu/index.js"></script>
    <script>
        $click('next-a', () => { window.location.reload() })
        $click('forget-a', () => {
            $get('learn.php?forget=<?php echo $word->word; ?>', ()=>{})
            change()
        })
        $click('remember-a', () => {
            $get('learn.php?remember=<?php echo $word->word; ?>', ()=>{})
            change()
        })
        $click('finish-a', () => {
            $get('learn.php?finish=<?php echo $word->word; ?>', ()=>{})
            change()
        })
        $click('word-h3', () => { window.open('https://www.bing.com/dict/search?q=<?php echo urlencode($word->word); ?>') })
        function change() {
            $show('hidden-div')
            $change('next-a', ['forget-a', 'remember-a', 'finish-a'])
        }
    </script>
</body>
</html>