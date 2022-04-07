<?php

require_once("connector.php");

$test = new connector();
//$test->setLocation("localhost");

$text = $test->getLocation();

$result = $test->sendRequest();
?>
<html>
    <head>
        <h2>Testing connector</h2>
    </head>
    <body>
        <?php echo $text?>

        <form method='post'>
            <span><label>Результат GET</label></span>
            <p><input type="text" name="user" value="<?php echo $result?>"></p>
            <span><label>текст</label></span>
            <p><input type="text" name="user"></p>
            <p><button type="reset">Очистить форму</button>
                <button type="submit">Отправить форму</button></p>
        </form>
        <?php
        echo isset($_POST['user'])?$_POST['user']:""; // Если выбран хоть 1 элемент
        ?>
    </body>
</html>

<?php
