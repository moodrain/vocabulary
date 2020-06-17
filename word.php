<?php
require 'common.php';
$word = getWord($_GET['search'] ?? null);
if(isset($_GET['ajax'])) {
    echo json_encode(['code' => $word ? 0 : -1]);
    exit();
}
if(isset($_GET['delete'])) {
    deleteWord($_GET['delete']);
    header('Location: /');
    exit();
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://s1.moodrain.cn/lib/bootstrap/index.css">
    <title>Word | Muyu Vocabulary</title>
</head>
<body>
    <div class="container">
        <br />
        <?php if(isset($_POST['word']) && $_POST['word'] && saveWord($_POST)) {
            $word = getWord($_POST['word']);
        ?>
            <div class="alert alert-success text-center">Success!</div>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <form id="form" action="" method="POST">
                    <div class="form-group">
                        <label>Word</label>
                        <input id="word-input" name="word" autocomplete="off" readonly class="form-control" value="<?php echo $word->word; ?>">
                    </div>
                    <div class="form-group">
                        <label>Meaning</label>
                        <input id="mean-input" name="mean" autocomplete="off" class="form-control" value="<?php echo $word->mean; ?>">
                    </div>
                    <div class="form-group" id="tags-div">
                        <label>Tags</label>
                        <?php foreach($word->tags as $tag) { ?>
                            <input name="tags[]" class="form-control" autocomplete="off" value="<?php echo $tag; ?>">
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <label>Sentence</label>
                        <textarea name="sentence" class="form-control" autocomplete="off" rows="4"><?php echo $word->sentence; ?></textarea>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input name="finish" type="checkbox" <?php echo $word->finish ? 'checked' : '' ?>> Finished
                        </label>
                    </div>
                    <button type="button" class="btn btn-danger" id="delete-btn">Delete</button>
                    <button type="button" class="btn btn-primary" id="submit-btn">Submit</button>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <a href="/" class="btn btn-default">Home</a>
            </div>
        </div>
    </div>
    <script src="https://s1.moodrain.cn/lib/muyu/index.js"></script>
    <script>
        $e('word-input').focus()
        $click('submit-btn', () => { $e('form').submit() })
        $click('delete-btn', () => {
            if(confirm('really want to delete?'))
                window.location = 'word.php?delete=<?php echo $_GET['search']; ?>'
        })
        document.onkeydown = event => {
		    if(event.keyCode === 13) {
                let tag = $tag('input')
                tag.className = 'form-control'
                tag.name = 'tags[]'
                tag.autocomplete = 'off'
                $add('tags-div', tag)
                tag.focus()
                tag.addEventListener('input', () => {
                    if(!$v(tag))
                        tag.parentNode.removeChild(tag)
                })
            }
        }
    </script>
</body>
</html>


