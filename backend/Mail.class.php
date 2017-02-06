<?php

/**
 * Created by PhpStorm.
 * User: Acer-pc
 * Date: 2017-02-01
 * Time: 07:44
 */
class Mail
{
    private $html = <<<EOT
         
        <html>
<body>
<style>
    *{
        margin: 0;
        padding: 0;
    }
    body, #container{
        background-color: #f7ab24;
        text-align: justify;
        font-family: Arial;
    }
    li{
        margin: 2px;
        font-size: 12px;
    }
    p{
        margin: 3px;
    }
</style>
<div id="container">
    <h2>Sveikinu, ką tik užpildei anketą į EBEC!</h2>
    <p>Teliko keli žinksniai ir gali ruošis. Perskaityk taisykles ir užbaik pirmą žingsnį į EBEC</p>
    <h2>Taisyklės</h2>
    <ol>
        <li>
            Dalyvavimas patvirtinamas įkėlus reprezentatyvius CV* bei sumokant 20eu/komandai (5eu/dalyviui) depozitą (dėl depozitų perdavimo Studentų miestelyje kreiptis tel.: 862360723 (Emilija) dėl depozitų perdavimo centre kreiptis: 868662414 (Urtė)).
        </li>
        <li>
            Depozitas bus grąžintas, jei komanda dalyvaus varžybose ir užpildys atgalinio ryšio (angl. feedback) formą.**
        </li>
        <li>
            Esant nenumatytiems/kritiniams atvejams ir negalint dalyvauti varžybose kreiptis pirmame punkte nurodytais kontaktais.
        </li>
        <li>
            Tik KTU (Kauno technologijos universiteto) studentai gali dalyvauti EBEC inžinerinėse varžybose.
        </li>
    </ol>
    <p>
        * CV turi būti būti tvarkingas. CV siūlome kurti naudojant
        <a href="http://europass.lt/dokumentai/europass-cv" target=_blank>Europass šabloną</a>
        (pavyzdžius galite rasti  <a href="http://europass.cedefop.europa.eu/documents/curriculum-vitae/examples" target=_blank>čia</a>).

    </p>
    <h2>Rules</h2>
    <ol>
        <li>
            Participation to event is confirmed only after uploading a representative CV and paying a deposit of 5 €
            which is returned after the competition. (to give the deposit contact BEST Kaunas members:
            in Student campus contact 862360723 (Emilija) in city centre contact 868662414 (Urtė))
        </li>
        <li>
            Deposit will be returned if you will participate in competitions and fill feedback form.**
        </li>
        <li>
            With your registration you confirm that you will participate in the competition and agree that your CV can be transfered to company representatives.</li>
        <li>
            If you have some emergency or unplanned situations and you are not able to participate in the competition, contact people above.
        </li>
        <li>
            Only KTU (Kaunas University of Technology) students can participate in EBEC engineering Competition
        </li>

    </ol>
    <p>
        * CV must be neat. We recoment to create a CV using the
        <a href="https://europass.cedefop.europa.eu/" target=_blank>Europass template</a>
        (examples can be found here). Europass template (examples can be found <a href="http://europass.cedefop.europa.eu/documents/curriculum-vitae/examples" target=_blank>here</a>). You can also export CV from your current Linkedin profile, if there you comprehensively filled out all the information.

    </p>
</div>
</body>
</html>

EOT;

    function  send($to, $from){
        $subject = 'Registracija į EBEC';

        $headers = "From: " . strip_tags($from) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8";
        mail($to, $subject, $this->html, $headers);
    }

}