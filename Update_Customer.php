<?php
if (!empty($_REQUEST["ULoginId"]) && !empty($_REQUEST["UName"]) && !empty($_REQUEST["UPhone"])) {
    $LoginId = $_REQUEST["ULoginId"];
    $Name = $_REQUEST["UName"];
    $Phone = $_REQUEST["UPhone"];
    $LoginId = (int)str_replace(" ", "", "$LoginId");
    $Name = str_replace(" ", "", "$Name");
    $Phone = (int)str_replace(" ", "", "$Phone");
    if (strlen($LoginId) > $MinLoginIDLength && strlen($Phone) > $MinPhoneNumberLength && strlen($Name) > $MinCustomerNameLength) {
        if (strlen($LoginId) < $MaxLoginIDLength && strlen($Phone) < $MaxPhoneNumberLength && strlen($Name) < $MaxCustomerNameLength) {
            require ("DB_Connect.php");
            $sql = "SELECT * FROM customers WHERE `Login Id`='$LoginId'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $sql = "UPDATE customers SET `Name`='$Name', `Phone`='$Phone' WHERE `Login Id`=$LoginId";
                if (mysqli_query($conn, $sql)) {
                    echo " <div class='alert alert-success alet-dismissible fade show'><button type='button' data-bs-dismiss='alert' class='btn-close'> </button>  Record updated successfully  </div>";
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>
