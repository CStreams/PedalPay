<?php

/**
* Structure Is Standard Open Source. Structure Sourced From And Changed/Added To: https://www.simplifiedios.net/ios-registration-form-example/
*
* User: Belal
* Date Accessed: 05/01/2019
*
*/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');

require_once $_SERVER['DOCUMENT_ROOT'].'/pedalPay/userFunctions/dbOperation.php';

$response = array ();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['hub']) && isset($_POST['item'])) {

        $db = new DbOperation();

        if ($db->userLogin($db->noHTML($_POST['email']), $db->noHTML($_POST['password']))) {

            $result = $db->checkoutAccessory($db->noHTML($_POST['hub']), $db->noHTML($_POST['item']));

            if ($result == false) {

                $response['error'] = true;
                $response['message'] = "Chosen Accessory(s) Are Not Available At The Current Time. Please Try Again Later";

            } else {

                $response['error'] = false;
                $response['message'] = $result;

            }

        } else {

            $response['error'] = true;
            $response['message'] = "User Login Failed";

        }

    } else {

        $response['error'] = true;
        $response['message'] = "All Fields Are Required To Check Out Accessories";

    }
} else {

    $response['error'] = true;
    $response['message'] = "Request Not Allowed";

}

echo json_encode($response);

?>
