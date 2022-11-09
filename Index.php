<?php 
function Sanitise($conn, $value)
{
    return mysqli_real_escape_string($conn, $value);
}
?>
<?php require("DB_Connect.php"); ?>
<?php require("Variables.php"); ?>
<?php require("Add_Customer.php"); ?>
<?php require("Delete_Customer.php"); ?>
<?php require("Update_Customer.php"); ?>
<?php require("Add_Transaction.php"); ?>
<?php require("Delete_Transaction.php"); ?>
<?php require("Update_Transaction.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
   <title>Document</title>
</head>

<body>
   <div class="table-responsive">
      <table class="table table-striped table-hover text-center">
         <tr class="table-dark">
            <th>Login Id</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Options</th>
         </tr>
         <?php
         $sql = "SELECT * FROM customers ORDER BY `ID` DESC";
         $result = mysqli_query($conn, $sql);
         $rowcount = mysqli_num_rows($result);
         if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
         ?>
         <tr>
            <td>
               <?php echo $row["Login Id"]; ?>
            </td>
            <td>
               <?php echo $row["Name"]; ?>
            </td>
            <td>
               <?php echo $row["Phone"]; ?>
            </td>
            <td><a href="/Assignment/?DLoginId=<?php echo $row["Login Id"]; ?>"><button class="btn btn-primary"> View
                     Transactions </button> </a> <a
                  href="/Assignment/?DeletCustomer=<?php echo $row["Login Id"]; ?>"><button class="btn btn-danger">
                     Delete
                  </button></a></td>
         </tr>
         <?php
            }
         }
         ?>
         <tr class="table-dark">
            <td colspan="4"> <strong>
                  <?php echo "$rowcount customers"; ?>
               </strong></td>
         </tr>
      </table>
   </div>
   <div class="btn-group d-grid gap-3">
      <button type="button" class="btn btn-success d-block" data-bs-toggle="modal" data-bs-target="#AddCustomer">
         Add Customer
      </button>
      <button type="button" class="btn btn-secondary d-block" data-bs-toggle="modal" data-bs-target="#UpdateCustomer">
         Update Customer
      </button>
      <button type="button" class="btn btn-warning d-block" data-bs-toggle="modal" data-bs-target="#AddTransaction">
         Add Transaction
      </button>
   </div>
   <!-- Customer Details -->
   <?php
   if (!empty($_GET["DLoginId"])) {
      $LoginId = (int) $_GET["DLoginId"];
      if (strlen($LoginId) > 1) {
         $sql = "SELECT * FROM customers WHERE `Login Id`='$LoginId'";
         $result = mysqli_query($conn, $sql);
         if (mysqli_num_rows($result) > 0) {
            $sql = "SELECT * FROM transactions WHERE `Customer LoginId`='$LoginId'";
            $result = mysqli_query($conn, $sql);
            $rowcount = mysqli_num_rows($result);
            if (mysqli_num_rows($result) > 0) {
   ?>
   <h6 class="display-6 text-center pt-5">Below are the transactions for selected LoginID <mark>
         <?php echo $_GET['DLoginId']; ?>
      </mark> </h6>
   <div class="table-responsive">
      <table class="table table-striped table-hover text-center">
         <tr class="table-dark">
            <th>Invoice Number</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Date</th>
            <th>Options</th>
         </tr>
         <?php
               $OverallTotal = 0;
               while ($row = mysqli_fetch_assoc($result)) {
         ?>
         <tr>
            <td>
               <?php echo $row['Invoice Number']; ?>
            </td>
            <td>
               <?php echo $row['Product Name']; ?>
            </td>
            <td>
               <?php echo $row['Product Price']; ?>
            </td>
            <td>
               <?php echo $row['Quantity']; ?>
            </td>
            <td>
               <?php echo $row['Total'];
                  $OverallTotal += $row['Total']; ?>
            </td>
            <td>
               <?php echo $row['Date']; ?>
            </td>
            <td> <a href="/Assignment/?DeletTransaction=<?php echo $row['Invoice Number']; ?>"> <button type="button"
                     class="btn btn-danger"> Delete </button></a></td>
         </tr>
         <?php
               }
         ?>
         <tr class="">
            <td colspan="5" class="text-end"> <strong>
                  <?php echo "Overall Total is $OverallTotal"; ?>
               </strong></td>
         </tr>
         <tr class="table-dark">
            <td colspan="7"> <strong>
                  <?php echo "$rowcount transactions"; ?>
               </strong></td>
         </tr>
      </table>
   </div>
   <!-- btn  -->
   <div class="btn-group d-grid gap-3">
      <button type="button" class="btn btn-secondary d-block" data-bs-toggle="modal"
         data-bs-target="#UpdateTransaction">
         Update Transaction
      </button>
   </div>
   <?php
            } else {
   ?>
   <div class="alert alert-danger show fade mt-5 text-center">
      No Transactions Available For Customer LoginID
      <?php echo $_GET['DLoginId']; ?>
   </div>
   <?php
            }
         }
      }
   }
   ?>
   </table>
   <!-- Add Customer  -->
   <form action="" name="addcustomer" onsubmit='return AddCustomer();' method="get">
      <div class="modal" id="AddCustomer">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Add Customer</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
               </div>
               <div class="modal-body">
                  <p class="text-center text-info">Please consider the length or else submit will be ignored.</p>
                  <div class="form-floating mb-3 mt-3">
                     <input type="text" class="form-control" placeholder="Enter Login ID" name="LoginId">
                     <label for="email">Login Id <small class="text-danger">
                           <?php echo "min $MinLoginIDLength length, max $MaxLoginIDLength length (Only Numbers)" ?>
                        </small></label>
                  </div>
                  <div class="form-floating mt-3 mb-3">
                     <input type="text" class="form-control" placeholder="Enter Name" name="Name">
                     <label>Name <small class="text-danger">
                           <?php echo "min $MinCustomerNameLength length, max $MaxCustomerNameLength length" ?>
                        </small></label>
                  </div>
                  <div class="form-floating mt-3 mb-3">
                     <input type="text" class="form-control" placeholder="Enter Phone" name="Phone">
                     <label>Phone <small class="text-danger">
                           <?php echo "min $MinPhoneNumberLength length, max $MaxPhoneNumberLength length (Only Numbers)" ?>
                        </small></label>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
            </div>
         </div>
      </div>
   </form>
   <!-- Update Customer  -->
   <form name="updatecustomer" onsubmit="return UpdateCustomer()" action="" method="get">
      <div class="modal" id="UpdateCustomer">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Update Customer</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
               </div>
               <div class="modal-body">
                  <p class="text-center text-info">Please consider the length or else submit will be ignored.</p>
                  <div class="form-floating mb-3 mt-3">
                     <input type="text" class="form-control" placeholder="Enter Login ID" name="ULoginId">
                     <label for="email">Login Id <small class="text-danger">
                           <?php echo "min $MinLoginIDLength length, max $MaxLoginIDLength length (Only Numbers)" ?>
                        </small></label>
                  </div>
                  <div class="form-floating mt-3 mb-3">
                     <input type="text" class="form-control" placeholder="Enter Name" name="UName">
                     <label>Name <small class="text-danger">
                           <?php echo "min $MinCustomerNameLength length, max $MaxCustomerNameLength length" ?>
                        </small></label>
                  </div>
                  <div class="form-floating mt-3 mb-3">
                     <input type="text" class="form-control" placeholder="Enter Phone" name="UPhone">
                     <label>Phone <small class="text-danger">
                           <?php echo "min $MinPhoneNumberLength length, max $MaxPhoneNumberLength length (Only Numbers)" ?>
                        </small></label>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
            </div>
         </div>
      </div>
   </form>
   <!-- AddTransaction  -->
   <form name="addtransaction" action="" onsubmit="return AddTransaction()" method="get">
      <div class="modal" id="AddTransaction">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Add Transaction</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
               </div>
               <div class="modal-body">
                  <p class="text-center text-info">Please consider the length or else submit will be ignored.</p>
                  <div class="form-floating mb-3 mt-3">
                     <input type="text" class="form-control" placeholder="Enter LoginId" name="TLoginId">
                     <label for="email">Login Id <small class="text-danger">
                           <?php echo "min $MinLoginIDLength length, max $MaxLoginIDLength length (Only Numbers)" ?>
                        </small></label>
                  </div>
                  <div class="form-floating mt-3 mb-3">
                     <input type="text" class="form-control" placeholder="Enter Name" name="PName">
                     <label>Product Name <small class="text-danger">
                           <?php echo "min $MinProductNameLength length, max $MaxProductNameLength length" ?>
                        </small></label>
                  </div>
                  <div class="form-floating mt-3 mb-3">
                     <input type="text" class="form-control" placeholder="Enter Price" name="PPrice">
                     <label>Product Price <small class="text-danger">
                           <?php echo "min $MinProductPriceLength length, max $MaxProductPriceLength length (Only Numbers)" ?>
                        </small></label>
                  </div>
                  <div class="form-floating mt-3 mb-3">
                     <input type="text" class="form-control" placeholder="Enter Quantity" name="PQuantity">
                     <label>Product Quantity <small class="text-danger">
                           <?php echo "min $MinProductQuantityLength length, max $MaxProductQuantityLength length (Only Numbers)" ?>
                        </small></label>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
            </div>
         </div>
      </div>
   </form>
   <!-- Update Transaction -->
   <form name="updatetransaction" onsubmit="return UpdateTransaction()" action="" method="get">
      <div class="modal" id="UpdateTransaction">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title">Update Transaction</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
               </div>
               <div class="modal-body">
                  <p class="text-center text-info">Please consider the length or else submit will be ignored.</p>
                  <div class="form-floating mb-3 mt-3">
                     <input type="text" class="form-control" placeholder="Enter Invoice Number" name="InvoiceNumber">
                     <label for="email">Invoice Number <small class="text-danger">
                           <?php echo "min $MinInvoiceNumberLength length, max $MaxInvoiceNumberLength length (Only Numbers)" ?>
                        </small></label>
                  </div>
                  <div class="form-floating mt-3 mb-3">
                     <input type="text" class="form-control" placeholder="Enter Name" name="TUPName">
                     <label>Product Name <small class="text-danger">
                           <?php echo "min $MinProductNameLength length, max $MaxProductNameLength length" ?>
                        </small></label>
                  </div>
                  <div class="form-floating mt-3 mb-3">
                     <input type="text" class="form-control" placeholder="Enter Price" name="TUPPrice">
                     <label>Product Price <small class="text-danger">
                           <?php echo "min $MinProductPriceLength length, max $MaxProductPriceLength length (Only Numbers)" ?>
                        </small></label>
                  </div>
                  <div class="form-floating mt-3 mb-3">
                     <input type="text" class="form-control" placeholder="Enter Quantity" name="TUPQuantity">
                     <label>Product Quantity <small class="text-danger">
                           <?php echo "min $MinProductQuantityLength length, max $MaxProductQuantityLength length (Only Numbers)" ?>
                        </small></label>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
               </div>
            </div>
         </div>
      </div>
   </form>
   <?php
   mysqli_close($conn);
   ?>
   <script src="js.js"></script>
</body>

</html>