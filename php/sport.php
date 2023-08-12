<?php $f=Sport::access($_SESSION['sport']);?>
<script>
    document.getElementById('main').style.display='none';
</script>
    <h1>Личный кабинет</h1>
    <section>
        <img src="<?php if ($f->image) echo $f->image; else echo 'assets/img/unknown.webp'; ?>">
        <div>
            <h3>ФИО: </h3>
            <h3>День рождения: </h3>
            <h3>Принадлежность к группе: </h3>
            <h3>Индивидуальный номер: </h3>
            <h3>Класс мастерства: </h3>
            <h3>Спортивный разряд: </h3>
            <h3>Дата окончания действия разряда: </h3>
            <h3>Дата окончания медицинского допуска: </h3>
        </div>
        <div>
            <h3><?php echo $f->name;?></h3>
            <h3><?php echo $f->birth;?></h3>
            <h3><?php echo $f->group;?></h3>
            <h3><?php echo $f->indnum;?></h3>
            <h3><?php echo $f->class;?></h3>
            <h3><?php echo $f->sportcat;?></h3>
            <h3><?php echo $f->expcat;?></h3>
            <h3><?php echo $f->expmed;?></h3>
        </div>
    </section>
    <form method="post">
        <input type="submit" name="outbtn" value="Выйти">
    </form>
    <?php if(isset($_POST['outbtn'])){
            $_SESSION['sport']='';
        }?>
