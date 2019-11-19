Date.prototype.toDateInputValue = (function(){
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});
    document.getElementById("transactionDate").value = new Date().toDateInputValue();

function getTransactionData()
{
    var tAmount = document.getElementById("moneyAmount").value;
    var tDate = document.getElementById("transactionDate").value;
    var tCategory = document.getElementById("moneyAmount").value;
    var tComment = document.getElementById("moneyAmount").value;
    
}