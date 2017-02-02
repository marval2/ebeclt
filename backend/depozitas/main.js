/**
 * Created by Acer-pc on 2017-02-02.
 */

(function () {
    var cell =document.querySelectorAll('.approve');
    var approve = function () {
        var id = this.id.split("_")[1];
        var checked = this.checked ? "true" : "false";
        var oOutput = "",
            oData = new FormData();

        oData.append("id", id);

        oData.append("approved", checked);

        var oReq = new XMLHttpRequest();
        oReq.open("POST", "/backend/depozitas/index.php", true);
        oReq.onreadystatechange = function () {
            if(oReq.readyState == XMLHttpRequest.DONE){
                alert(oReq.responseText)
            }
        };

        oReq.onload = function(oEvent) {
            if (oReq.status == 200) {
                oOutput = "Patvirtintas";
            } else {
                oOutput= "Nepatvirtinta, nes nutiko klaida: " + oReq.status;
            }
        };

        oReq.send(oData);

    };
    for(var i=0;i<cell.length;i++){
        cell[i].addEventListener('click',approve,false);
    }
})();