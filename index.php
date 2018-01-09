  
<!DOCTYPE html>
<html>
    <head>
        <title>КОММЕНТАРИИ</title>
        <script src="js/jquery.js" type="text/javascript"></script>
        <script src="js/bootstrap.js" type="text/javascript"></script>
        <script src="js/ajax.js" type="text/javascript"></script>
        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body
        <div class="container">
            <h1>Список комментариев</h1>
            <?php
            include_once 'init.php';

            $db = Db::getInstance(HOST, USER, PASSWORD, DATABASE);
            $comments = new Comments($db);
            
            switch ($_GET['action']) 
            {
                case 'save_comment':
                    $comment = htmlspecialchars($_POST['comment']);
                    $parent_id = ((int)$_POST['parent_id'] == 0 ? null : (int)$_POST['parent_id']);
                    $comments->saveComment($comment, $parent_id);
                    break;
                case 'remove_comment':
                    $id = (int)$_GET['id'];
                    $comments->removeCommets($id);
                    break;
                 case 'save_parent_comment':
                    $comment = htmlspecialchars($_POST['comment']);
                    $comments->saveParentComment($comment);
                    break;
            }
            
            switch ($_GET['act']) 
            {
                case 'add_comment':
                    $parent_id = ((int)$_GET['parent_id'] == 0 ? null : (int)$_GET['parent_id']);
                    $comments->addComment($parent_id);
                    break;
                case 'add_parent_comment':
                    $comments->addParentComment();
                    break;
                default:
                    $comments->getComments();
                    break;
            }
            /*$query = $db->query("SELECT * FROM comments WHERE parent_id is null");
            foreach ($query as $value):
            ?>
                <div class="card text-center" style="width: 22rem;margin-bottom: 10px;">
                    <div class="card-header success-color white-text">
                        <?=$value['date_create']?>
                        <img src="img/add.png" alt=""/>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?=$value['comment']?></p>
                    </div>
                </div>
            <?php
                get_children($value['id'],$value['parent_id']);
            endforeach;

            function get_children($id, $parent_id) 
            {
                global $db;
                $query = $db->query("SELECT * FROM comments WHERE parent_id = ".$id);
                $margin = 0;
                foreach ($query as $value) 
                {
                    for ($i=0; $i <= $parent_id; $i++)
                    {
                        $margin += 20;
                    }
                    ?>
                    <div class="card text-center" style="width: 22rem; margin-bottom: 10px; margin-left: <?=(int)$margin?>px">
                        <div class="card-header success-color white-text">
                            <?=$value['date_create']?>
                            <?php if($margin < 100):?>
                            <img src="img/add.png" alt="" data-id="<?=$value['id']?>" onclick="addComment(this)"/>
                            <?php endif;?>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?=$value['comment']?></p>
                        </div>
                    </div>
                    <?php
                    get_children($value['id'], $value['parent_id']);
                }
            }*/
            ?>
        </div>
    </body>
</html>