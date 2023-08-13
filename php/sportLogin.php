<h3>Вход для спортсменов</h3>
<?php
include_once("classes.php");
if(!isset($_POST['logbtn'])&& !isset($_POST['adbtn']))
{
?>
<script>
    document.getElementById('main').style.display='none';
</script>
<main style="background:none; margin-top:1%; height:auto;">
<form action="index.php?page=6" method="post" enctype="multipart/form-data" >
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
    <input type="submit" class="btn btn-primary" name="logbtn" value="Вход">
</form>
</main>
    <?php
    }
    else
    {
        if(isset($_POST['logbtn'])){
            $f=Tools::login("sport",$_POST['log'],$_POST['password']);
            if($f)
            {
                include_once('sport.php');
            }
        }
        if (isset($_POST['adbtn'])){
            include_once('adminLogin.php');
        }
    }?>

