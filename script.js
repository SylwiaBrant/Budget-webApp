/*//SIGN IN/UP FORMS VALIDATION
(function() 
 {
  'use strict';
    window.addEventListener('load', function() 
    {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) 
        {
            form.addEventListener('submit', function(event) 
            {
                if (form.checkValidity() === false) 
                {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();*/

function showModal(modalName){
    $(modalName).modal('toggle');
  }


/*

function getTransactionData()
{
    var tAmount = document.getElementById("moneyAmount").value;
    var tDate = document.getElementById("transactionDate").value;
    var tCategory = document.getElementById("moneyAmount").value;
    var tComment = document.getElementById("moneyAmount").value;
    
}
*/