<?php require 'common.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Muyu Vocabulary</title>    
</head>
<body>
    <div class="container">
        <br />
        <ul class="list-group">
            <a href="list.php?view=total" class="list-group-item"><span class="badge"><?php echo count($words); ?></span>Total: </a>
            <a href="list.php?view=finish" class="list-group-item"><span class="badge"><?php echo count($finish); ?></span>Finished: </a>
            <a href="list.php?view=unfinish" class="list-group-item"><span class="badge"><?php echo count($unFinish); ?></span>Unfinished: </a>
            <a href="list.php?view=unreview" class="list-group-item"><span class="badge"><?php echo count($unReview); ?></span>Unreviewed: </a>
        </ul>
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <a id="search-a" class="btn btn-info">Search</a>
                <a href="tag.php" class="btn btn-warning">Tags</a>
                <a href="add.php" class="btn btn-success">New</a>
                <a href="learn.php" class="btn btn-primary">Start</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.moodrain.cn/static/muyu.js"></script>
    <script>
       $click('search-a', () => {
            let search
            if(search = prompt('input the word to search')) {
                $get('word.php?ajax=1&search=' + search, rs => {
                    window.location = 'word.php?search=' + search
                }, error => {
                    alert('word not found')
                    $e('search-a').click()
                })
            }
       })
    </script>
</body>
</html>