var maxInvoiceNumberLength = 9999999999;
var minInvoiceNumberLength = 0;

var minLoginIdLength = 0;
var maxLoginIdLength = 9999999999;

var minCustomerNameLength = 1;
var maxCustomerNameLength = 15;

var minCustomerPhoneLength = 1;
var maxCustomerPhoneLength = 999999999999;

var minProductNameLength = 1;
var maxProductNameLength = 15;

var minProductPriceLength = 1;
var maxProductPriceLength = 9999999999;

var minProductQuantityLength = 1;
var maxProductQuantityLength = 9999999999;

function AddCustomer() {
    let LoginId = parseInt(document.forms["addcustomer"]["LoginId"].value);
    let Name = document.forms["addcustomer"]["Name"].value;
    let Phone = parseInt(document.forms["addcustomer"]["Phone"].value);

    if (ValidateCustomerDetails(LoginId, Name, Phone)) {
        return true;
    }
    return false;
}

function UpdateCustomer() {
    let LoginId = parseInt(document.forms["updatecustomer"]["ULoginId"].value);
    let Name = document.forms["updatecustomer"]["UName"].value;
    let Phone = parseInt(document.forms["updatecustomer"]["UPhone"].value);
    if (ValidateCustomerDetails(LoginId, Name, Phone)) {
        return true;
    }
    return false;
}

function UpdateTransaction() {
    let InvoiceNumber = parseInt(document.forms["updatetransaction"]["InvoiceNumber"].value);
    let PName = document.forms["updatetransaction"]["TUPName"].value;
    let PPrice = parseInt(document.forms["updatetransaction"]["TUPPrice"].value);
    let PQuantity = parseInt(document.forms["updatetransaction"]["TUPQuantity"].value);

    PName = PName.replaceAll(" ", "");

    if (!InvoiceNumber == "" && !PName == "" && !PPrice == "" && !PQuantity == "") {
        if (InvoiceNumber > minInvoiceNumberLength && InvoiceNumber <= maxInvoiceNumberLength) {
            if (ValidateTransactionsDetails(PName, PPrice, PQuantity)) {
                return true;
            }
        }
    }
    return false;
}

function AddTransaction() {
    let LoginId = parseInt(document.forms["addtransaction"]["TLoginId"].value);
    let PName = document.forms["addtransaction"]["PName"].value;
    let PPrice = parseInt(document.forms["addtransaction"]["PPrice"].value);
    let PQuantity = parseInt(document.forms["addtransaction"]["PQuantity"].value);

    PName = PName.replaceAll(" ", "");

    if (LoginId > minLoginIdLength && LoginId <= maxLoginIdLength) {
        if (ValidateTransactionsDetails(PName, PPrice, PQuantity)) {
            return true;
        }
    }
    return false;
}

function ValidateCustomerDetails(LoginId, CustomerName, CustomerPhone) {
    CustomerName = CustomerName.replaceAll(" ", "");
    if (!LoginId == "" || !CustomerName == "" || !CustomerPhone == "") {
        if (LoginId > minLoginIdLength && LoginId <= maxLoginIdLength) {
            if (CustomerName.length >= minCustomerNameLength && CustomerName.length <= maxCustomerNameLength) {
                if (CustomerPhone >= minCustomerPhoneLength && CustomerPhone <= maxCustomerPhoneLength) {
                    return true;
                }
            }
        }
    }
    return false;
}


function ValidateTransactionsDetails(ProductName, ProductPrice, ProductQuantity) {
    if (ProductName.length >= minProductNameLength && ProductName.length <= maxProductNameLength) {
        if (ProductPrice >= minProductPriceLength && ProductPrice <= maxProductPriceLength) {
            if (ProductQuantity >= minProductQuantityLength && ProductQuantity <= maxProductQuantityLength) {
                return true;
            }
        }
    }
    return false;
}
