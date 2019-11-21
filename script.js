function toggleMenu()
{
    document.getElementById('main-menu').classList.toggle("closed");
}

var x = document.getElementById('menu-dropdown-btn');
x.onclick = toggleMenu;



/*
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

$(document).ready(function getUserData() 
{
    $(".register-form").submit( function ( event ) 
    {
    // store a reference to required form elements
        var $required = $(".required");
        var $requiredMessage = $(".required-messgage");
        var $firstname = $("#firstname");
        var $lastname = $("#lastname");
        var $email = $("#email");
        var $password = $("#password");
  }); // close the submit event
}); // close ready event 
*/