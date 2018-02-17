<?php

foreach($subs as $sub): ?>
<option <?php echo ($categoria==$sub['id'])?'selected="selected"':'';?>value="<?php echo $sub['id'];?>">
        <?php 
            for($q=0;$q<$level;$q++) {
            echo '-- '; }
                echo $sub['nome'];        ?>
</option>
<?php
    if(count($sub['subs']) > 0) {
        $this->loadView('busca_subcategoria', array('subs' => $sub['subs'], 'level' => $level + 1, 'categoria' =>$categoria));
    }
?>
<?php endforeach; 


