<?php 
    if (isset($_POST['sent'])) {
        $props = trim($_POST['props']);
        $props = str_replace(PHP_EOL, ',', $props);
        $props = str_replace(' ', '', $props);
        $props_arr = explode(',', $props);
        
        $protected_string = '';
        $getters_string = '';
        $setters_string = '';
        foreach ($props_arr as $prop) {
            $protected_string .= 'protected $'. htmlentities($prop). ';<br>';
            if (isset($_POST['get_getters'])) {
                $getters_string .= 'public function get'. htmlentities(ucfirst($prop)). '() {<br>';
                $getters_string .= 'return $this->'. htmlentities($prop). ';<br>';
                $getters_string .= '}<br>';
            }
            if (isset($_POST['get_setters'])) {
                $setters_string .= 'public function set'. htmlentities(ucfirst($prop)). '($'. htmlentities($prop). ')'. ' {<br>';
                $setters_string .= '$this->'. htmlentities($prop). ' = $' .htmlentities($prop). ';<br>';
                $setters_string .= '}<br>';
            }
        }
        echo $protected_string. '<br>'. $getters_string. '<br>'. $setters_string;
    }
    else {
        ?>
        <form method="post">
            <textarea name="props"></textarea>
            <div id="choices">
                <label for="cb_get_getters">přidat gettery</label>
                <input id="cb_get_getters" type="checkbox" name="get_getters">
                <label for="cb_get_setters">přidat settery</label>
                <input id="cb_get_setters" type="checkbox" name="get_setters">
            </div>
            <input type="submit" name="sent" value="odeslat">
        </form>
    <?php
    }


