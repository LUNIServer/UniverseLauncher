<?php
	function getSessionPhaseName($phaseid){
		switch ($phaseid){
			case 0:
				return "INVALID";
			case 1:
				return "CONNECTED";
			case 2:
				return "AUTHENTIFIED";
			case 3:
				return "PLAYING";
			case 4:
				return "INWORLD";
		}
	}
	
	function getZoneDesc($zoneid){
		switch ($zoneid){
			case 1000:
				return "VENTURE EXPLORER";
			case 1001:
				return "RETURN TO VENTURE EXPOLRER";
			case 1100:
				return "AVANT GARDENS";
			case 1101:
				return "AVANT GARDENS SURVIVAL";
			case 1102:
				return "SPIDER QUEEN BATTLE";
			case 1150:
				return "BLOCK YARD";
			case 1151:
				return "AVANT GROVE";
			case 1200:
				return "NIMBUS STATION";
			case 1201:
				return "PET COVE";
			case 1203:
				return "VERTIGO LOOP RACETRACK";
			case 1204:
				return "BATTLE OF NIMBUS STATION";
			case 1250:
				return "NIMBUS ROCK";
			case 1251:
				return "NIMBUS ISLE";
			case 1300:
				return "GNARLED FOREST";
			case 1302:
				return "CANYON COVE";
			case 1303:
				return "KEELHAUL CANYON";
			case 1350:
				return "CHANTEY SHANTY";
			case 1400:
				return "FORBIDDEN VALLEY";
			case 1402:
				return "FORBIDDEN VALLEY DRAGON";
			case 1403:
				return "DRAGONMAW CHASM";
			case 1450:
				return "RAVEN BLUFF";
			case 1600:
				return "STARBASE 3001";
			case 1601:
				return "DEEP FREEZE";
			case 1602:
				return "ROBOT CITY";
			case 1603:
				return "MOON BASE";
			case 1604:
				return "PORTABELLO";
			case 1700:
				return "LEGO CLUB";
			case 1800:
				return "CRUX PRIME";
			case 1900:
				return "NECUS TOWER";
			case 2000:
				return "NINJAGO MONASTERY";
			case 2001:
				return "FRANKJAW BATTLE";
			default:
				return "UNKNOWN";
		}
	}
?>