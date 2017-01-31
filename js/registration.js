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
})();