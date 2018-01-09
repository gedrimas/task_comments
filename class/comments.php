<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comment
 *
 * @author pk
 */
class Comments 
{
    private $db = null;
    
    public function __construct($db) 
    {
        $this->db = $db;
    }
    
    public function getComments() 
    {            
        ?>
        <div>
            <a href="?act=add_parent_comment"><img src="img/add.png" alt="" data-id=""/></a>
        </div>
        <?php
        $query = $this->db->query("SELECT * FROM comments WHERE parent_id is null");
        foreach ($query as $value):
        ?>
            <div class="card text-center" style="width: 22rem;margin-bottom: 10px;">
                <div class="card-header success-color white-text">
                    <?=$value['date_create']?>
                    <a href="?act=add_comment&parent_id=<?=$value['id']?>"><img src="img/add.png" alt="" data-id="<?=$value['id']?>"/></a>
                    <a href="?action=remove_comment&id=<?=$value['id']?>"><img src="img/remove.png" alt="" data-id="<?=$value['id']?>"/></a>
                    
                </div>
                <div class="card-body">
                    <p class="card-text"><?=$value['comment']?></p>
                </div>
            </div>
        <?php
            $margin = 0;
            $this->getChildren($value['id'],$value['parent_id'],$margin);
        endforeach;
    }
    
    private function getChildren($id, $parent_id, $margin) 
    {
        $query = $this->db->query("SELECT * FROM comments WHERE parent_id = ".$id);
        $margin += 20;
        foreach ($query as $value) 
        {
            ?>
            <div class="card text-center" style="width: 22rem; margin-bottom: 10px; margin-left: <?=(int)$margin?>px">
                <div class="card-header success-color white-text">
                    <?=$value['date_create']?>
                    <?php if($margin < 80):?>
                    <a href="?act=add_comment&parent_id=<?=$value['id']?>"><img src="img/add.png" alt="" data-id="<?=$value['id']?>"/></a>
                    <?php endif;?>
                    <a href="?action=remove_comment&id=<?=$value['id']?>"><img src="img/remove.png" alt="" data-id="<?=$value['id']?>"/></a>
                </div>
                <div class="card-body">
                    <p class="card-text"><?=$value['comment']?></p>
                </div>
            </div>
            <?php
            $this->getChildren($value['id'], $value['parent_id'], $margin);
        }
    }
    
    public function addComment($parent_id)
    {
        ?>
            <div class="card text-center" style="width: 22rem;margin-bottom: 10px;">
                <div class="card-header success-color white-text">
                    <b>Добавление комментариев</b>
                </div>
                <div class="card-body">
                    <form action="/index.php?action=save_comment" method="post">
                        <input type="hidden" id="parent_id" name="parent_id" value="<?=(int)$parent_id?>">
                        <label for="comment">Коментарии</label>
                        <textarea id="comment" name="comment"></textarea>
                        <input type="submit" name="save_comment" value="Сохранить"/>
                    </form>
                </div>
            </div>
        <?php
    }
    
    public function addParentComment()
    {
        ?>
            <div class="card text-center" style="width: 22rem;margin-bottom: 10px;">
                <div class="card-header success-color white-text">
                    <b>Добавление комментариев</b>
                </div>
                <div class="card-body">
                    <form action="/index.php?action=save_parent_comment" method="post">
                        <label for="comment">Коментарии</label>
                        <textarea id="comment" name="comment"></textarea>
                        <input type="submit" name="save_parent_comment" value="Сохранить"/>
                    </form>
                </div>
            </div>
        <?php
    }

    public function saveComment($comment, $parent_id)
    {
        if($this->db->insert("INSERT INTO comments (comment, parent_id) VALUES ('".$comment."','".$parent_id."')"))
        {
            ?>
            <div class="alert-success">Комментарий сохранен</div>
            <?php
        }
        else 
        {
            ?>
            <div class="alert-danger">Комментарий не сохранен</div>
            <?php 
        }
    }
    
    public function saveParentComment($comment)
    {
        if($this->db->insert("INSERT INTO comments (comment) VALUES ('".$comment."')"))
        {
            ?>
            <div class="alert-success">Комментарий сохранен</div>
            <?php
        }
        else 
        {
            ?>
            <div class="alert-danger">Комментарий не сохранен</div>
            <?php 
        }
    }
    
    public function removeCommets($id) 
    {
        if($this->db->remove("DELETE FROM comments WHERE id = '".$id."'"))
        {
           ?>
            <div class="alert-success">Комментарий удален</div>
            <?php
        }
        else 
        {
            ?>
            <div class="alert-danger">Комментарий не удален</div>
            <?php 
        }
    }    
    
}
