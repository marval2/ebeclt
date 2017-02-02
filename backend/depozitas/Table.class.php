<?php
/**
 * User: Šlivinskas
 * Date: 14.4.12
 * Time: 21.45
 * Project: web
 * Task: ${CARET}
 */
class Table{
    private $langelis; //langelis (duomenys)
    private $eilNr; //eilučių skaičius
    private $stlNr; //stulpelių skaičius
    private $eilNrMin; //eilučių skaičius
    private $stlNrMin; //stulpelių skaičius

    private $tableAttr; //tag'e <table> atributai
    private $trAtribute; //tag'e <tr> atributai
    private $tdAttribute; //tag'e <td> atributai

    private $trApglebimasP; //prie tr tag'o priekio pridėti tekstą
    private $trApglebimasG; //prie tr tag'o galo pridėti tekstą
    private $trIdejimasP;   //tik už <tr>  pridėti tekstą
    private $trIdejimasG;   //tik prieš </tr> pridėti tekstą
    private $tdApglebimasP; //prie td tag'o priekio pridėti tekstą
    private $tdApglebimasG; //prie td tag'o galo pridėti tekstą

    public function  Table($attr=""){
        $this->tableAttr=$attr;
    }
    private function minEil($eilNr){
        if($this->eilNr<$eilNr||!isset($this->eilNr)){
            $this->eilNr=$eilNr;
        }
        if($this->eilNrMin>$eilNr||!isset($this->eilNrMin)){
            $this->eilNrMin=$eilNr;
        }
    }

    public function appData($data){
        $i = 0;
        foreach($data as $value){
            $j = 0;
            foreach($value as $r){
                $this->prideti($i,$j,$r);
                $j++;
            }
            $this->minStl($j-1);
            $i++;
        }
        $this->minEil($i-1);
    }

    public function addToRow($eilNr,$colNo,$array){
        foreach($array as $val){
            $this->prideti($eilNr,$colNo++,$val);
        }
    }

    public function addToCol($eilNr,$colNo,$array){
        foreach($array as $val){
            $this->prideti($eilNr++,$colNo,$val);
        }
    }

    private function minStl($stlNr){
        if($this->stlNr<$stlNr||!isset($this->stlNr)){
            $this->stlNr=$stlNr;
        }
        if($this->stlNrMin>$stlNr||!isset($this->stlNrMin)){
            $this->stlNrMin=$stlNr;
        }
    }

    public function addToLastRowCell($row, $col,$data){
        $langelis[$row][$col] = $data;
    }

    public function trApglebti($eilNr,$tag,$tagEnd){
        if(isset($this->trApglebimasP[$eilNr])){
            $this->trApglebimasP[$eilNr].=$tag;
        }else{
            $this->trApglebimasP[$eilNr]=$tag;
        }
        if(isset($this->trApglebimasG[$eilNr])){
            $this->trApglebimasG[$eilNr]=$this->trApglebimasG[$eilNr].$tagEnd;
        }else{
            $this->trApglebimasG[$eilNr]=$tagEnd;
        }
        $this->minEil($eilNr); // keičiam eilučių skaičių
    }

    public function trIdeti($eilNr,$tag,$tagEnd){
        $this->trIdejimasG[$eilNr]=isset($this->trIdejimasG[$eilNr])?$tagEnd.$this->trIdejimasG[$eilNr]:$tagEnd;
        $this->trIdejimasP[$eilNr]=$this->trIdejimasP[$eilNr].$tag;
        $this->minEil($eilNr);
    }

    public function tdApglebti($eilNr,$stlNr,$tag,$tagEnd){
        $this->tdApglebimasP[$eilNr][$stlNr].=$tag;
        $this->tdApglebimasG[$eilNr][$stlNr]=$this->tdApglebimasG[$eilNr][$stlNr].$tagEnd;
        $this->minEil($eilNr);
        $this->minStl($stlNr); // keičiam stulpelių skaičių
    }

    public function tableAttr($attr){
        $this->tableAttribute.=' '.$attr;
    }

    public function trAttr($eilNr,$attr){
        if(isset($this->trAtribute[$eilNr]))
            $this->trAtribute[$eilNr].=' '.$attr;
        else
            $this->trAtribute[$eilNr]= $attr;
        $this->minEil($eilNr);
    }

    public function tdAttr($eilNr,$stlNr,$attr){
        if(isset($this->tdAttribute[$eilNr][$stlNr]))
            $this->tdAttribute[$eilNr][$stlNr].=' '.$attr;
        else
            $this->tdAttribute[$eilNr][$stlNr]= ' '.$attr;
        $this->minEil($eilNr);
        $this->minStl($stlNr); // keičiam stulpelių skaičių
    }

    public function prideti($eilNr,$stlNr,$duomenys){
        if(isset($this->langelis[$eilNr][$stlNr]))
            $this->langelis[$eilNr][$stlNr]=$this->langelis[$eilNr][$stlNr].$duomenys;
        else
            $this->langelis[$eilNr][$stlNr]=$duomenys;
        $this->minEil($eilNr);
        $this->minStl($stlNr); // keičiam stulpelių skaičių
    }

    private function tuscias(&$reiksme){
        if(!isset($reiksme)){
            $reiksme="";
        }
    }

    public function pushToRowEnd($eilNr){
        print end($this->langelis[$eilNr]);

    }

    //======== Spausdinti visai lentelei ==============================================================
    public function spausdinti($antraste="<h1>Duomenų nėra</h1>"){
        $duomenys="";
        if(count($this->langelis)){
            for($i=$this->eilNrMin;$i<=$this->eilNr;$i++){

                $this->tuscias($this->tableAttribute);
                $this->tuscias($this->trIdejimasP[$i]);
                $this->tuscias($this->trIdejimasG[$i]);
                $this->tuscias($this->trApglebimasP[$i]);
                $this->tuscias($this->trApglebimasG[$i]);
                $this->tuscias($this->trAtribute[$i]);


                $duomenys.="\n	".$this->trApglebimasP[$i]."<tr".$this->trAtribute[$i].">\n".$this->trIdejimasP[$i]."\n";
                for($j = $this->stlNrMin; $j <= $this->stlNr; $j++){

                    $this->tuscias($this->tdApglebimasP[$i][$j]);
                    $this->tuscias($this->tdAttribute[$i][$j]);
                    $this->tuscias($this->tdApglebimasG[$i][$j]);
                    $this->tuscias($this->langelis[$i][$j]);

                    $duomenys.="	".$this->tdApglebimasP[$i][$j]."	<td".$this->tdAttribute[$i][$j].">".$this->langelis[$i][$j]."</td>".$this->tdApglebimasG[$i][$j]."\n";
                }
                $duomenys.=$this->trIdejimasG[$i]."\n	</tr>".$this->trApglebimasG[$i];
            }
            return "\n<table {$this->tableAttr}>".$duomenys."\n</table>";
        }else
            return is_null($antraste)?$antraste:null;
    }
}