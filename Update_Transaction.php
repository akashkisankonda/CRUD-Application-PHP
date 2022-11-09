<?php
if (!empty($_REQUEST["InvoiceNumber"]) && !empty($_REQUEST["TUPName"]) && !empty($_REQUEST["TUPPrice"]) && !empty($_REQUEST["TUPQuantity"])) {
    $InvoiceNumber = (int) $_REQUEST["InvoiceNumber"];
    $PName = $_REQUEST["TUPName"];
    $PPrice = (int) $_REQUEST["TUPPrice"];
    $PQuantity = (int) $_REQUEST["TUPQuantity"];
    $PNameEmptySpacesCheck = str_replace(" ", "", "$PName");
    if (strlen($InvoiceNumber) > $MinInvoiceNumberLength && strlen($PPrice) >= $MinProductPriceLength && strlen($PQuantity) >= $MinProductQuantityLength && strlen($PNameEmptySpacesCheck) > $MinProductNameLength) {
        if (strlen($InvoiceNumber) < $MaxInvoiceNumberLength && strlen($PPrice) <= $MaxProductPriceLength && strlen($PQuantity) <= $MaxProductQuantityLength && strlen($PNameEmptySpacesCheck) < $MaxProductNameLength) {
            require ("DB_Connect.php");
            $InvoiceNumber = Sanitise($conn, $InvoiceNumber);
            $PName = Sanitise($conn, $PName);
            $PPrice = Sanitise($conn, $PPrice);
            $PQuantity = Sanitise($conn, $PQuantity);
            $sql = "SELECT * FROM transactions WHERE `Invoice Number`='$InvoiceNumber'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $Total = $PPrice * $PQuantity;
                $sql = "UPDATE transactions SET `Product Name`='$PName', `Product Price`='$PPrice', `Quantity`='$PQuantity', `Total`='$Total'  WHERE `Invoice Number`=$InvoiceNumber";
                if (mysqli_query($conn, $sql)) {
                    echo " <div class='alert alert-success alet-dismissible fade show'><button type='button' data-bs-dismiss='alert' class='btn-close'> </button>  Transaction updated successfully  </div>";
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>