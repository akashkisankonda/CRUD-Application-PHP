<?php
if (!empty($_REQUEST["TLoginId"]) && !empty($_REQUEST["PName"]) && !empty($_REQUEST["PPrice"]) && !empty($_REQUEST["PQuantity"])) {
    $LoginId = (int) $_REQUEST["TLoginId"];
    $PPrice = (int) $_REQUEST["PPrice"];
    $PQuantity = (int) $_REQUEST["PQuantity"];
    $PName = $_REQUEST["PName"];
    
    $PNameEmptySpacesCheck = str_replace(" ", "", "$PName");
    if (strlen($LoginId) > $MinLoginIDLength && strlen($PPrice) >= $MinProductPriceLength && strlen($PQuantity) >= $MinProductQuantityLength && strlen($PNameEmptySpacesCheck) > $MinProductNameLength) {
        if (strlen($LoginId) < $MaxLoginIDLength && strlen($PPrice) <= $MaxProductPriceLength && strlen($PQuantity) <= $MaxProductQuantityLength && strlen($PNameEmptySpacesCheck) < $MaxProductNameLength) {
            require ("DB_Connect.php");
            $LoginId = Sanitise($conn, $LoginId);
            $PName = Sanitise($conn, $PName);
            $PPrice = Sanitise($conn, $PPrice);
            $PQuantity = Sanitise($conn, $PQuantity);
            $sql = "SELECT * FROM customers WHERE `Login Id`='$LoginId'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $InvoiceNumber = rand(999, 9999);
                $Total = $PQuantity * $PPrice;
                $sql = "INSERT INTO transactions (`Customer LoginId`, `Invoice Number` ,`Product Name`, `Product Price`, `Quantity`, `Total`) VALUES ('$LoginId', '$InvoiceNumber', '$PName', '$PPrice', '$PQuantity', $Total)";
                if (mysqli_query($conn, $sql)) { ?>
<div class="alert alert-success show fade alert-dismissible">
   Transaction Added Successfully
   <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php
                }
            }
        }
    }
}
?>