<?php

namespace Lime\Helper;

/**
 * I18n class. Manage translations
 */
class I18n extends \Lime\Helper {

	/**
	 * @var $locale	current language
	 */
	public  $locale     = "en";
	private $_languages = array();

	public static $countries = array(

		"AF" => "Afghanistan",
		"AL" => "Albania",
		"DZ" => "Algeria",
		"AS" => "American Samoa",
		"AD" => "Andorra",
		"AO" => "Angola",
		"AI" => "Anguilla",
		"AQ" => "Antarctica",
		"AG" => "Antigua and Barbuda",
		"AR" => "Argentina",
		"AM" => "Armenia",
		"AW" => "Aruba",
		"AU" => "Australia",
		"AT" => "Austria",
		"AZ" => "Azerbaijan",
		"BS" => "Bahamas",
		"BH" => "Bahrain",
		"BD" => "Bangladesh",
		"BB" => "Barbados",
		"BY" => "Belarus",
		"BE" => "Belgium",
		"BZ" => "Belize",
		"BJ" => "Benin",
		"BM" => "Bermuda",
		"BT" => "Bhutan",
		"BO" => "Bolivia",
		"BA" => "Bosnia and Herzegovina",
		"BW" => "Botswana",
		"BV" => "Bouvet Island",
		"BR" => "Brazil",
		"IO" => "British Indian Ocean Territory",
		"BN" => "Brunei Darussalam",
		"BG" => "Bulgaria",
		"BF" => "Burkina Faso",
		"BI" => "Burundi",
		"KH" => "Cambodia",
		"CM" => "Cameroon",
		"CA" => "Canada",
		"CV" => "Cape Verde",
		"KY" => "Cayman Islands",
		"CF" => "Central African Republic",
		"TD" => "Chad",
		"CL" => "Chile",
		"CN" => "China",
		"CX" => "Christmas Island",
		"CC" => "Cocos (Keeling) Islands",
		"CO" => "Colombia",
		"KM" => "Comoros",
		"CG" => "Congo",
		"CD" => "Congo, the Democratic Republic of the",
		"CK" => "Cook Islands",
		"CR" => "Costa Rica",
		"CI" => "Cote D'Ivoire",
		"HR" => "Croatia",
		"CU" => "Cuba",
		"CY" => "Cyprus",
		"CZ" => "Czech Republic",
		"DK" => "Denmark",
		"DJ" => "Djibouti",
		"DM" => "Dominica",
		"DO" => "Dominican Republic",
		"EC" => "Ecuador",
		"EG" => "Egypt",
		"SV" => "El Salvador",
		"GQ" => "Equatorial Guinea",
		"ER" => "Eritrea",
		"EE" => "Estonia",
		"ET" => "Ethiopia",
		"FK" => "Falkland Islands (Malvinas)",
		"FO" => "Faroe Islands",
		"FJ" => "Fiji",
		"FI" => "Finland",
		"FR" => "France",
		"GF" => "French Guiana",
		"PF" => "French Polynesia",
		"TF" => "French Southern Territories",
		"GA" => "Gabon",
		"GM" => "Gambia",
		"GE" => "Georgia",
		"DE" => "Germany",
		"GH" => "Ghana",
		"GI" => "Gibraltar",
		"GR" => "Greece",
		"GL" => "Greenland",
		"GD" => "Grenada",
		"GP" => "Guadeloupe",
		"GU" => "Guam",
		"GT" => "Guatemala",
		"GN" => "Guinea",
		"GW" => "Guinea-Bissau",
		"GY" => "Guyana",
		"HT" => "Haiti",
		"HM" => "Heard Island and Mcdonald Islands",
		"VA" => "Holy See (Vatican City State)",
		"HN" => "Honduras",
		"HK" => "Hong Kong",
		"HU" => "Hungary",
		"IS" => "Iceland",
		"IN" => "India",
		"ID" => "Indonesia",
		"IR" => "Iran, Islamic Republic of",
		"IQ" => "Iraq",
		"IE" => "Ireland",
		"IL" => "Israel",
		"IT" => "Italy",
		"JM" => "Jamaica",
		"JP" => "Japan",
		"JO" => "Jordan",
		"KZ" => "Kazakhstan",
		"KE" => "Kenya",
		"KI" => "Kiribati",
		"KP" => "Korea, Democratic People's Republic of",
		"KR" => "Korea, Republic of",
		"KW" => "Kuwait",
		"KG" => "Kyrgyzstan",
		"LA" => "Lao People's Democratic Republic",
		"LV" => "Latvia",
		"LB" => "Lebanon",
		"LS" => "Lesotho",
		"LR" => "Liberia",
		"LY" => "Libyan Arab Jamahiriya",
		"LI" => "Liechtenstein",
		"LT" => "Lithuania",
		"LU" => "Luxembourg",
		"MO" => "Macao",
		"MK" => "Macedonia, the Former Yugoslav Republic of",
		"MG" => "Madagascar",
		"MW" => "Malawi",
		"MY" => "Malaysia",
		"MV" => "Maldives",
		"ML" => "Mali",
		"MT" => "Malta",
		"MH" => "Marshall Islands",
		"MQ" => "Martinique",
		"MR" => "Mauritania",
		"MU" => "Mauritius",
		"YT" => "Mayotte",
		"MX" => "Mexico",
		"FM" => "Micronesia, Federated States of",
		"MD" => "Moldova, Republic of",
		"MC" => "Monaco",
		"MN" => "Mongolia",
		"MS" => "Montserrat",
		"MA" => "Morocco",
		"MZ" => "Mozambique",
		"MM" => "Myanmar",
		"NA" => "Namibia",
		"NR" => "Nauru",
		"NP" => "Nepal",
		"NL" => "Netherlands",
		"AN" => "Netherlands Antilles",
		"NC" => "New Caledonia",
		"NZ" => "New Zealand",
		"NI" => "Nicaragua",
		"NE" => "Niger",
		"NG" => "Nigeria",
		"NU" => "Niue",
		"NF" => "Norfolk Island",
		"MP" => "Northern Mariana Islands",
		"NO" => "Norway",
		"OM" => "Oman",
		"PK" => "Pakistan",
		"PW" => "Palau",
		"PS" => "Palestinian Territory, Occupied",
		"PA" => "Panama",
		"PG" => "Papua New Guinea",
		"PY" => "Paraguay",
		"PE" => "Peru",
		"PH" => "Philippines",
		"PN" => "Pitcairn",
		"PL" => "Poland",
		"PT" => "Portugal",
		"PR" => "Puerto Rico",
		"QA" => "Qatar",
		"RE" => "Reunion",
		"RO" => "Romania",
		"RU" => "Russian Federation",
		"RW" => "Rwanda",
		"SH" => "Saint Helena",
		"KN" => "Saint Kitts and Nevis",
		"LC" => "Saint Lucia",
		"PM" => "Saint Pierre and Miquelon",
		"VC" => "Saint Vincent and the Grenadines",
		"WS" => "Samoa",
		"SM" => "San Marino",
		"ST" => "Sao Tome and Principe",
		"SA" => "Saudi Arabia",
		"SN" => "Senegal",
		"CS" => "Serbia and Montenegro",
		"SC" => "Seychelles",
		"SL" => "Sierra Leone",
		"SG" => "Singapore",
		"SK" => "Slovakia",
		"SI" => "Slovenia",
		"SB" => "Solomon Islands",
		"SO" => "Somalia",
		"ZA" => "South Africa",
		"GS" => "South Georgia and the South Sandwich Islands",
		"ES" => "Spain",
		"LK" => "Sri Lanka",
		"SD" => "Sudan",
		"SR" => "Suriname",
		"SJ" => "Svalbard and Jan Mayen",
		"SZ" => "Swaziland",
		"SE" => "Sweden",
		"CH" => "Switzerland",
		"SY" => "Syrian Arab Republic",
		"TW" => "Taiwan, Province of China",
		"TJ" => "Tajikistan",
		"TZ" => "Tanzania, United Republic of",
		"TH" => "Thailand",
		"TL" => "Timor-Leste",
		"TG" => "Togo",
		"TK" => "Tokelau",
		"TO" => "Tonga",
		"TT" => "Trinidad and Tobago",
		"TN" => "Tunisia",
		"TR" => "Turkey",
		"TM" => "Turkmenistan",
		"TC" => "Turks and Caicos Islands",
		"TV" => "Tuvalu",
		"UG" => "Uganda",
		"UA" => "Ukraine",
		"AE" => "United Arab Emirates",
		"GB" => "United Kingdom",
		"US" => "United States",
		"UM" => "United States Minor Outlying Islands",
		"UY" => "Uruguay",
		"UZ" => "Uzbekistan",
		"VU" => "Vanuatu",
		"VE" => "Venezuela",
		"VN" => "Viet Nam",
		"VG" => "Virgin Islands, British",
		"VI" => "Virgin Islands, U.s.",
		"WF" => "Wallis and Futuna",
		"EH" => "Western Sahara",
		"YE" => "Yemen",
		"ZM" => "Zambia",
		"ZW" => "Zimbabwe"
	);

	public static $currencies = array(
		'ALL' => 'Lek',
		'ARS' => '$',
		'AWG' => 'f',
		'AUD' => '$',
		'BSD' => '$',
		'BBD' => '$',
		'BYR' => 'p.',
		'BZD' => 'BZ$',
		'BMD' => '$',
		'BOB' => '$b',
		'BAM' => 'KM',
		'BWP' => 'P',
		'BRL' => 'R$',
		'BND' => '$',
		'CAD' => '$',
		'KYD' => '$',
		'CLP' => '$',
		'CNY' => '¥',
		'COP' => '$',
		'CRC' => 'c',
		'HRK' => 'kn',
		'CZK' => 'Kc',
		'DKK' => 'kr',
		'DOP' => 'RD$',
		'XCD' => '$',
		'EGP' => '£',
		'SVC' => '$',
		'EEK' => 'kr',
		'EUR' => '€',
		'FKP' => '£',
		'FJD' => '$',
		'GBP' => '£',
		'GHC' => 'c',
		'GIP' => '£',
		'GTQ' => 'Q',
		'GGP' => '£',
		'GYD' => '$',
		'HNL' => 'L',
		'HKD' => '$',
		'HUF' => 'Ft',
		'ISK' => 'kr',
		'IDR' => 'Rp',
		'IMP' => '£',
		'JMD' => 'J$',
		'JPY' => '¥',
		'JEP' => '£',
		'LVL' => 'Ls',
		'LBP' => '£',
		'LRD' => '$',
		'LTL' => 'Lt',
		'MYR' => 'RM',
		'MXN' => '$',
		'MZN' => 'MT',
		'NAD' => '$',
		'ANG' => 'f',
		'NZD' => '$',
		'NIO' => 'C$',
		'NOK' => 'kr',
		'PAB' => 'B/.',
		'PYG' => 'Gs',
		'PEN' => 'S/.',
		'PLN' => 'zl',
		'RON' => 'lei',
		'SHP' => '£',
		'SGD' => '$',
		'SBD' => '$',
		'SOS' => 'S',
		'ZAR' => 'R',
		'SEK' => 'kr',
		'CHF' => 'CHF',
		'SRD' => '$',
		'SYP' => '£',
		'TWD' => 'NT$',
		'TTD' => 'TT$',
		'TRY' => 'TL',
		'TRL' => '£',
		'TVD' => '$',
		'GBP' => '£',
		'USD' => '$',
		'UYU' => '$U',
		'VEF' => 'Bs',
		'ZWD' => 'Z$'
	);


	public function initialize(){

		$this->locale = $this->app->getClientLang();
	}

	/**
	 * Get translated string by key
	 *
	 * @param	string $key	translation key
	 * @param	array $alternative	returns if $key doesn''t exist
	 * @return	string
	 */
	public function get($key, $alternative=null, $lang=null){

		if(!$lang) {
			$lang = $this->locale;
		}

		if(!$alternative){
		  	$alternative = $key;
		}

		return isset($this->_languages[$lang][$key]) ? $this->_languages[$lang][$key]:$alternative;
	}


	/**
	 * Load language files
	 * @param  string $langfile path to language file
	 * @param  string $lang     language to merge to
	 * @return boolean
	 */
	public function load($langfile, $lang=null) {

		if(!$lang) {
			$lang = $this->locale;
		}

		if($path = $this->app->path($langfile)){

			if(!isset($this->_languages[$lang])){
				$this->_languages[$lang] = array();
			}

			$langtable = include($path);

			$this->_languages[$lang] = array_merge($this->_languages[$lang], (array)$langtable);

			return true;
		}

		return false;
	}

	/**
	 * Get language data
	 * @param  string $lang     language
	 * @return array
	 */
	public function data($lang=null) {

		if($lang) {
			return isset($this->_languages[$lang]) ? $this->_languages[$lang] : array();
		}

		return $this->_languages;
	}
}