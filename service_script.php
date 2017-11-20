<?php



//DISPLAY PHP ERRORS

// error_reporting(0);

error_reporting(E_ALL); ini_set('display_errors', 1);



//INCLUDE APPLICATIONS SCRIPT

include 'ApplicationFunctions.php';



//DEFINE CURRENT DATE

date_default_timezone_set('GMT');

$time = date('Y-m-d H:i:s');





$ussd = new ApplicationFunctions();
 $reply = '';
 $type='';

$msisdn = $_GET['number'];

$data = $_GET['body'];

$sessionID = $_GET['sessionID'];



//FUNCTION TO CHECK IF SESSION EXISTS AND THE SESSION COUNT

/*GET SESSION STATE OF THE USER*/

$sess = intval($ussd -> sessionManager($msisdn));



//CREATING LOG

$write = $time . "|Request|" . $msisdn . "|" . $sessionID . "|" . $data ."|".$sess. PHP_EOL;

file_put_contents('ussd_access.log', $write, FILE_APPEND);





if ($sess == "0") {#NO SESSION WAS FOUND -> DISPLAY WELCOME MENU



    $ussd -> IdentifyUser($msisdn);



    $reply = "Welcome to Ashesimoney mobile services" . "\r\n" ."1.Send Money" . "\r\n" ."2.Pay bill" . "\r\n" ."3. Exit";

    $type = "1";



} else {

    switch($sess) { 

        case 1 : #SESSION COUNT =1 #SERVICE LEVEL 1



            if ($data=='1'){

                $reply = "Enter recepient's number";

                $type = "0";

                 $ussd -> UpdateTransactionType($msisdn, "transaction_type", 'debit');



            }elseif ($data=='2'){

                $reply = "Apologies.Service currently not supported.";

                $type = "1";

               $ussd -> deleteSession($msisdn);



            }elseif ($data=='3'){

                $reply = "Thank you for accessing Ashesimoney mobile money services";

                $type = "0";

                $ussd -> deleteSession($msisdn);



            }else{

                $reply = "Invalid Option Selected";

                $type = "0";

                $ussd -> deleteSession($msisdn);

            }



            break;



        case 2 : #SESSION COUNT =2 #SERVICE LEVEL 2



            if (strlen($data) == 10){

                $reply = "Enter Amount"  ;

                $type = "1";

             $ussd -> UpdateTransactionType($msisdn, "receipient_no", $data);



            }else{

                $reply = "Invalid Option Selected";

                $type = "0";

                $ussd -> deleteSession($msisdn);

            }

            break;



             case 3 : #SESSION COUNT =3 #SERVICE LEVEL 3



            if (is_numeric($data)){

                $reply = "1.To confirm "."\r\n"."2.Cancel";

                $type = "1";

                 $ussd -> UpdateTransactionType($msisdn, "amount", $data);




            }else{

                $reply = "Invalid Option Selected";

                $type = "0";

                $ussd -> deleteSession($msisdn);

            }

            break;




            case 4 : #SESSION COUNT =4 #SERVICE LEVEL 4



            if ($data=='1'){

                $reply = "Thank you for accessing Ashesimoney mobile money services";


                $type = "0";
                $number=$ussd->GetTransactionType($msisdn, "receipient_no");
                $amt=$ussd->GetTransactionType($msisdn, "amount");
                $acc=$ussd->GetTransactionType($msisdn, "transaction_type");
                $response1 = json_decode($ussd->sendMoney( $msisdn, $amt, $acc), true);
                //$ussd->insert($id, $trans_id, $msisdn, $trans, $acc, $number, $amt);

                if($response1['status']==="Success")
                {

                    $response=json_decode($ussd)->credit($number, $amt, $acc,true);
                    
                }
                $ussd -> deleteSession($msisdn);
                //$ussd-> sendMoney();
                //$ussd-> credit();
                //call the api

               // $ussd -> UpdateTransactionType($msisdn, "confirm", 'STATEMENT');



            }elseif ($data=='2'){

                $reply = "Thank you for accessing Ashesimoney mobile money services";

                $type = "0";

                $ussd -> deleteSession($msisdn);




            }else{

                $reply = "Invalid Option Selected";

                $type = "0";

                $ussd -> deleteSession($msisdn);

            }



            break;



        default :

            $reply = "More session counts and menus to come.";

            $type = "0";

            $ussd -> deleteSession($msisdn);

            break;

    }

}



$response=$msisdn.'|'.$reply.'|'.$sessionID.'|'.$type;



$write = $time . "|Request_reply|". $response . PHP_EOL;

file_put_contents('ussd_access.log', $write, FILE_APPEND);



echo $response;



?>
