<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
class Tools
{
    static function connect($host="localhost:3306",$user="root",$pass="1469023578",$dbname="forum")
    {
        $cs='mysql:host='.$host.';dbname='.$dbname.';charset=utf8;';
        $options=array(
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'
        );
        try {
            $pdo=new PDO($cs,$user,$pass,$options);
            return $pdo;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
            return false;
        }
    }
    static function login($table,$login,$pass)
    {
        $login=trim($login);
        $pass=trim($pass);
        if ($login=="" || $pass=="" )
        {
            echo "<h3 style='color:red;'>Заполните все поля!<h3/>";
            return false;
        }
        $link=Tools::connect();
        if ($table=='users')
            $query=$link->prepare("SELECT id,password FROM users WHERE login=?");
        else $query=$link->prepare("SELECT id,password FROM sport WHERE login=?");
        $query->execute(array($login));
        $res=$query->fetch();
        if($res){
            if (md5($pass)==$res['password']){
                if ($table=="sport")
                    $_SESSION['sport']=$res['id'];
                else $_SESSION['admin']=$res['id'];
                return true;
            }
            else {
                echo "<h3 style='color:red;'>Неправильный пароль!<h3/>";
                return false;
            }
        }

            echo "<h3><span style='color:red;'>Пользователь не найден!</span><h3/>";
            return false;
    }
    static function mailer($name,$phone,$email){
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->setLanguage('ru', '/optional/path/to/language/directory/');
        // Настройки SMTP
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;

        $mail->Host = 'ssl://smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = 'Forum-dance';
        $mail->Password = 'dfihgr3n6VB1XFXterDp';

        // От кого
        $mail->setFrom('forum-no-reply@mail.ru', 'forum-dance.ru');

        // Кому
        $mail->addAddress('darabejdina0001@gmail.com');

        // Тема письма
        $mail->Subject = "Invitation";

        // Тело письма
        $body = "<h3>Сообщение администратору Forum-dance!</h3>
        <p><strong>Необходимо связаться с потенциальным клиентом по заявке с сайта.</strong></p>
        <p>Имя: ".$name."</p>
        <p>Номер телефона: ".$phone."</p>
        <p>Электронная почта: ".$email."</p>";
        $mail->msgHTML($body);

        // Приложение
        //$mail->addAttachment(__DIR__ . '/image.jpg');

        $mail->send();
    }
    // получение ID видео из URL
    function getYoutubeVideoID($url){

        // допустимые доменые имена в ссылке
        $names = array('www.youtube.com','youtube.com');

        // разбор адреса
        $up = parse_url($url);

        // проверка параметров
        if (isset($up['host']) && in_array($up['host'],$names) &&
            isset($up['query']) && strpos($up['query'],'v=') !== false){

            // достаем параметр ID
            $lp = explode('v=',$url);

            // отсекаем лишние параметры
            $rp = explode('&',$lp[1]);

            // возвращаем строку, либо false
            return (!empty ($rp[0]) ? $rp[0] : false);
        }
        return false;
    }
}

function application($name,$phone,$email){
    $name=trim($name);
    $phone=trim($phone);
    $email=trim($email);
    $pdo=Tools::connect();
    $ps=$pdo->prepare("INSERT INTO `requests`( `name`, `phone`, `email`) VALUES ('?','??','???')");
    $ps->execute(array($name,$phone,$email));
}

class article{
    public $id,$title,$text,$imagePath,$dateOfPublish,$main;
    function __construct($id, $tit,$text, $ip, $d, $m=0){
        $this->id=$id;
        $this->title=$tit;
        $this->text=$text;
        $this->imagePath=$ip;
        $this->dateOfPublish=$d;
        $this->main=$m;
    }
}
function getArticles(){
    $ps=null;
    $articles=array();
    try{
        $pdo=Tools::connect();
        $ps=$pdo->prepare('SELECT * FROM articles');
        $ps->execute();
        while ($row=$ps->fetch())
        {
            $article= new article($row['id'],
            $row['title'],
            $row['text'],
            $row['photo'],
            $row['date of publish'],
            $row['main']);
            array_push($articles, $article);
            if ($article->main){
                $art=$articles[0];
                $articles[0]=$articles[count($articles)-1];
                $articles[count($articles)-1]=$art;
            }
        }
        return $articles;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}
class galleryObject{
    public $id,$path,$type,$desc;
    function __construct($id,$p, $t, $d=''){
        $this->id=$id;
        $this->path=$p;
        $this->type=$t;
        $this->desc=$d;
    }

}

function getGallery(){
    $ps=null;
    $gallery=array();
    try{
        $pdo=Tools::connect();
        $ps=$pdo->prepare('SELECT * FROM gallery');
        $ps->execute();
        while ($row=$ps->fetch())
        {
            $obj= new galleryObject($row['id'],
            $row['path'],
            $row['type'],
            $row['desc']);
            array_push($gallery, $obj);
        }
        return $gallery;
    }
    catch(PDOException $e){
        echo $e->getMessage();
        return false;
    }
}

class Sport{
    public $login,$name,$birth,$indnum,$class,$sportcat,$expcat,$expmed,$group,$image;
    public $pass;
    function __construct($log,$p,$n,$b,$in=0,$c='',$s='',$ec='',$em='',$g,$i=''){
        $this->birth=$b;
        $this->login=$log;
        $this->pass=$p;
        $this->class=$c;
        $this->expcat=$ec;
        $this->expmed=$em;
        if ($g){
            $acc=Tools::connect();
            $query=$acc->prepare("SELECT groupdesc FROM groups WHERE id=?");
            $query->execute(array($g));
            $gr=$query->fetch();
            $group=$gr['groupdesc'];
        } else $group="Не прикреплен к группе";
        $this->group=$group;
        $this->image=$i;
        $this->indnum=$in;
        $this->name=$n;
        $this->sportcat=$s;
    }
    static function access($id){
        $acc=Tools::connect();
        $query=$acc->prepare("SELECT * FROM sport WHERE id=?");
        $query->execute(array($id));
        $res=$query->fetch();
        if ($res){
            $sp=new Sport($res['login'],$res['password'],$res['name'],$res['date of birth'],$res['individual number'],
            $res['class'],$res['sport category'],$res['expire date of category'],$res['expire date of med'],$res['groupid'],
            $res['image']);
            return $sp;
        }
        else return false;
    }
}

class admin{
    public $login,$pass,$name,$attgr,$attsp,$roleid;
    function __construct($log,$p,$n,$atgr='',$atsp='',$role){
        $this->login=$log;
        $this->pass=$p;
        if ($atgr){
            $gr=explode($atgr,' ');
            $acc=Tools::connect();
            for ($ind=0;$ind<count($gr);$ind++){
                $group=$acc->prepare("SELECT groupdesc FROM groups WHERE id=".$gr[$ind].";");
                $group->execute();
                $this->attgr[$ind]=$group->fetch();
            }
        }
        else $this->attgr=array();
        if ($atsp){
            $sp=explode($atsp,' ');
            $acc=Tools::connect();
            for ($ind=0;$ind<count($sp);$ind++){
                $sport=$acc->prepare("SELECT name,'date of birth' FROM sport WHERE id=".$sp[$ind].";");
                $sport->execute();
                $this->attsp[$ind]=$sport->fetch();
            }
        }
        else $this->attsp=array();
        $this->name=$n;
        $this->roleid=$role;
    }
    static function access($id){
        $acc=Tools::connect();
        $group=$acc->prepare("SELECT * FROM users WHERE id=".$id.";");
        $group->execute();
        $res=$group->fetch();
        if ($res){
            $sp=new admin($res['login'],$res['password'],$res['name'],$res['attached groups'],$res['attached sportsmen'],$res['roleid']);
            return $sp;
        }
        else return false;
    }
    function getGroups(){
        $acc=Tools::connect();
        $group=$acc->prepare("SELECT groupdesc FROM groups;");
        $group->execute();
        $res=$group->fetch();
        return $res;
    }
    function addSport($log,$p,$n,$b,$in=0,$c='',$s='',$ec='',$em='',$g,$id){
        $login=trim($log);
        $pass=trim($p);
        $name=trim($n);
        $indnum=trim($in);
        $class=trim($c);
        $sportcat=trim($s);
        $g=trim($g);
        if ($name=="" || $pass=="" ||$login==""||$b ||$g=="")
        {
            echo "<h3 style='color:red;'>Заполните все поля!<h3/>";
            return false;
        }
        if (strlen($name)<3 || strlen($login)<3 ||strlen($pass)<5 ||strlen($indnum)<5 || strlen($class)>3)
        {
            echo "<h3 style='color:red;'>Ввод некорректной длины!<h3/>";
            return false;
        }
        $acc=Tools::connect();
        $query=$acc->prepare("SELECT login FROM sport;");
        $query->execute();
        $res=$query->fetch();
        if (array_search($login,$res)){
            echo "<h3 style='color:red;'>Этот логин уже использован!<h3/>";
            return false;
        }
        $query=$acc->prepare("SELECT groupid FROM groups WHERE groupdesc=?");
        $query->execute(array($g));
        $res=$query->fetch();
        $pass=md5($pass);
        $query=$acc->prepare("INSERT INTO `sport`(`id`, `login`, `password`, `name`, `date of birth`, `individual number`,
        `class`, `sport category`, `expire date of category`, `expire date of med`, `groupid`, `image`) VALUES ('?','?',
        '?','?','?','?','?','?','?','?','?','?')");
        $query->execute(array($id,$login,$pass,$name,$b,$indnum,$class,$sportcat,$ec,$em,$res,''));
        if ($query->errorCode()){
            return false;
        }
        return true;
    }
    function showAll(){
        $acc=Tools::connect();
        $query=$acc->prepare("SELECT * FROM sport;");
        $query->execute();
        $res=$query->fetch();
        if ($res){
            $names=array();
            foreach ($res as $key=>$row)
                $names[$key]=$row['name'];
            array_multisort($names,SORT_ASC,$res);
            return $res;
        }
        else return false;
    }

    function changeSport($id,$log,$p,$n,$b,$in=0,$c='',$s='',$ec='',$em='',$g){
        $login=trim($log);
        $pass=trim($p);
        $name=trim($n);
        $indnum=trim($in);
        $class=trim($c);
        $sportcat=trim($s);
        $g=trim($g);
        if (strlen($name)<3 || strlen($login)<3 ||strlen($pass)<5 ||strlen($indnum)<5 || strlen($class)>3)
        {
            echo "<h3 style='color:red;'>Ввод некорректной длины!<h3/>";
            return false;
        }
        $acc=Tools::connect();
        $query=$acc->prepare("SELECT groupid FROM groups WHERE groupdesc=?");
        $query->execute(array($g));
        $res=$query->fetch();
        $pass=md5($pass);
        $query=$acc->prepare("UPDATE `sport` SET(`id`, `login`, `password`, `name`, `date of birth`, `individual number`,
        `class`, `sport category`, `expire date of category`, `expire date of med`, `groupid`) VALUES ('?','?',
        '?','?','?','?','?','?','?','?','?')");
        $query->execute(array($id,$login,$pass,$name,$b,$indnum,$class,$sportcat,$ec,$em,$res));
        if ($query->errorCode()){
            return false;
        }
        return true;
    }
    function deleteSport($id){
        $acc=Tools::connect();
        $query=$acc->prepare("DELETE FROM sport WHERE id=?");
        $query->execute(array($id));
    }
    function addCoach($log,$p,$n,$id,$atgr=array(),$atsp=array()){
        $login=trim($log);
        $pass=trim($p);
        $name=trim($n);
        if ($name=="" || $pass=="" ||$login=="")
        {
            echo "<h3 style='color:red;'>Заполните все поля!<h3/>";
            return false;
        }
        if (strlen($name)<3 || strlen($login)<3 ||strlen($pass)<5)
        {
            echo "<h3 style='color:red;'>Ввод некорректной длины!<h3/>";
            return false;
        }
        $acc=Tools::connect();
        $query=$acc->prepare("SELECT login FROM users;");
        $query->execute();
        $res=$query->fetch();
        if (array_search($login,$res)){
            echo "<h3 style='color:red;'>Этот логин уже использован!<h3/>";
            return false;
        }
        $attgr='';
        foreach ($atgr as $ag){
            $query=$acc->prepare("SELECT groupid FROM groups WHERE groupdesc=?");
            $query->execute(array($ag));
            $attgr.=$query.' ';
        }
        $attsp='';
        foreach ($atsp as $as){
            $query=$acc->prepare("SELECT id FROM sport WHERE name=?");
            $query->execute(array($as));
            $attsp.=$query.' ';
        }
        $pass=md5($pass);
        $query=$acc->prepare("INSERT INTO `users`(`id`, `login`, `password`,`name`, `attached groups`, `attached sportsmen`)
        VALUES ('?','?','?','?','?')");
        $query->execute(array($id,$login,$pass,$name,$attgr,$attsp));
        if ($query->errorCode()){
            return false;
        }
        return true;
    }
    function showAllCoaches(){
        $acc=Tools::connect();
        $query=$acc->prepare("SELECT * FROM users WHERE roleid=?");
        $query->execute(array(0));
        $res=$query->fetch();
        if ($res){
            $names=array();
            foreach ($res as $key=>$row)
                $names[$key]=$row['name'];
            array_multisort($names,SORT_ASC,$res);
            return $res;
        }
        else return false;
    }

    function changeCoach($id,$log,$p,$n,$atgr=array(),$atsp=array()){
        $login=trim($log);
        $pass=trim($p);
        $name=trim($n);
        if (strlen($name)<3 || strlen($login)<3 ||strlen($pass)<5)
        {
            echo "<h3 style='color:red;'>Ввод некорректной длины!<h3/>";
            return false;
        }
        $acc=Tools::connect();
        $attgr='';
        foreach ($atgr as $ag){
            $query=$acc->prepare("SELECT groupid FROM groups WHERE groupdesc=?");
            $query->execute(array($ag));
            $attgr.=$query.' ';
        }
        $attsp='';
        foreach ($atsp as $as){
            $query=$acc->prepare("SELECT id FROM sport WHERE name=?");
            $query->execute(array($as));
            $attsp.=$query.' ';
        }
        $pass=md5($pass);
        $query=$acc->prepare("UPDATE `users` SET(`id`, `login`, `password`, `name`,`attached groups`, `attached sportsmen`)
        VALUES ('?','?','?','?','?','?')");
        $query->execute(array($id,$login,$pass,$name,$attgr,$attsp));
        if ($query->errorCode()){
            return false;
        }
        return true;
    }
    function deleteCoach($id){
        $acc=Tools::connect();
        $query=$acc->prepare("DELETE FROM users WHERE id=?");
        $query->execute(array($id));
    }
    function addArticle($title,$main,$text=''){
        $title=trim($title);
        $text=trim($text);
        if ($title=="")
        {
            echo "<h3 style='color:red;'>Заполните заголовок!<h3/>";
            return false;
        }
        $acc=Tools::connect();
        if ($main){
            $query=$acc->prepare("SELECT id FROM articles WHERE main=1;");
            $query->execute();
            $res=$query->fetch();
            if ($query){
                $query=$acc->prepare("UPDATE `articles` SET `main`='0' WHERE id=?");
                $query->execute(array($res));
            }
        }
        $query=$acc->prepare("INSERT INTO `articles`( `title`, `text`,`date of publish`, `main`)
        VALUES ('?','?','?','?','?)");
        $query->execute(array($title,$text,date('Y-M-D'),$main));
        if ($query->errorCode()){
            return false;
        }
        return true;
    }
}
