<?php

Require 'Database.php';

/**

*This class contains core logic of the USSD application

*

**/



class ApplicationFunctions{


   

   public function __construct(){

   }



   public function __destruct(){



   }



   public function IdentifyUser($msisdn)

   {

      $db = Database::getInstance(); 

      try



      {

         $stmt = $db->prepare("insert into sessionmanager(msisdn) values (:msisdn)");

         $stmt->bindParam(":msisdn",$msisdn);

         $stmt->execute();

         

         if($stmt->rowCount() > 0)

         { 

            return TRUE;

         }

      } catch (PDOException $e) {

         #$e->getMessage();

         return FALSE;

      }       

   }



   /**

   *Method to delete a user session 

   *@param msisdn

   *@return Boolean

   */

   public function deleteSession($msisdn)

   {

      $db = Database::getInstance();

      try

      {

         $stmt = $db->prepare("Delete FROM sessionmanager where msisdn= :msisdn");

         $stmt->bindParam(":msisdn",$msisdn);

         $stmt->execute(); 

         

         if($stmt->rowCount() > 0)

         { 

            return TRUE;

         } 

         

      } catch (PDOException $e) {

         #echo $e->getMessage();

         return FALSE;

      }

   }



    /**

     *Method to reset a users session to the first case. (Delete all of the users records except his msisdn)

     *@param msisdn

     *@return Boolean

     */

   public function deleteAllSession($msisdn)

   {

      $db = Database::getInstance();

      try

      {

         $stmt = $db->prepare("UPDATE sessionmanager SET transaction_type = NULL where msisdn= :msisdn");

         $stmt->bindParam(":msisdn",$msisdn);

         $stmt->execute(); 

         

         if($stmt->rowCount() > 0)

         { 

            return TRUE;

         } 

         

      } catch (PDOException $e) {

         #echo $e->getMessage();

         return FALSE;

      }

   }





   /**

   *Method to update user session with the actual type of transaction or details of the transaction *currently being held

   *@param msisdn, collumn, transaction type

   *@param Boolean

   **/    

   public function UpdateTransactionType($msisdn, $col, $trans_type)

   {

      $db = Database::getInstance();

      try

      {

         $stmt = $db->prepare("update sessionmanager set " .$col. " = :trans_type where msisdn = :msisdn");

         $params = array(":msisdn"=>$msisdn,":trans_type"=>$trans_type); 

         $stmt->execute($params);

         



         if($stmt->rowCount() > 0)

         { 

            return true;

         }

         

      } catch (PDOException $e) {

         #echo $e->getMessage();

         return FALSE;

      }

   }



   /**

   *Method to query specific details from the session manager. (Get value held in a specific column)

   *@param msisdn, specific column to query

   *@return string

   */ 

   public function GetTransactionType($msisdn, $col)

   {

      $db = Database::getInstance();

      try

      {

         $stmt = $db->prepare("SELECT " .$col. " FROM  sessionmanager WHERE  msisdn = :msisdn");

         $stmt->bindParam(":msisdn",$msisdn);

         $stmt->execute();



         $res = $stmt->fetch(PDO::FETCH_ASSOC);



         if($res !== FALSE)

         {

            return $res[$col];

         }

         

      } catch (PDOException $e) {

         #echo $e->getMessage();

         return NULL;

      }

   }



   /**Method that makes transaction through the given pay API
   *
   **/
   public function sendMoney(){
      
      $db = Database::getInstance();
      try{
         $stmt = $db->prepare("SELECT * FROM  sessionmanager ");
         $stmt->execute();
         $res = $stmt->fetch(PDO::FETCH_ASSOC);

         
         if($res !== FALSE)

         {
               $num=$res["msisdn"];
               $transType=$res["transaction_type"];
               $sent_amt=$res["amount"];
               $receiver=$res["receipient_no"];

         }

      }
      catch (PDOException $e) {

         #echo $e->getMessage();

         return NULL; 

      }


      $params=array("number"=>$num,"vendor"=>"tigo","uid"=>"ashesi","pass"=>"ashesi","tp"=>uniqid("ab",TRUE),"cbk"=>"http://gmpay.npontu.com/api/tigo","amount"=>$sent_amt,"msg"=>"making payment","trans_type"=>$transType);
     // $encoded=json_encode($params);
            $curl = curl_init();
            curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'http://pay.npontu.com/api/pay',
          CURLOPT_USERAGENT => 'Codular Sample cURL Request',
          CURLOPT_POST => 1,
          CURLOPT_POSTFIELDS => $params
      ));
       

               $response = curl_exec($curl);
               echo ($response);
               $error = curl_error($curl);
      
   }

   public function credit(){
      $db = Database::getInstance();
      try{
         $stmt = $db->prepare("SELECT * FROM  sessionmanager ");
         $stmt->execute();
         $res = $stmt->fetch(PDO::FETCH_ASSOC);

         
         if($res !== FALSE)

         {
               $num=$res["msisdn"];
               $transType=$res["transaction_type"];
               $sent_amt=$res["amount"];
               $receiver=$res["receipient_no"];

         }

      }
      catch (PDOException $e) {

         #echo $e->getMessage();

         return NULL; 

      }


      $params=array("number"=>$receiver,"vendor"=>"tigo","uid"=>"ashesi","pass"=>"ashesi","tp"=>uniqid("ab",TRUE),"cbk"=>"http://gmpay.npontu.com/api/tigo","amount"=>$sent_amt,"msg"=>"making payment","trans_type"=>$transType);
     // $encoded=json_encode($params);
            $curl = curl_init();
            curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => 'http://pay.npontu.com/api/pay',
          CURLOPT_USERAGENT => 'Codular Sample cURL Request',
          CURLOPT_POST => 1,
          CURLOPT_POSTFIELDS => $params
      ));
       

               $response = curl_exec($curl);
               echo ($response);
               $error = curl_error($curl);

   }

   public function sendSms($receiver){
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'api.deywuro.com/bulksms/?username=AshesiMoney&password=ashesi@123&type=0&dlr=1&destination=$receiver&source=Test&message=Transaction successful',
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);
   }



    /**

     *Method to query users session state. checking if the user has an existing session and if so the session count.

     *@param msisdn, specific column to query

     *@return string

     */

    public function  sessionManager($msisdn)

   {     

      $db = Database::getInstance();

      try

      {

         $stmt = $db->prepare("SELECT (COUNT(msisdn)+ COUNT(transaction_type)+COUNT(receipient_no)+COUNT(amount)) AS counter FROM sessionmanager WHERE msisdn = :msisdn");

         $stmt->bindParam(":msisdn",$msisdn);

         $stmt->execute();



         $res = $stmt->fetch(PDO::FETCH_ASSOC);



         if($res !== FALSE)

         {

            return $res['counter'];

         }

         

      } catch (PDOException $e) {

         #echo $e->getMessage();

         return NULL;

      }

   }



  }