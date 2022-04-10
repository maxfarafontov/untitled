<?php

class TransferProvider
{
    private string  $location = ''; // адрес подключения
    private array   $card_types = array('PsbDepositAccountCard',	// Psb
                                        'SberbankPhoneDeposit',	    // ПАО Сбербанк
                                        'CashToCard',	            // VISA/MasterCard/Мир любого банка по номеру карты и AmEx/DC для БРС
                                        'Compass',	                // China UnionPay(Compass)
                                        'Otkritie',         	    // Otkritie
                                        'ElCard',	                // ElCard
                                        'Arca',	                    // Arca
                                        'Compass_Mir',	            // Мир(Compass)
                                        'Brs',	                    // Банк Русский Стандарт
                                        'KortiMilli',	            // Корти Милли
                                        'UzCard',	                // Карты Узбекистана (UzCard)
                                        'UnionPayCard'	            // China UnionPay(Compass)
                                        );

    function __construct(){
        $this->location = 'https://vivazzi.pro/test-request/';
    }

    public function getLocation() : String
    {
        return $this->location;
    }
    public function setLocation($location)
    {
        $this->location = $location;
    }

    // тестирование запроса curl
    public function sendRequest() : Array{
        $errors=array();

        $ch = curl_init($this->location);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);

        if($result === false){
            $errors[] = 'Ошибка curl: ' . curl_error($ch);
            $result = 0;
        }

        curl_close($ch);
        return array('result' => $result,
                     'errors' => implode(' | ',$errors));
    }

    /**
     * Создание операции пополнения банковской карты стандартное
     *
     * @param String    $card_type  Тип карты для пополнения
     * @param Array     $data       Данные для перевода
     *
     * @return String Идентификатор созданной операции
     *
     * @throws Exception
     */
    public function createRefillOperation(String $card_type, Array $data) : String {
        $operation_id = "null";

        try {
            // array entry check
            if (!in_array($card_type, $this->card_types)) {
                throw new InvalidArgumentException("неверный card_type (".implode(", ",$this->card_types).')');
            }

            // prepare request
//            $ch = curl_init($this->location.'api/operation/refill/'.$card_type);
            $ch = curl_init($this->location.'?json=true');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            $result_json = curl_exec($ch);
            $result_json = json_encode($result_json, JSON_UNESCAPED_UNICODE);

            // check request for errors
            $curl_errs = '';
            if (curl_errno($ch)){
                $curl_errs = curl_errno($ch);
            }
            curl_close($ch); // close handle

            // throw exception after close handle!
            if($curl_errs){
                throw new Exception("Ошибка запроса: ".implode("|", $curl_errs));
            }

            // string to array conversion
            $result_array = json_decode($result_json, true);

            // check result
            if(!isset($result_array['hasError']) || $result_array['message'] || $result_array['data']){
                throw new Exception('Некорректный ответ сервера: '.$result_json);
            } else if ((bool)$result_array['hasError'] === true){
                throw new Exception('Ошибка сервера: '.$result_array['message']);
            } else if(isset($result_array['data'])) {
                $operation_id = (string)$result_array['data'];
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }

//        {
//            "hasError": false,
//            "message": "",
//            "data": "3454356867"
//        }
//        {
//            "hasError": true,
//            "message": "Неизвестное поле \"operationId\" (class org.unistream.dto.CoreErrorDto",
//            "data": null
//        }

        return $operation_id;
    }


// комменты

//    /**
//     * Login via email and password
//     *
//     * @param Request $request Request
//     *
//     * @return Response
//     *
//     * @throws BadRequestHttpException
//     * @throws UnauthorizedHttpException
//     *
//     * @Rest\Post("/login")
//     */
//    public function loginAction(Request $request)


//    GET без параметров
//    $ch = curl_init('https://example.com');
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_HEADER, false);
//    $html = curl_exec($ch);
//    curl_close($ch);
//    echo $html;

//    GET с параметрами
//    $get = array(
//    'name'  => 'Alex',
//    'email' => 'mail@example.com'
//    );
//    $ch = curl_init('https://example.com?' . http_build_query($get));
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_HEADER, false);
//    $html = curl_exec($ch);
//    curl_close($ch);
//    echo $html;

//    post sample
//    $array = array(
//    'login'    => 'admin',
//    'password' => '1234'
//    );
//    $ch = curl_init('https://example.com');
//    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array, '', '&'));
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($ch, CURLOPT_HEADER, false);
//    $html = curl_exec($ch);
//    curl_close($ch);
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