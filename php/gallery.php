<h2>Галерея</h2>
<?php include_once("classes.php");
$objects=getGallery();
if ($objects){ ?>
<section>
    <div id="gallery">
        <?php for($ind=0;$ind < count($objects);$ind+=1){
            if ($objects[$ind]->type=='photo'){?>
                <img src="<?php echo $objects[$ind]->path; ?>">
            <?php }
            elseif ($objects[$ind]->type=='video'){ ?>
                <video controls>
                    <source src="<?php echo $objects[$ind]->path ?>" allowfullscreen>
                    <source src="<?php echo substr($objects[$ind]->path,0,strlen($objects[$ind]->path)-3).'ogv' ?>" allowfullscreen>
                </video>
            <?php }
        } ?>
    </section>
<?php } ?>
