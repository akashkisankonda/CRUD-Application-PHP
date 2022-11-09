<?php
if (!empty($_REQUEST["LoginId"]) && !empty($_REQUEST["Name"]) && !empty($_REQUEST["Phone"])) {
    $LoginId = (int) $_REQUEST["LoginId"];
    $Phone = (int) $_REQUEST["Phone"];
    $Name = $_REQUEST["Name"];
    $NameEmptySpacesCheck = str_replace(" ", "", "$Name");
    if (strlen($LoginId) > $MinLoginIDLength && strlen($Phone) > $MinPhoneNumberLength && strlen($NameEmptySpacesCheck) > $MinCustomerNameLength) {
        if (strlen($LoginId) < $MaxLoginIDLength && strlen($Phone) < $MaxPhoneNumberLength && strlen($NameEmptySpacesCheck) < $MaxCustomerNameLength) {
            require("DB_Connect.php");
            $LoginId = Sanitise($conn, $LoginId);
            $Name = Sanitise($conn, $Name);
            $Phone = Sanitise($conn, $Phone);
            $sql = "SELECT * FROM customers WHERE `Login Id`='$LoginId'";
            $result = mysqli_query($conn, $sql);
            if (!mysqli_num_rows($result) > 0) {
                $sql = "INSERT INTO customers (`Login Id`, `Name`, `Phone`) VALUES ('$LoginId', '$Name', '$Phone')";
                if (mysqli_query($conn, $sql)) {
                    echo " <div class='alert alert-success alet-dismissible fade show'><button type='button' data-bs-dismiss='alert' class='btn-close'> </button>  New record created successfully  </div>";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                echo " <div class='alert alert-danger alet-dismissible fade show'><button type='button' data-bs-dismiss='alert' class='btn-close'> </button>  Customer Login Id already present  </div>";
            }
        }
    }
}
?>