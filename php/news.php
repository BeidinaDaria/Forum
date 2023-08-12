<h2>Новости</h2>
<?php include_once("classes.php");
$articles=getArticles();
if ($articles){ ?>
    <section>
    <div class="main_news" style="background:url(<?php echo $articles[0]->imagePath?>);">
        <h2><?php echo $articles[0]->title?>
        <p style="margin:5px;"><?php echo $articles[0]->text?></p>
        <p><?php echo $articles[0]->dateOfPublish ?></p>
    </div>
    <div class="news">
        <?php for($ind=1;$ind < count($articles);$ind+=1){ ?>
            <div class="new" style="background:url(<?php echo $articles[$ind]->imagePath?>);background-position:center;">
                <button class="nav_adaptiv" onclick="showArticle(<?php echo $articles[$ind]->id ?>)"><p><?php echo $articles[$ind]->title ?></p></button>
                <p class="hide-news" id="<?php echo $articles[$ind]->id ?>"><?php echo $articles[$ind]->text ?></p>
            </div>
        <?php } ?>
    </div>
</section>
<script>
    function showArticle(str) {
        let navig = document.getElementById(str);
        if (navig.className == "show-news")
            navig.className = 'hide-news';
        else navig.className = 'show-news';
    };
</script>
<?php }
else echo '<p>Новостей пока нет.</p>';
?>
