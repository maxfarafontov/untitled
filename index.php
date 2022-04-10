<?php

require_once("TransferProvider.php");
//$location = 'https://vivazzi.pro/test-request/';
$location = isset($_POST['location'])?($_POST['location']):"";
$test = new TransferProvider();
$test->setLocation($location);

//$result = $test->sendRequest();

$RefillData = array("clientId"              =>"e7cea3cb-9fb5-9c18-3445-5b9fe2470ddb",
                      "card"                =>"45647568768",
                      "acceptedCurrency"    =>"RUB",
                      "withdrawCurrency"    =>"RUB",
                      "amount"              =>"100",
                      "recipientFirstName"  =>"Тест",
                      "recipientLastName"   =>"Тестовый",
                      "recipientMiddleName" =>"Тестович",
                      "cardEnprintedName"   =>"TESTVICH",
                      "claimTransferDetails"=>"details",
                      "senderPosCountry"    =>"RU"
                    );

$result = $test->createRefillOperation('SberbankPhoneDeposit', $RefillData);

?>
<html>
    <head>
        <h2>Testing connector</h2>
    </head>
    <body>

        <form method='post'>
            <span><label><b>Адрес тестового запроса: </b>https://vivazzi.pro/test-request/</label></span>
            <p><input type="text" name="location" value="<?php echo $location?>" size="40"></p>
            <span><label><b>Результат запроса: </b></label></span> <br>
            <span><?php echo $test->array_as_a_table($result)?></span><br><br>
<!--            <span><label><b>Ошибки: --><?php //echo $result['errors']?><!--</b></label></span>-->

            <p><button type="reset">Очистить форму</button>
                <button type="submit">Отправить запрос</button></p>
        </form>

        <hr>
        <h2>Тест функции </h2>
        <?php
//            echo $test->array_as_a_table($test->createRefillOperation('SberbankPhoneDeposit', array('val1','val2')));
//            echo $test->createRefillOperation('SberbankPhoneDeposit', array('val1','val2'));
        ?>
        <hr>

        <span>Данные в форме:</span>
        <table class="table">
            <thead>
            <tr>
                <td><b>Key</b></td>
                <td><b>Value</b></td>
            </tr>
            </thead>
            <?php foreach($_POST as $key => $value): ?>
                <tr>
                    <td><?php echo $key?></td>
                    <td><?php echo $value?></td>
                </tr>
            <?php endforeach; ?>

        </table>
    </body>
    <style>
        .table {
            width: 25%;
        }
        .table td {
            width: 25%;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .table li {
            padding-left: 30px;
        }
        .table li {
            box-sizing: border-box;
            padding: 5px 0;
        }
    </style>
</html>
