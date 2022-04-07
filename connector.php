<?php

class connector
{
    public string $location = 'https://vivazzi.pro/test-request/'; // адрес подключения

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function sendRequest(){

        $ch = curl_init($this->location);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $html = curl_exec($ch);
        curl_close($ch);

        return $html;
    }


//    GET без параметров
//    $ch = curl_init('https://example.com');
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_HEADER, false);
//    $html = curl_exec($ch);
//    curl_close($ch);
//
//    echo $html;

//    GET с параметрами
//    $get = array(
//    'name'  => 'Alex',
//    'email' => 'mail@example.com'
//    );
//
//    $ch = curl_init('https://example.com?' . http_build_query($get));
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_HEADER, false);
//    $html = curl_exec($ch);
//    curl_close($ch);
//
//    echo $html;

//    post sample
//    $array = array(
//    'login'    => 'admin',
//    'password' => '1234'
//    );
//
//    $ch = curl_init('https://example.com');
//    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array, '', '&'));
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_HEADER, false);
//    $html = curl_exec($ch);
//    curl_close($ch);
//
//    echo $html;


//    public static String createRefillOperation(
//              RefillType  type,
//              RefillData data);
//    throws operationException, IOException;
//
//    //----------------------------------------
//    public static <RefillSpecificData>
//    String createRefillOperation(
//    RefillType  type,
//    BaseRefillData data,
//    RefillSpecificData specific)
//    throws operationException, IOException;
//
//    //----------------------------------------
//    public static <PaySpecificData>
//    String createPayOperation(
//    PayType  type,
//    String amount,
//    String acceptedCurrency,
//    String withdrawCurrency,
//    PaySpecificData specific)
//    throws operationException, IOException;
//
//    //----------------------------------------
//    public statiс
//    String createTransferOperation(
//    TransferType  type,
//    TransferData data)
//    throws operationException, IOException;
//
//    //----------------------------------------
//    public static void declineOperation(
//    String operationId)
//    throws operationException;
//
//    //----------------------------------------
//    public static List<Operation> getOperationList(
//    DateTime dataFrom,
//    DateTime dateTo);
//
//    //----------------------------------------
//    public static OperationData getOperationData(
//    String operationId)
//    throws operationException;

}