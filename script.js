function getTodaysDate{
    var todaysDate = new Date(); 
    var day = todaysDate.getDate();
    var month = todaysDate.getMonth()+1;
    var year = todaysDate.getFullYear();
}
function showModal(modalName){
    $(modalName).modal('toggle');
  }


function getTransactionData()
{
    var tAmount = document.getElementById("moneyAmount").value;
    var tDate = document.getElementById("transactionDate").value;
    var tCategory = document.getElementById("moneyAmount").value;
    var tComment = document.getElementById("moneyAmount").value;
    
}