<?php
foreach ($data as $id=>$img) {
    echo "<a href=" . __DIR__ ."/".$id . "><img src='$img' height ='100' width='100'></a>";
}