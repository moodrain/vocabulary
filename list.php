<?php require 'common.php'; 
    $view = $_GET['view'] ?? 'total';
    $listWords = [];
    switch($view) {
        case 'total': $listWords = $words;break;
        case 'finish': $listWords = $finish;break;
        case 'unfinish': $listWords = $unFinish;break;
        case 'unreview': $listWords = $unReview;break;
        case 'tag': {
            $listWords = [];
            foreach($words as $word)
                if(in_array($_GET['tag'] ?? '', $word->tags))
                    $listWords[] = $word;
            break;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>List | Muyu Vocabulary</title>    
</head>
<body>
    <div class="container">
        <br />
        <ul class="list-group">
            <a href="list.php?view=total" class="list-group-item" <?php echo $view == 'total' ? 'style="background: lightblue;"' : ''; ?>><span class="badge"><?php echo count($words); ?></span>Total: </a>
            <a href="list.php?view=finish" class="list-group-item" <?php echo $view == 'finish' ? 'style="background: lightblue;"' : ''; ?>><span class="badge"><?php echo count($finish); ?></span>Finished: </a>
            <a href="list.php?view=unfinish" class="list-group-item" <?php echo $view == 'unfinish' ? 'style="background: lightblue;"' : ''; ?>><span class="badge"><?php echo count($unFinish); ?></span>Unfinished: </a>
            <a href="list.php?view=unreview" class="list-group-item" <?php echo $view == 'unreview' ? 'style="background: lightblue;"' : ''; ?>><span class="badge"><?php echo count($unReview); ?></span>Unreviewed: </a>
            <li style="list-style: none;">
                <form action="">
                    <div class="input-group">
                        <input name="view" class="hidden" value="tag">
                        <input name="tag" class="form-control" placeholder="<?php echo $_GET['tag'] ?? ''; ?>" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-default">search by tag</button>
                        </span>
                    </div>
                </form>
            </li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-striped">
                    <tr>
                        <th>word</th>
                        <th>meaning</th>
                        <th>tags</th>
                        <th>operation</th>
                    </tr>
                    <?php foreach($listWords as $word) { ?>
                        <tr <?php echo $word->finish ? '' : 'style="background: lightgray;"' ?>>
                            <td><a style="color: black;" target="_blank" href="https://www.bing.com/dict/search?q=<?php echo urlencode($word->word); ?>"><?php echo $word->word; ?></a></td>
                            <td><?php echo $word->mean; ?></td>
                            <td><?php foreach($word->tags as $tag) { ?>
                                <a target="_blank" href="list.php?view=tag&tag=<?php echo $tag; ?>" class="label label-primary"><?php echo $tag; ?></a>
                            <?php } ?></td>
                            <td><a class="btn btn-default btn-sm" href="word.php?search=<?php echo $word->word; ?>">edit</a></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <a href="/" class="btn btn-default">Home</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.moodrain.cn/static/muyu.js"></script>    
</body>
</html>