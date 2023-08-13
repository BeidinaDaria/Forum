<h3>Вход для тренеров и администраторов</h3>
<?php
include_once("classes.php");
if(!isset($_POST['logadbtn']))
{
?>
<script>
    document.getElementById('main').style.display='none';
</script>
<main style="background:none; margin-top:1%; height:auto;">
<form method="post" enctype="multipart/form-data" >
    <div class="form">
        <div class="form-group">
            <label for="log">Логин:</label>
            <input type="text" class="form-control" name="log">
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" class="form-control" name="password">
        </div>
    </div>
    <input type="submit" class="btn btn-primary" name="logadbtn" value="Вход">
</form>
</main>
    <?php
    }
    else
    {
        if(isset($_POST['logadbtn'])){
            $f=Tools::login("users",$_POST['log'],$_POST['password']);
            if($f)
            {
                include_once('admin.php');
            }
        }
    }
?>
