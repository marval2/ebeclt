/**
 * Created by Slvinskas on 2016-12-19.
 */
(function (){
    "use strict";
    var teamName = document.getElementById("teamNameDiv").firstElementChild;
    var renderForms = function (applicantsNumber) {
        applicantsNumber = applicantsNumber || 1;
        var node = document.getElementById("applicantID_C");
        document.getElementById("registrationFormList").innerHTML = "";
        for(var i=0; i<applicantsNumber; i++) {
            var str = node.innerHTML;
            var res = str.replace(/ID_C/gi, function myFunction(x) {
                return x.replace(x, i.toString());
            });
            var rr = node.cloneNode(true);
            rr.innerHTML = res;
            rr.id = "applicant".i;
            document.getElementById("registrationFormList").appendChild(rr);
        }
    };

    document.getElementById("designTeam").addEventListener('click', function () {
        renderForms(4);
        teamName.classList.remove("hide");
    });

    document.getElementById("caseStudyTeam").addEventListener('click', function () {
        renderForms(4);
        teamName.classList.remove("hide");
    });

    document.getElementById("caseStudySingle").addEventListener('click', function () {
        renderForms(1);
        teamName.classList.add("hide");
    });

    renderForms(4);


    var form = document.forms.namedItem("registrationForm");
    form.addEventListener('submit', function(ev) {

        var oOutput = "",
            oData = new FormData(form);

        oData.append("CustomField", "This is some extra data");

        var oReq = new XMLHttpRequest();
        oReq.open("POST", "stash.php?namas", true);
        oReq.onreadystatechange = function () {
            if(oReq.readyState == XMLHttpRequest.DONE){
                showBallon(oReq.responseText)
            }
        };
        oReq.onload = function(oEvent) {
            if (oReq.status == 200) {
                oOutput = "Užregistruota!";
            } else {
                oOutput= "Neužregistruota " + oReq.status + " occurred when trying to upload your file";
            }
        };

        oReq.send(oData);
        ev.preventDefault();
    }, false);


    function showBallon(text) {
        document.getElementById("balloonText").innerHTML = text;
        document.getElementById("balloonBackground").classList.remove("hidden");
    }


    document.getElementById("balloonButton").addEventListener("click", function () {
        document.getElementById("balloonBackground").classList.add("hidden");
    })

})();