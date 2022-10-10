<?php
if (!empty($_REQUEST["DeletTransaction"])) {
    $InvoiceNumber = $_REQUEST["DeletTransaction"];
    $InvoiceNumber = (int)str_replace(" ", "", "$InvoiceNumber");
    if (strlen($InvoiceNumber) > $MinInvoiceNumberLength) {
        require ("DB_Connect.php");
        $sql = "SELECT * FROM transactions WHERE `Invoice Number`='$InvoiceNumber'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $sql = "DELETE FROM transactions WHERE `Invoice Number`='$InvoiceNumber'";
            if (mysqli_query($conn, $sql)) {
                echo " <div class='alert alert-success alet-dismissible fade show'><button type='button' data-bs-dismiss='alert' class='btn-close'> </button>  Record Deleted successfully  </div>";
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
            }
        }
    }
}
?>