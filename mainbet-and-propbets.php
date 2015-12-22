<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

// Manual config vars

$betting = "closed"; // set to "closed" if the event is running
$competitor1 = "fyrstikken";
$competitor2 = "Rod from Brasil";
$competitor3 = "Marty from Canada";
$competitor4 = "emike";
$comp1address = "17MeymBmT1EN5fZ1y9dsq1aCEYcT5X7ZMN";
$comp2address = "1AXduXr8G8AsvgAYKAkFtNE7JvHqGwMuQB";
$comp3address = "1NWSDENkXLnrzgWthNuoAHSKsGtDsVndy7";
$comp4address = "1FpkDdThcKc1YunSkMMj2CgoD61BoPJzn3";
$eventdate = "December 2015";
$prop1yaddress = "1LDvJnKwQ6RopC55NUjwLAtu45J7sLWNqv";
$prop1naddress = "1KJq9fKtuLDBngK2BEmRmsRr2en6LKgnTi";
$prop2yaddress = "1Jsb96DuMqhLzpCSYKvPiC5mEonQY6PtUR";
$prop2naddress = "1NXhWem82ZzHKpoirR6T53rbxjfg89UKA7";

$event = "offline"; // set to "live" if the event is ongoing


if ($betting == 'closed') {
// SET THE CURRENT BALANCES WHEN BETTING IS CLOSED
$tradingcomp1 = '0.07418681';
$tradingcomp2 = '0.0735';
$tradingcomp3 = '0.0375';
$tradingcomp4 = '0.06888513';
$prop1y = '0.9';
$prop1n = '0.9';
$prop2y = '1.85';
$prop2n = '0.51';
} else {
$grabbettingaddresses = file_get_contents("https://btc.blockr.io/api/v1/address/info/$comp1address,$comp2address,$comp3address,$comp4address,$prop1yaddress,$prop1naddress,$prop2yaddress,$prop2naddress?confirmations=0");
$decodedjsonbalances = json_decode($grabbettingaddresses, true);

$tradingcomp1 = $decodedjsonbalances['data'][0]['balance'];
$tradingcomp2 = $decodedjsonbalances['data'][1]['balance'];
$tradingcomp3 = $decodedjsonbalances['data'][2]['balance'];
$tradingcomp4 = $decodedjsonbalances['data'][3]['balance'];
$prop1y = $decodedjsonbalances['data'][4]['balance'];
$prop1n = $decodedjsonbalances['data'][5]['balance'];
$prop2y = $decodedjsonbalances['data'][6]['balance'];
$prop2n = $decodedjsonbalances['data'][7]['balance'];

}

$pottotal = $tradingcomp1 + $tradingcomp2 + $tradingcomp3 + $tradingcomp4;
$rake = '0.04';
$postrakepot = (1-$rake)*$pottotal;
$ourprofit = $rake*$pottotal;

$prop1total = $prop1y + $prop1n;
$postrakeprop1 = (1-$rake)*$prop1total;
$prop2total = $prop2y + $prop2n;
$postrakeprop2 = (1-$rake)*$prop2total;


$totalpottotal = $pottotal + $prop1total + $prop2total;
$postraketotalpot = (1-$rake)*$totalpottotal;


if ($pottotal == 0) {
$tc1odds = 0;
$tc1perc = 0;
$tc1payout = 0;
$tc2odds = 0;
$tc2perc = 0;
$tc2payout = 0;
$tc3odds = 0;
$tc3perc = 0;
$tc3payout = 0;
$tc4odds = 0;
$tc4perc = 0;
$tc4payout = 0;

} else {
$tc1odds = $tradingcomp1 / ($pottotal);
$tc1perc = round($tc1odds*100, 4);
$tc2odds = $tradingcomp2 / ($pottotal);
$tc2perc = round($tc2odds*100, 4);
$tc3odds = $tradingcomp3 / ($pottotal);
$tc3perc = round($tc3odds*100, 4);
$tc4odds = $tradingcomp4 / ($pottotal);
$tc4perc = round($tc4odds*100, 4);



if ($tc1odds == 0) {
$tc1payout = 0;
}
else {
$tc1payout = round((1-$rake)*(1/$tc1odds), 4);
}
if ($tc2odds == 0) {
$tc2payout = 0;
} else {
$tc2payout = round((1-$rake)*(1/$tc2odds), 4);
}
if ($tc3odds == 0) {
$tc3payout = 0;
} else {
$tc3payout = round((1-$rake)*(1/$tc3odds), 4);
}
if ($tc4odds == 0) {
$tc4payout = 0;
} else {
$tc4payout = round((1-$rake)*(1/$tc4odds), 4);
}

}

if ($prop1total == 0) {
$p1yodds = 0;
$p1yperc = 0;
$p1ypayout = 0;

$p1nodds = 0;
$p1nperc = 0;
$p1npayout = 0;



}
else {
$p1yodds = $prop1y / $prop1total;
$p1yperc = round($p1yodds*100, 4);

$p1nodds = $prop1n / $prop1total;
$p1nperc = round($p1nodds*100, 4);

if ($p1yodds == 0) {
$p1ypayout = 0;
} else {
$p1ypayout = round((1-$rake)*(1/$p1yodds), 4);
}
if ($p1nodds == 0) {
$p1npayout = 0;
} else {
$p1npayout = round((1-$rake)*(1/$p1nodds), 4);
}

}
if ($prop2total == 0) {
$p2yodds = 0;
$p2yperc = 0;
$p2ypayout = 0;

$p2nodds = 0;
$p2nperc = 0;
$p2npayout = 0;
}
else {
$p2yodds = $prop2y / $prop2total;
$p2yperc = round($p2yodds*100, 4);

$p2nodds = $prop2n / $prop2total;
$p2nperc = round($p2nodds*100, 4);

if ($p2yodds == 0) {
$p2ypayout = 0;
} else {
$p2ypayout = round((1-$rake)*(1/$p2yodds), 4);
}
if ($p2nodds == 0) {
$p2npayout = 0;
} else {
$p2npayout = round((1-$rake)*(1/$p2nodds), 4);
}

}
$rakepct = $rake * 100;
echo "<br>";
if ($event == "live") {
echo "Event is LIVE! <a href='https://www.youtube.com/watch?v=Hc04K7ebU3U'> View livestream here </a> ";
echo "<br>";
echo "<iframe width=\"854\" height=\"480\" src=\"https://www.youtube.com/embed/Hc04K7ebU3U\" frameborder=\"0\" allowfullscreen></iframe>";
}
else {
echo "Event is <b> $event </b>";
}
echo "<br>";
echo "Predictions are:<b> $betting </b>right now.";
echo "<br>";
echo "$eventdate";
echo "<br>";
echo "<b>Total pot total: $postraketotalpot BTC</b>";
echo "<br>";

print_r('Rake: '.$rakepct.'%');
echo "<br>";
print_r('Pre-rake Pot: '.$totalpottotal.' BTC');
echo "<br>";
// print_r('(house cut: '.$ourprofit.' BTC)');
echo "<br>";
print_r('<b>Note: Payments are made to address that deposited, so make sure you deposit from an address you can access and arent sending with POOLED transactions (Xapo, most exchanges, etc.)</b>');
echo "<br>";
print_r('<b>If you accidently sent from an address you cant access, contact Adam or swapman on Whale Club TS</b>');
echo "<br>";
print_r('Predictions close at at exactly <b>ONE HOUR into the event (5:15 UTC Sat)</b>, where the odds are locked in. Any further BTC sent will not be in the pot.');
echo "<br>";

echo "<b>Pot total: $postrakepot BTC</b>";
echo "<br>";

print_r('Rake: '.$rakepct.'%');
echo "<br>";
print_r('Pre-rake Pot: '.$pottotal.' BTC');
echo "<br>";
echo "<h2>Main Prediction Pool: Who Will Win The Competition?</h2>";
echo "<style type=\"text/css\">\n"; 
echo ".tg  {border-collapse:collapse;border-spacing:0;}\n"; 
echo ".tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}\n"; 
echo ".tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}\n"; 
echo ".tg .tg-e3zv{font-weight:bold}\n"; 
echo ".tg .tg-db0a{text-decoration:underline}\n"; 
echo ".tg .tg-9hbo{font-weight:bold;vertical-align:top}\n"; 
echo ".tg .tg-yw4l{vertical-align:top}\n"; 
echo "</style>\n"; 
echo "<table class=\"tg\">\n"; 
echo "  <tr>\n"; 
echo "    <th class=\"tg-031e\"></th>\n"; 
echo "    <th class=\"tg-db0a\">Odds</th>\n"; 
echo "    <th class=\"tg-db0a\">QR</th>\n"; 
echo "    <th class=\"tg-db0a\">Balance</th>\n"; 
echo "  </tr>\n"; 
echo "  <tr>\n"; 
echo "    <td class=\"tg-e3zv\"><img src='fyrstikkentrader.png'><br> $competitor1</td>\n"; 
echo "    <td class=\"tg-031e\">$tc1perc% Probability, $tc1payout'x Payout</td>\n"; 
if ($betting == "closed") {
echo "    <td class=\"tg-031e\">Predictions closed!</td>\n"; 
} else {
echo "    <td class=\"tg-031e\"><img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=$comp1address'><br>$comp1address</td>\n"; 
}
echo "    <td class=\"tg-031e\">$tradingcomp1 BTC</td>\n"; 
echo "  </tr>\n"; 
echo "  <tr>\n"; 
echo "    <td class=\"tg-e3zv\"><img src='rodtrader.png'><br> $competitor2</td>\n"; 
echo "    <td class=\"tg-031e\">$tc2perc% Probability, $tc2payout'x Payout</td>\n"; 
if ($betting == "closed") {
echo "    <td class=\"tg-031e\">Predictions closed!</td>\n"; 
} else {
echo "    <td class=\"tg-031e\"><img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=$comp2address'><br>$comp2address</td>\n"; 
}
echo "    <td class=\"tg-031e\">$tradingcomp2 BTC</td>\n"; 
echo "  </tr>\n"; 
echo "  <tr>\n"; 
echo "    <td class=\"tg-e3zv\"><img src='martytrader.png'><br> $competitor3</td>\n"; 
echo "    <td class=\"tg-031e\">$tc3perc% Probability, $tc3payout'x Payout</td>\n"; 
if ($betting == "closed") {
echo "    <td class=\"tg-031e\">Predictions closed!</td>\n"; 
} else {
echo "    <td class=\"tg-031e\"><img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=$comp3address'><br>$comp3address</td>\n"; 
}
echo "    <td class=\"tg-031e\">$tradingcomp3 BTC</td>\n"; 
echo "  </tr>\n"; 
echo "  <tr>\n"; 
echo "    <td class=\"tg-9hbo\"><img src='emiketrader.png'><br> $competitor4</td>\n"; 
echo "    <td class=\"tg-yw4l\">$tc4perc% Probability, $tc4payout'x Payout</td>\n"; 
if ($betting == "closed") {
echo "    <td class=\"tg-031e\">Predictions closed!</td>\n"; 
} else {
echo "    <td class=\"tg-yw4l\"><img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=$comp4address'><br>$comp4address</td>\n"; 
}
echo "    <td class=\"tg-yw4l\">$tradingcomp4 BTC</td>\n"; 
echo "  </tr>\n"; 
echo "</table>\n";

echo "<br>";
echo "<b>Pot total: $postrakeprop1 BTC</b>";
echo "<br>";

print_r('Rake: '.$rakepct.'%');
echo "<br>";
print_r('Pre-rake Pot: '.$prop1total.' BTC');
echo "<br>";

echo "<h2>Prop Bet: Will anyone get margin called?</h2>";

echo "<table class=\"tg\">\n"; 
echo "  <tr>\n"; 
echo "    <th class=\"tg-031e\"></th>\n"; 
echo "    <th class=\"tg-db0a\">Odds</th>\n"; 
echo "    <th class=\"tg-db0a\">QR</th>\n"; 
echo "    <th class=\"tg-db0a\">Balance</th>\n"; 
echo "  </tr>\n"; 
echo "  <tr>\n"; 
echo "    <td class=\"tg-e3zv\">Yes</td>\n"; 
echo "    <td class=\"tg-031e\">$p1yperc% Probability, $p1ypayout'x Payout</td>\n"; 
if ($betting == "closed") {
echo "    <td class=\"tg-031e\">Predictions closed!</td>\n"; 
} else {
echo "    <td class=\"tg-031e\"><img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=$prop1yaddress'><br>$prop1yaddress</td>\n"; 
}
echo "    <td class=\"tg-031e\">$prop1y BTC</td>\n"; 
echo "  </tr>\n"; 
echo "  <tr>\n"; 
echo "    <td class=\"tg-e3zv\">No</td>\n"; 
echo "    <td class=\"tg-031e\">$p1nperc% Probability, $p1npayout'x Payout</td>\n"; 
if ($betting == "closed") {
echo "    <td class=\"tg-031e\">Predictions closed!</td>\n"; 
} else {
echo "    <td class=\"tg-031e\"><img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=$prop1naddress'><br>$prop1naddress</td>\n"; 
}
echo "    <td class=\"tg-031e\">$prop1n BTC</td>\n"; 
echo "  </tr>\n"; 

echo "</table>\n";


echo "<br>";
echo "<b>Pot total: $postrakeprop2 BTC</b>";
echo "<br>";

print_r('Rake: '.$rakepct.'%');
echo "<br>";
print_r('Pre-rake Pot: '.$prop2total.' BTC');
echo "<br>";

echo "<h2>Prop Bet: Will the traders make profit as a group?</h2>";

echo "<table class=\"tg\">\n"; 
echo "  <tr>\n"; 
echo "    <th class=\"tg-031e\"></th>\n"; 
echo "    <th class=\"tg-db0a\">Odds</th>\n"; 
echo "    <th class=\"tg-db0a\">QR</th>\n"; 
echo "    <th class=\"tg-db0a\">Balance</th>\n"; 
echo "  </tr>\n"; 
echo "  <tr>\n"; 
echo "    <td class=\"tg-e3zv\">Yes</td>\n"; 
echo "    <td class=\"tg-031e\">$p2yperc% Probability, $p2ypayout'x Payout</td>\n"; 
if ($betting == "closed") {
echo "    <td class=\"tg-031e\">Predictions closed!</td>\n"; 
} else {
echo "    <td class=\"tg-031e\"><img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=$prop2yaddress'><br>$prop2yaddress</td>\n"; 
}
echo "    <td class=\"tg-031e\">$prop2y BTC</td>\n"; 
echo "  </tr>\n"; 
echo "  <tr>\n"; 
echo "    <td class=\"tg-e3zv\">No</td>\n"; 
echo "    <td class=\"tg-031e\">$p2nperc% Probability, $p2npayout'x Payout</td>\n"; 
if ($betting == "closed") {
echo "    <td class=\"tg-031e\">Predictions closed!</td>\n"; 
} else {
echo "    <td class=\"tg-031e\"><img src='https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=$prop2naddress'><br>$prop2naddress</td>\n"; 
}
echo "    <td class=\"tg-031e\">$prop2n BTC</td>\n"; 
echo "  </tr>\n"; 

echo "</table>\n";

?>

