<?php require 'common.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>New Word | Muyu Vocabulary</title>
</head>
<body>
    <div class="container">
        <br />
        <?php if(isset($_POST['word'])) { if($_POST['word'] && addWord($_POST)) { ?>
            <div class="container">
                <div class="alert alert-success text-center">Success!</div>
                <p class="pull-right"><a href="add.php?rollback=1">roll back</a></p>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger text-center">Error!</div>
        <?php }} ?>
        <?php if(isset($_GET['rollback'])) { 
            addWordRollBack();
        ?>
            <script>history.go(-2)</script>
        <?php } ?>
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <form id="form" action="" method="POST">
                    <div class="form-group">
                        <label>Word</label>
                        <input id="word-input" name="word" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Meaning</label>
                        <input id="mean-input" name="mean" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group" id="tags-div">
                        <label>Tags</label>
                        <input name="tags[]" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Sentence</label>
                        <textarea name="sentence" class="form-control" rows="4" autocomplete="off"></textarea>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input name="finish" type="checkbox"> Finished
                        </label>
                    </div>
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
    <script src="https://cdn.moodrain.cn/static/muyu.js"></script>
    <script>
        $e('word-input').focus()
        $click('submit-btn', () => { $e('form').submit() })
        $e('mean-input').addEventListener('focus', () => {
            $get('word.php?ajax=1&search=' + $v('word-input'), () => {
                if(confirm('this word has been recorded, search it?'))
                    window.location = 'word.php?search=' + $v('word-input')
                else {
                    $e('word-input').focus()
                    $v('word-input', '')
                }
            })
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


