<?php include_once("classes.php");
$f=admin::access($_SESSION['admin']);
if ($f){?>
<script>
    document.getElementById('main').style.display='none';
</script>
    <h1>Личный кабинет</h1>
    <section style="color:white;">
        <div>
            <h3>ФИО: </h3>
            <h3>Прикрепленные группы: </h3>
            <h3>Прикрепленные спортсмены: </h3>
        </div>
        <div>
            <h3><?php echo $f->name;?></h3>
            <?php
            $gr='';
            if (is_array($f->attgr))
            for ($ind=0;$ind<count($f->attgr);$ind++)
            $gr .= $f->attgr[$ind].", "; ?>
            <h3><?php echo $gr;?></h3>
            <?php
            $sp='';
            if (is_array($f->attsp))
            for ($ind=0; $ind<count($f->attsp);$ind++)
            $sp .= $f->attsp[$ind].", "; ?>
            <h3><?php echo $sp;?></h3>
        </div>
    </section>
    <?php if ($f->roleid){?>
        <h3>Управление спортсменами</h3>
        <div class="news">
            <button class="nav_adaptiv" onclick="showArticle('addSport')"><p>Добавить спортсмена</p></button>
            <div class="hide-news" id="addSport">
                <form method="post" enctype="multipart/form-data" >
                    <div class="form">
                        <div>
                            <label for="login"><p>Логин: </p></label>
                            <input type="text" class="form-control" name="login" required>
                        </div>
                        <div>
                            <label for="pass"><p>Пароль: </p></label>
                            <input type="password" class="form-control" name="pass" required>
                        </div>
                        <div>
                            <label for="name"><p>ФИО: </p></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div>
                            <label for="birthdate"><p>Дата рождения: </p></label>
                            <input type="date" class="form-control" name="birthdate" required>
                        </div>
                        <div>
                            <label for="indnum"><p>Номер книжки: </p></label>
                            <input type="num" class="form-control" name="indnum">
                        </div>
                        <div>
                            <label for="class"><p>Класс мастерства: </p></label>
                            <input type="text" class="form-control" name="class">
                        </div>
                        <div>
                            <label for="cat"><p>Спортивный разряд: </p></label>
                            <input type="text" class="form-control" name="cat">
                        </div>
                        <div>
                            <label for="expcat"><p>Действует до: </p></label>
                            <input type="date" class="form-control" name="expcat">
                        </div>
                        <div>
                            <label for="expmed"><p>Мед. допуск до: </p></label>
                            <input type="date" class="form-control" name="expmed">
                        </div>
                        <div>
                            <label for="groupid"><p>Группа: </p></label>
                            <?php $gr=$f->getGroups(); ?>
                            <select name="groupid" required>
                                <?php foreach($gr as $group)
                                    echo "<option>".$gr['groupdesc']."</option>";
                                ?>
                            </select>
                        </div>
                    </div>
                    <input type="submit" name="addsport" id="addsport" value="Внести спортсмена">
                </form>
            </div>
            <?php if (isset($_POST['addsport'])){
                $result=$f->addSport($_POST['login'],$_POST['pass'],$_POST['name'],$_POST['birthdate'],$_POST['indnum'],
                $_POST['class'],$_POST['cat'],$_POST['expcat'],$_POST['expmed'],$_POST['groupid'],count($f->showAll())+1);

            }?>
            <button class="nav_adaptiv" onclick="showArticle('changeSports')"><p>Изменить спортсменов</p></button>
            <div class="hide-news" id="changeSports">
                <?php $sports=$f->showAll();
                for($ind=0;$ind<count($sports);$ind++){ ?>
                    <section>
                        <div>
                            <h3>ФИО: </h3>
                            <h3>День рождения: </h3>
                        </div>
                        <div>
                            <h3><?php echo $sports[$ind]->name;?></h3>
                            <h3><?php echo $sports[$ind]->birth;?></h3>
                        </div>
                        <button class="nav_adaptiv" onclick="showArticle('changeSport')"><p>Изменить спортсмена</p></button>
                        <div class="hide-news" id="changeSport">
                            <form method="post" enctype="multipart/form-data" >
                                <div class="form">
                                    <div>
                                        <label for="login"><p>Логин: </p></label>
                                        <input type="text" class="form-control" name="login"
                                            value="<?php echo $sports[$ind]->login ?>" required>
                                    </div>
                                    <div>
                                        <label for="pass"><p>Пароль: </p></label>
                                        <input type="password" class="form-control" name="pass"
                                            value="<?php echo $sports[$ind]->password ?>" required>
                                    </div>
                                    <div>
                                        <label for="name"><p>ФИО: </p></label>
                                        <input type="text" class="form-control" name="name"
                                            value="<?php echo $sports[$ind]->name ?>" required>
                                    </div>
                                    <div>
                                        <label for="birthdate"><p>Дата рождения: </p></label>
                                        <input type="date" class="form-control" name="birthdate"
                                            value="<?php echo $sports[$ind]->lbirth ?>" required>
                                    </div>
                                    <div>
                                        <label for="indnum"><p>Номер книжки: </p></label>
                                        <input type="num" class="form-control" name="indnum"
                                            value="<?php echo $sports[$ind]->indnum ?>" required>
                                    </div>
                                    <div>
                                        <label for="class"><p>Класс мастерства: </p></label>
                                        <input type="text" class="form-control" name="class"
                                            value="<?php echo $sports[$ind]->class ?>" required>
                                    </div>
                                    <div>
                                        <label for="cat"><p>Спортивный разряд: </p></label>
                                        <input type="text" class="form-control" name="cat"
                                            value="<?php echo $sports[$ind]->sportcat ?>" required>
                                    </div>
                                    <div>
                                        <label for="expcat"><p>Действует до: </p></label>
                                        <input type="date" class="form-control" name="expcat"
                                            value="<?php echo $sports[$ind]->expcat ?>" required>
                                    </div>
                                    <div>
                                        <label for="expmed"><p>Мед. допуск до: </p></label>
                                        <input type="date" class="form-control" name="expmed"
                                            value="<?php echo $sports[$ind]->expmed ?>" required>
                                    </div>
                                    <div>
                                        <label for="groupid"><p>Группа: </p></label>
                                        <?php $gr=$f->getGroups(); ?>
                                        <select name="groupid" value="<?php echo $sports[$ind]->groupid ?>" required>
                                            <?php foreach($gr as $group)
                                                echo "<option>".$gr['groupdesc']."</option>";
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" name="changesport" id="<?php echo $sports[$ind]->id ?>" value="Изменить спортсмена">
                                <input type="submit" name="deletesport" id="<?php echo $sports[$ind]->id ?>" value="Изменить спортсмена">
                            </form>
                        </div>
                        <?php if (isset($_POST['changesport'])){
                            $result=$f->changeSport($sports[$ind]->id,$_POST['login'],$_POST['pass'],$_POST['name'],
                            $_POST['birthdate'],$_POST['indnum'],$_POST['class'],$_POST['cat'],$_POST['expcat'],$_POST['expmed'],
                            $_POST['groupid']);
                        }
                        if (isset($_POST['deletesport'])){
                            $result=$f->deleteSport($sports[$ind]->id);
                        }?>
                    </section>
                <?php }?>
            </div>
        </div>
        <script>
            function showArticle(str) {
                let navig = document.getElementById(str);
                if (navig.className == "show-news")
                    navig.className = 'hide-news';
                else navig.className = 'show-news';
            };
        </script>
    <?php } ?>

    <form method="post">
        <input type="submit" name="outadbtn" value="Выйти">
    </form>
    <?php if(isset($_POST['outadbtn'])){
            $_SESSION['admin']='';
        }
    }
    else echo "<h3>Администратор не найден.</h3>";?>
