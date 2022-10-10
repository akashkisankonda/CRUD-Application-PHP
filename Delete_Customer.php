<?php
if (!empty($_REQUEST["DeletCustomer"])) {
    $LoginId = $_REQUEST["DeletCustomer"];
    $LoginId = str_replace(" ", "", "$LoginId");
    if (strlen($LoginId) > $MinLoginIDLength) {
        require ("DB_Connect.php");
        $sql = "SELECT * FROM customers WHERE `Login Id`='$LoginId'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $sql = "DELETE FROM customers WHERE `Login Id`='$LoginId'";
            if (mysqli_query($conn, $sql)) {
                echo " <div class='alert alert-success alet-dismissible fade show'><button type='button' data-bs-dismiss='alert' class='btn-close'> </button>  Record Deleted successfully  </div>";
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
            }
            $sql = "DELETE FROM transactions WHERE `Customer LoginId`='$LoginId'";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo "Error";
            }
        }
    }
}
?>
