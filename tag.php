<?php require 'common.php';
    $search = $_GET['search'] ?? null;
    $tagList = [];
    if($search)
        $tagList = in_array($search, $tags) ? [$search => (function($words, $search){
            $return = new stdClass;
            $return->count = 0;
            foreach($words as $word)
                if(in_array($search, $word->tags))
                    $return->count++;
            return $return;
        })($words, $search)] : [];
    else
        foreach($tags as $tag) {
            $tagList[$tag] = new stdClass;
            foreach($words as $word) 
                if(in_array($tag, $word->tags))
                    $tagList[$tag]->count = isset($tagList[$tag]->count) ? ++$tagList[$tag]->count : 1;
        }
    uasort($tagList, function($tag1, $tag2) {
        return $tag2->count <=> $tag1->count;
    });
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Tag | Muyu Vocabulary</title>    
</head>
<body>
    <div class="container">
        <br />
        <ul class="list-group">
            <li style="list-style: none;">
                <form action="">
                    <div class="input-group">
                        <input name="search" class="form-control" placeholder="<?php echo $_GET['search'] ?? ''; ?>" autocomplete="off">
                        <span class="input-group-btn">
                            <button class="btn btn-default">search</button>
                        </span>
                    </div>
                </form>
            </li>
        </ul>
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-striped">
                    <tr>
                        <th>tag</th>
                        <th>count</th>
                    </tr>
                    <?php foreach($tagList as $tagName => $tag) { ?>
                        <tr>
                            <td><?php echo $tagName;?></td>
                            <td><a href="list.php?view=tag&tag=<?php echo urlencode($tagName); ?>"><?php echo $tag->count; ?></a></td>
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