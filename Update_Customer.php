<?php
if (!empty($_REQUEST["ULoginId"]) && !empty($_REQUEST["UName"]) && !empty($_REQUEST["UPhone"])) {
    $LoginId = (int) $_REQUEST["ULoginId"];
    $Name = $_REQUEST["UName"];
    $Phone = (int) $_REQUEST["UPhone"];
    $NameEmptySpacesCheck = str_replace(" ", "", "$Name");
    if (strlen($LoginId) > $MinLoginIDLength && strlen($Phone) > $MinPhoneNumberLength && strlen($NameEmptySpacesCheck) > $MinCustomerNameLength) {
        if (strlen($LoginId) < $MaxLoginIDLength && strlen($Phone) < $MaxPhoneNumberLength && strlen($NameEmptySpacesCheck) < $MaxCustomerNameLength) {
            require("DB_Connect.php");
            $LoginId = Sanitise($conn, $LoginId);
            $Name = Sanitise($conn, $Name);
            $Phone = Sanitise($conn, $Phone);
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