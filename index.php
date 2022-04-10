<?php

require_once("TransferProvider.php");

function array_as_a_table(Array $data) : String{
    $str = '<table class="table table-striped ">
        <thead>
        <tr>
            <td><b>Key</b></td>
            <td><b>Value</b></td>
        </tr>
        </thead>';
        foreach($data as $key => $value) {
            $str .= "<tr>
                <td>$key</td>
                <td>$value</td>
            </tr>";
        }
    $str .= '</table>';
    return $str;
}

$location = isset($_POST['location'])?($_POST['location']):"https://vivazzi.pro/test-request/";
$method = isset($_POST['method'])?($_POST['method']):1;
$test = new TransferProvider();
$test->setLocation($location);



//$result = $test->sendRequest();


?>
<html>
<title>Transfer Provider</title>
    <head>
        <meta charset="UTF-8">
        <link href="resources/bootstrap.min.css" rel="stylesheet">
        <script src="resources/bootstrap.bundle.min.js"></script>
        <script src="resources/script.js"></script>

    </head>
    <body class="py-4">
        <main>
            <div class="container-md">
                <h2><a href="/">Transfer provider</a></h2>
                <div class="row mb-1">
                    <div class="col-4">
                        <p class="lead"><b>Адрес тестового запроса: </b>https://vivazzi.pro/test-request/</p>
                    </div>
                </div>

                <form method="post">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                Выберите функцию:
                            </div>
                            <div class="col-sm">
                                Введите адрес api:
                            </div>
                            <div class="col-sm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <select class="form-control" name="method">
                                    <option id="createRefillOperation1" <?php echo $method=='createRefillOperation1'?'selected':"" ?>>createRefillOperation1</option>
                                    <option id="createRefillOperation2" <?php echo $method=='createRefillOperation2'?'selected':"" ?>>createRefillOperation2</option>
                                    <option id="createPayOperation" <?php echo $method=='createPayOperation'?'selected':"" ?>>createPayOperation</option>
                                    <option id="createTransferOperation" <?php echo $method=='createTransferOperation'?'selected':"" ?>>createTransferOperation</option>
                                    <option id="declineOperation" <?php echo $method=='declineOperation'?'selected':"" ?>>declineOperation</option>
                                    <option id="getOperationList" <?php echo $method=='getOperationList'?'selected':"" ?>>getOperationList</option>
                                    <option id="getOperationData" <?php echo $method=='getOperationData'?'selected':"" ?>>getOperationData</option>
                                </select>
                            </div>
                            <div class="col-sm">
                                <input class="form-control" type="text" name="location" placeholder="http://...." value="<?php echo $location?>" size="40">
                            </div>
                            <div class="col-sm">
                                <button type="submit" class="btn btn-primary">Выполнить</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">

                            </div>
                            <div class="col-sm">
                                <small class="d-block text-muted">Для примера: https://vivazzi.pro/test-request/</small>
                            </div>
                            <div class="col-sm">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                    <?php
                    switch ($method){
                        case 'createRefillOperation1':
                            $arg1 = 'SberbankPhoneDeposit';

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

                            ?>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <td class="col-md-2">Метод </td>
                                    <td class="col-md-4"><?php echo $method?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-2">Тип запроса </td>
                                    <td class="col-md-4">POST</td>
                                </tr>
                                <tr>
                                    <td class="col-md-2">Аргумент 1</td>
                                    <td class="col-md-4"><?php echo $arg1?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-2">Аргумент 2</td>
                                    <td class="col-md-4"><pre><?php print_r(json_encode($RefillData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))?></pre></td>
                                </tr>
                                <tr>
                                    <td class="col-md-2">Результат</td>
                                    <td class="col-md-4"><pre><?php
                                        try {
                                            echo $test->createRefillOperation($arg1, $RefillData);
                                        } catch (Exception $e) {
                                            echo $e->getMessage();
                                        }
                                    ?></pre></td>
                                </tr>

                            </table>
                            <?php
                            break;
                        case 'createRefillOperation2':
                            echo 'function '.$method;
                            break;
                        case 'createPayOperation':
                            echo 'function '.$method;
                            break;
                        case 'createTransferOperation':
                            echo 'function '.$method;
                            break;
                        case 'declineOperation':
                            echo 'function '.$method;
                            break;
                        case 'getOperationList':
                            echo 'function '.$method;
                            break;
                        case 'getOperationData':
                            echo 'function '.$method;
                            break;
                    }

                    ?>

                        <hr>
                        <h4>POST в текущей форме</h4>
                        <table class="table table-bordered table-striped">
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
                    </div>
                </form>
            </div>
        </main>
    </body>


</html>
