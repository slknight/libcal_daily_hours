<?php 


$url = "https://YOURLIBRARY.libcal.com/widget/hours/grid?iid=YOURID&format=json&weeks=2&systemTime=0";



$json = file_get_contents($url);
$result = json_decode($json, true);

//this should be obvious, but you must have hours filled in it LibCal to get data

//troubleshooting to see what is in the XML
//var_dump($result);




//echo any of these vars to see rendered hours for that day of the week



$sunday=$result['locations'][0]['weeks'][0]['Sunday']['rendered'];
$monday=$result['locations'][0]['weeks'][0]['Monday']['rendered'];
$tuesday=$result['locations'][0]['weeks'][0]['Tuesday']['rendered'];
$wednesday=$result['locations'][0]['weeks'][0]['Wednesday']['rendered'];
$thursday=$result['locations'][0]['weeks'][0]['Thursday']['rendered'];
$friday=$result['locations'][0]['weeks'][0]['Friday']['rendered'];
$saturday=$result['locations'][0]['weeks'][0]['Saturday']['rendered'];

$today=date("l");
$date=date("Y-m-d");


if ($result['locations'][0]['weeks'][0][$today]['date']==$date)
{
echo "<ul><li>Today: <span class=\"smaller\">" . $result['locations'][0]['weeks'][0][$today]['rendered'] . "</span></li>";}

//loop is needed in case today is saturday and tomrrow is week[1]

  $tomorrow = date("l", strtotime("+1 day"));
$date2 = date("Y-m-d",  strtotime("+1 day"));





for($i=0; $i<=1; $i++) {

if ($result['locations'][0]['weeks'][$i][$tomorrow]['date']==$date2)
{


echo "<li>" . $tomorrow . ":  <span class=\"smaller\">" . $result['locations'][0]['weeks'][$i][$tomorrow]['rendered'] . "<span></li>";
}

}

$twodaysout = date("l", strtotime("+2 day"));

$date3 = date("Y-m-d",  strtotime("+2 day"));

for($j=0; $j<=1; $j++) {

if ($result['locations'][0]['weeks'][$j][$twodaysout]['date']==$date3)
{


 echo "<li>" . $twodaysout . ":  <span class=\"smaller\">" . $result['locations'][0]['weeks'][$j][$twodaysout]['rendered'] . "</span></li> </ul>";
}


}


?>

 
