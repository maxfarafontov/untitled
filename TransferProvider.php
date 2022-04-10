<?php

class TransferProvider
{
    private string $location = ''; // адрес подключения
    private $card_types = array('PsbDepositAccountCard',	//Пополнение карточки или счета Psb
                                    'SberbankPhoneDeposit',	//Пополнение карты ПАО Сбербанк
                                    'CashToCard',	//Пополнение банковской карты VISA/MasterCard/Мир любого банка по номеру карты и AmEx/DC для БРС
                                    'Compass',	//Пополнение банковской карты China UnionPay(Compass)
                                    'Otkritie',	//Пополнение карт (Otkritie)
                                    'ElCard',	//Пополнение карт Киргизии (ElCard)
                                    'Arca',	//Пополнение карт Армении (Arca)
                                    'Compass_Mir',	//Пополнение банковской карты Мир(Compass)
                                    'Brs',	//Пополнение банковской карты Банка русский стандарт
                                    'KortiMilli',	//Пополнение карт Корти Милли
                                    'UzCard',	//Пополнение карт Узбекистана (UzCard)
                                    'UnionPayCard'	//Пополнение банковской карты China UnionPay(Compass)
                                );

    public function array_as_a_table(Array $data) : String{
        $str = '<table class="table">
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

//    public static String createRefillOperation(
//              RefillType  type,
//              RefillData data);
//    throws operationException, IOException;

    /**
     * Создание операции пополнения банковской карты стандартное
     *
     * @param String $type RefillCardType - Тип карты для пополнения
     * @param Array $data RefillData - Данные для перевода
     *
     * @return String Идентификатор созданной операции
     *
     * @throws operationException
     * @throws IOException
     */
    public function createRefillOperation(String $type, Array $data) : Array {
        $operation_id = '';
        // array entry check
        try {
            if (!in_array($type, $this->card_types)) {
                throw new Exception("Неверный тип банковской карты.");
            }
        } catch (Exception $e) {
            return array('error'=> $e->getMessage());
//            echo $e->getMessage();
//            die();
        }

//        $ch = curl_init($this->location.'api/operation/refill/'.'{type}');
//        $ch = curl_init($this->location.'?json=true');
        $ch = curl_init($this->location);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); // если JSON
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE)); // если JSON
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = curl_exec($ch);
        curl_close($ch);
//        $res = json_encode($res, JSON_UNESCAPED_UNICODE); // если JSON



        return array('operation_id'=> '', 'result'=> $result); // String	Идентификатор созданной операции
//        return $operation_id; // String	Идентификатор созданной операции
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