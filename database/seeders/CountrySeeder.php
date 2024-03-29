<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    protected $countries_with_dial_code = [
		['code' => 'AF','dial_code' => '+93','nationality' => 'Afghanistan' ],
        ['code' => 'AL','dial_code' => '+355','nationality' => 'Albania' ],
        ['code' => 'DZ','dial_code' => '+213','nationality' => 'Algeria' ],
        ['code' => 'AS','dial_code' => '+1684','nationality' => 'American Samoa' ],
        ['code' => 'AD','dial_code' => '+376','nationality' => 'Andorra' ],
        ['code' => 'AO','dial_code' => '+244','nationality' => 'Angola' ],
        ['code' => 'AI','dial_code' => '+1264','nationality' => 'Anguilla' ],
        ['code' => 'AG','dial_code' => '+1268','nationality' => 'Antigua and Barbuda' ],
        ['code' => 'AM','dial_code' => '+374','nationality' => 'Armenia' ],
        ['code' => 'AR','dial_code' => '+54','nationality' => 'Argentina' ],
        ['code' => 'AQ','dial_code' => '+672','nationality' => 'Antarctica'],
        ['code' => 'AW','dial_code' => '+297','nationality' => 'Aruba' ],
        ['code' => 'AU','dial_code' => '+61','nationality' => 'Australia'],
        ['code' => 'AT','dial_code' => '+43','nationality' => 'Austria' ],
        ['code' => 'AZ','dial_code' => '+994','nationality' => 'Azerbaijan' ],
        ['code' => 'BS','dial_code' => '+1242','nationality' => 'Bahamas' ],
        ['code' => 'BH','dial_code' => '+973','nationality' => 'Bahrain' ],
        ['code' => 'BD','dial_code' => '+880','nationality' => 'Bangladesh'],
        ['code' => 'BB','dial_code' => '+1246','nationality' => 'Barbados'],
		['code' => 'BY','dial_code' => '+375','nationality' => 'Belarus'],
		['code' => 'BE','dial_code' => '+32','nationality' => 'Belgium'],
		['code' => 'BZ','dial_code' => '+501','nationality' => 'Belize'],
		['code' => 'BJ','dial_code' => '+229','nationality' => 'Benin'],
        ['code' => 'BM','dial_code' => '+1441','nationality' => 'Bermuda'],
        ['code' => 'BT','dial_code' => '+975','nationality' => 'Bhutan' ],
        ['code' => 'BQ','dial_code' => '+599','nationality' => 'Bonaire' ],
        ['code' => 'BO','dial_code' => '+591','nationality' => 'Bolivia'],
        ['code' => 'BI','dial_code' => '+257','nationality' => 'Burundi' ],
        ['code' => 'BA','dial_code' => '+387','nationality' => 'Bosnia and Herzegovina' ],
        ['code' => 'BW','dial_code' => '+267','nationality' => 'Botswana' ],
        ['code' => 'BV','dial_code' => '+44','nationality' => 'Bouvet Island' ],
        ['code' => 'IO','dial_code' => '+246','nationality' => 'British lndian Ocean Territory' ],
        ['code' => 'BR','dial_code' => '+55','nationality' => 'Brazil' ],
        ['code' => 'BN','dial_code' => '+673','nationality' => 'Brunei Darussalam' ],
        ['code' => 'BG','dial_code' => '+359','nationality' => 'Bulgaria' ],
        ['code' => 'BF','dial_code' => '+226','nationality' => 'Burkina Faso' ],
        ['code' => 'KH','dial_code' => '+855','nationality' => 'Cambodia' ],
        ['code' => 'CM','dial_code' => '+237','nationality' => 'Cameroon' ],
        ['code' => 'CA','dial_code' => '+1','nationality' => 'Canada' ],
        ['code' => 'CC','dial_code' => '+61','nationality' => 'Cocos (Keeling) Islands' ],
        ['code' => 'CV','dial_code' => '+238','nationality' => 'Cape Verde' ],
        ['code' => 'CA','dial_code' => '+1','nationality' => 'Central African Republic' ],
        ['code' => 'KY','dial_code' => '+1345','nationality' => 'Cayman Islands' ],
        ['code' => 'TD','dial_code' => '+235','nationality' => 'Chad' ],
        ['code' => 'GB','dial_code' => '+44','nationality' => 'Channel Islands' ],
        ['code' => 'CL','dial_code' => '+56','nationality' => 'Chile' ],
        ['code' => 'CN','dial_code' => '+86','nationality' => 'China' ],
        ['code' => 'CO','dial_code' => '+57','nationality' => 'Colombia' ],
        ['code' => 'CG','dial_code' => '+242','nationality' => 'Congo' ],
        ['code' => 'CD','dial_code' => '+243','nationality' => 'Democratic Republic of the Congo' ],
        ['code' => 'CR','dial_code' => '+506','nationality' => 'Costa Rica'],
        ['code' => 'KM','dial_code' => '+269','nationality' => 'Comoros' ],
        ['code' => 'HR','dial_code' => '+385','nationality' => 'Croatia (Hrvatska)' ],
        ['code' => 'CX','dial_code' => '+61','nationality' => 'Christmas Island' ],
        ['code' => 'CW','dial_code' => '+599','nationality' => 'Curaçao' ],
        ['code' => 'CY','dial_code' => '+357','nationality' => 'Cyprus' ],
        ['code' => 'CZ','dial_code' => '+420','nationality' => 'Czech Republic' ],
        ['code' => 'DK','dial_code' => '+45','nationality' => 'Denmark' ],
        ['code' => 'DM','dial_code' => '+1767','nationality' => 'Dominica' ],
        ['code' => 'DO','dial_code' => '+1809','nationality' => 'Dominican Republic' ],
        ['code' => 'ER','dial_code' => '+291','nationality' => 'Eritrea' ],
        ['code' => 'TL','dial_code' => '+670','nationality' => 'East Timor' ],
        ['code' => 'EC','dial_code' => '+593','nationality' => 'Ecuador' ],
        ['code' => 'EG','dial_code' => '+20','nationality' => 'Egypt' ],
        ['code' => 'SV','dial_code' => '+503','nationality' => 'El Salvador' ],
        ['code' => 'EE','dial_code' => '+372','nationality' => 'Estonia' ],
        ['code' => 'ET','dial_code' => '+251','nationality' => 'Ethiopia' ],
        ['code' => 'FJ','dial_code' => '+679','nationality' => 'Fiji' ],
        ['code' => 'FI','dial_code' => '+358','nationality' => 'Finland' ],
        ['code' => 'FR','dial_code' => '+33','nationality' => 'France' ],
        ['code' => 'GF','dial_code' => '+594','nationality' => 'Equatorial Guinea' ],
        ['code' => 'PF','dial_code' => '+689','nationality' => 'French Polynesia' ],
        ['code' => 'TF','dial_code' => '+44','nationality' => 'French Southern Territories' ],
        ['code' => 'GA','dial_code' => '+241','nationality' => 'Gabon' ],
        ['code' => 'GM','dial_code' => '+220','nationality' => 'Gambia' ],
        ['code' => 'GE','dial_code' => '+995','nationality' => 'Georgia' ],
        ['code' => 'DE','dial_code' => '+49','nationality' => 'Germany' ],
        ['code' => 'GH','dial_code' => '+233','nationality' => 'Ghana' ],
        ['code' => 'GR','dial_code' => '+30','nationality' => 'Greece' ],
        ['code' => 'GD','dial_code' => '+1473','nationality' => 'Grenada' ],
        ['code' => 'GI','dial_code' => '+350','nationality' => 'Gibraltar' ],
        ['code' => 'KY','dial_code' => '+1345','nationality' => 'Grand Cayman' ],
        ['code' => 'GB','dial_code' => '+44','nationality' => 'United Kingdom' ],
        ['code' => 'VG','dial_code' => '+1284','nationality' => 'Great Thatch Island' ],
        ['code' => 'VG','dial_code' => '+1284','nationality' => 'Great Tobago Island' ],
        ['code' => 'GL','dial_code' => '+299','nationality' => 'Greenland' ],
        ['code' => 'GP','dial_code' => '+590','nationality' => 'Guadeloupe' ],
        ['code' => 'GU','dial_code' => '+1671','nationality' => 'Guam' ],
        ['code' => 'GT','dial_code' => '+502','nationality' => 'Guatemala' ],
        ['code' => 'GN','dial_code' => '+224','nationality' => 'Guinea' ],
        ['code' => 'GW','dial_code' => '+245','nationality' => 'Guinea-Bissau' ],
        ['code' => 'GY','dial_code' => '+592','nationality' => 'Guyana' ],
        ['code' => 'GF','dial_code' => '+594','nationality' => 'French Guiana' ],
        ['code' => 'HT','dial_code' => '+509','nationality' => 'Haiti' ],
        ['code' => 'HN','dial_code' => '+504','nationality' => 'Honduras' ],
        ['code' => 'HK','dial_code' => '+852','nationality' => 'Hong Kong' ],
        ['code' => 'HU','dial_code' => '+36','nationality' => 'Hungary' ],
        ['code' => 'IS','dial_code' => '+354','nationality' => 'Iceland' ],
        ['code' => 'IN','dial_code' => '+91','nationality' => 'India' ],
        ['code' => 'ID','dial_code' => '+62','nationality' => 'Indonesia' ],
        ['code' => 'IQ','dial_code' => '+964','nationality' => 'Iraq' ],
		['code' => 'IE','dial_code' => '+353','nationality' => 'Ireland' ],
        ['code' => 'IT','dial_code' => '+39','nationality' => 'Italy' ],
        ['code' => 'CI','dial_code' => '+225','nationality' => 'Côte d’Ivoire' ],
        ['code' => 'JM','dial_code' => '+1876','nationality' => 'Jamaica' ],
        ['code' => 'JP','dial_code' => '+81','nationality' => 'Japan' ],
        ['code' => 'JO','dial_code' => '+962','nationality' => 'Jordan' ],
        ['code' => 'VG','dial_code' => '+1284','nationality' => 'Jost Van Dyke'],
        ['code' => 'KZ','dial_code' => '+7','nationality' => 'Kazakhstan' ],
        ['code' => 'KE','dial_code' => '+254','nationality' => 'Kenya' ],
        ['code' => 'KW','dial_code' => '+965','nationality' => 'Kuwait' ],
        ['code' => 'KG','dial_code' => '+996','nationality' => 'Kyrgyzstan' ],
        ['code' => 'LA','dial_code' => '+856','nationality' => 'Laos' ],
        ['code' => 'LV','dial_code' => '+371','nationality' => 'Latvia' ],
        ['code' => 'LB','dial_code' => '+961','nationality' => 'Lebanon' ],
        ['code' => 'LS','dial_code' => '+266','nationality' => 'Lesotho' ],
        ['code' => 'LT','dial_code' => '+370','nationality' => 'Lithuania' ],
        ['code' => 'LR','dial_code' => '+231','nationality' => 'Liberia' ],
        ['code' => 'LY','dial_code' => '+218','nationality' => 'Libya' ],
        ['code' => 'LI','dial_code' => '+423','nationality' => 'Liechtenstein' ],
        ['code' => 'LU','dial_code' => '+352','nationality' => 'Luxembourg' ],
        ['code' => 'MO','dial_code' => '+853','nationality' => 'Macau' ],
        ['code' => 'MK','dial_code' => '+389','nationality' => 'Macedonia' ],
        ['code' => 'MG','dial_code' => '+261','nationality' => 'Madagascar' ],
        ['code' => 'MW','dial_code' => '+265','nationality' => 'Malawi' ],
        ['code' => 'MY','dial_code' => '+60','nationality' => 'Malaysia' ],
        ['code' => 'MV','dial_code' => '+960','nationality' => 'Maldives' ],
        ['code' => 'ML','dial_code' => '+223','nationality' => 'Mali' ],
        ['code' => 'MT','dial_code' => '+356','nationality' => 'Malta'],
        ['code' => 'MQ','dial_code' => '+596','nationality' => 'Martinique' ],
        ['code' => 'MH','dial_code' => '+692','nationality' => 'Marshall Islands' ],
        ['code' => 'MR','dial_code' => '+222','nationality' => 'Mauritania' ],
        ['code' => 'MU','dial_code' => '+230','nationality' => 'Mauritius' ],
        ['code' => 'YT','dial_code' => '+262','nationality' => 'Mayotte' ],
        ['code' => 'MX','dial_code' => '+52','nationality' => 'Mexico' ],
        ['code' => 'MN','dial_code' => '+976','nationality' => 'Mongolia' ],
        ['code' => 'MS','dial_code' => '+1664','nationality' => 'Montserrat' ],
        ['code' => 'MD','dial_code' => '+373','nationality' => 'Moldova' ],
        ['code' => 'MC','dial_code' => '+377','nationality' => 'Monaco' ],
        ['code' => 'ME','dial_code' => '+382','nationality' => 'Montenegro' ],
        ['code' => 'MA','dial_code' => '+212','nationality' => 'Morocco' ],
        ['code' => 'MZ','dial_code' => '+258','nationality' => 'Mozambique' ],
        ['code' => 'FM','dial_code' => '+691','nationality' => 'Federated States of Micronesia' ],
        ['code' => 'NA','dial_code' => '+264','nationality' => 'Namibia' ],
        ['code' => 'NP','dial_code' => '+977','nationality' => 'Nepal' ],
        ['code' => 'NL','dial_code' => '+31','nationality' => 'Netherlands' ],
        ['code' => 'CW','dial_code' => '+599','nationality' => 'Netherlands Antilles' ],
        ['code' => 'NZ','dial_code' => '+64','nationality' => 'New Zealand' ],
        ['code' => 'NC','dial_code' => '+687','nationality' => 'New Caledonia' ],
        ['code' => 'PG','dial_code' => '+675','nationality' => 'New Guinea' ],
        ['code' => 'AU','dial_code' => '+61','nationality' => 'Norfolk Island' ],
        ['code' => 'VG','dial_code' => '+1284','nationality' => 'Norman Island'],
        ['code' => 'MP','dial_code' => '+1670','nationality' => 'Northern Mariana Islands' ],
        ['code' => 'NI','dial_code' => '+505','nationality' => 'Nicaragua' ],
        ['code' => 'NG','dial_code' => '+234','nationality' => 'Nigeria' ],
        ['code' => 'NU','dial_code' => '+683','nationality' => 'Niue' ],
        ['code' => 'NO','dial_code' => '+47','nationality' => 'Norway' ],
        ['code' => 'OM','dial_code' => '+968','nationality' => 'Oman' ],
        ['code' => 'PK','dial_code' => '+92','nationality' => 'Pakistan' ],
        ['code' => 'PW','dial_code' => '+680','nationality' => 'Palau'],
        ['code' => 'PA','dial_code' => '+507','nationality' => 'Panama' ],
        ['code' => 'PY','dial_code' => '+595','nationality' => 'Paraguay'],
        ['code' => 'PN','dial_code' => '+870','nationality' => 'Pitcairn Islands' ],
        ['code' => 'PE','dial_code' => '+51','nationality' => 'Peru' ],
        ['code' => 'PH','dial_code' => '+63','nationality' => 'Philippines' ],
        ['code' => 'PL','dial_code' => '+48','nationality' => 'Poland' ],
        ['code' => 'PT','dial_code' => '+351','nationality' => 'Portugal' ],
        ['code' => 'PR','dial_code' => '+1','nationality' => 'Puerto Rico' ],
        ['code' => 'RE','dial_code' => '+262','nationality' => 'Réunion' ],
        ['code' => 'RO','dial_code' => '+40','nationality' => 'Romania' ],
        ['code' => 'MP','dial_code' => '+1670','nationality' => 'Rota'],
        ['code' => 'RU','dial_code' => '+7','nationality' => 'Russia' ],
        ['code' => 'PM','dial_code' => '+508','nationality' => 'Saint Pierre and Miquelon' ],
        ['code' => 'SN','dial_code' => '+221','nationality' => 'Senegal'],
        ['code' => 'RS','dial_code' => '+381','nationality' => 'Serbia' ],
        ['code' => 'SC','dial_code' => '+248','nationality' => 'Seychelles' ],
        ['code' => 'SL','dial_code' => '+232','nationality' => 'Sierra Leone'],
        ['code' => 'MP','dial_code' => '+1670','nationality' => 'Saipan' ],
        ['code' => 'WS','dial_code' => '+685','nationality' => 'Samoa'],
        ['code' => 'IT','dial_code' => '+39','nationality' => 'San Marino' ],
        ['code' => 'GB','dial_code' => '+44','nationality' => 'Scotland' ],
        ['code' => 'SG','dial_code' => '+65','nationality' => 'Singapore'],
        ['code' => 'SK','dial_code' => '+421','nationality' => 'Slovakia' ],
        ['code' => 'SI','dial_code' => '+386','nationality' => 'Slovenia' ],
        ['code' => 'ZA','dial_code' => '+27','nationality' => 'South Africa' ],
        ['code' => 'SO','dial_code' => '+252','nationality' => 'Somalia' ],
        ['code' => 'ES','dial_code' => '+34','nationality' => 'Spain' ],
        ['code' => 'LK','dial_code' => '+94','nationality' => 'Sri Lanka' ],
        ['code' => 'BL','dial_code' => '+590','nationality' => 'Saint Barthélemy'],
        ['code' => 'BQ','dial_code' => '+599','nationality' => 'Sint Eustatius' ],
        ['code' => 'KN','dial_code' => '+1869','nationality' => 'Saint Kitts and Nevis'],
        ['code' => 'LC','dial_code' => '+1758','nationality' => 'Saint Lucia' ],
        ['code' => 'SX','dial_code' => '+590','nationality' => 'Saint Martin' ],
        ['code' => 'VC','dial_code' => '+1784','nationality' => 'Saint Vincent and the Grenadines' ],
        ['code' => 'SR','dial_code' => '+597','nationality' => 'Suriname' ],
        ['code' => 'SZ','dial_code' => '+268','nationality' => 'Swaziland' ],
        ['code' => 'SE','dial_code' => '+46','nationality' => 'Sweden' ],
        ['code' => 'CH','dial_code' => '+41','nationality' => 'Switzerland' ],
        ['code' => 'TW','dial_code' => '+886','nationality' => 'Taiwan' ],
        ['code' => 'TJ','dial_code' => '+992','nationality' => 'Tajikistan' ],
        ['code' => 'TZ','dial_code' => '+255','nationality' => 'Tanzania' ],
        ['code' => 'TH','dial_code' => '+66','nationality' => 'Thailand' ],
        ['code' => 'TT','dial_code' => '+1868','nationality' => 'Trinidad and Tobago' ],
        ['code' => 'TR','dial_code' => '+90','nationality' => 'Turkey' ],
        ['code' => 'TM','dial_code' => '+993','nationality' => 'Turkmenistan' ],
        ['code' => 'MP','dial_code' => '+1670','nationality' => 'Tunisia' ],
        ['code' => 'TG','dial_code' => '+228','nationality' => 'Togo' ],
        ['code' => 'TN','dial_code' => '+216','nationality' => 'Tunisia' ],
        ['code' => 'TV','dial_code' => '+688','nationality' => 'Tuvalu' ],
        ['code' => 'TC','dial_code' => '+1649','nationality' => 'Turks and Caicos Islands' ],
        ['code' => 'UG','dial_code' => '+256','nationality' => 'Uganda' ],
        ['code' => 'AE','dial_code' => '+971','nationality' => 'United Arab Emirates'],
        ['code' => 'GB','dial_code' => '+44','nationality' => 'United Kingdom' ],
        ['code' => 'US','dial_code' => '+1','nationality' => 'United States' ],
        ['code' => 'UY','dial_code' => '+598','nationality' => 'Uruguay' ],
        ['code' => 'UZ','dial_code' => '+998','nationality' => 'Uzbekistan' ],
        ['code' => 'VU','dial_code' => '+678','nationality' => 'Vanuatu' ],
        ['code' => 'IT','dial_code' => '+39','nationality' => 'Vatican City' ],
        ['code' => 'VE','dial_code' => '+58','nationality' => 'Venezuela' ],
        ['code' => 'VN','dial_code' => '+84','nationality' => 'Vietnam' ],
        ['code' => 'VG','dial_code' => '+1284','nationality' => 'British Virgin Islands' ],
        ['code' => 'VI','dial_code' => '+1340','nationality' => 'United States Virgin Islands' ],
        ['code' => 'YE','dial_code' => '+967','nationality' => 'Yemen' ],
        ['code' => 'ZM','dial_code' => '+260','nationality' => 'Zambia' ],
        ['code' => 'ZR','dial_code' => '+243','nationality' => 'Zaire' ],
        ['code' => 'ZW','dial_code' => '+263','nationality' => 'Zimbabwe' ],
        ['code' => 'SD','dial_code' => '+249','nationality' => 'Sudan' ],
        ['code' => 'SA','dial_code' => '+966','nationality' => 'Saudi Arabia' ],
        ['code' => 'CC','dial_code' => '+682','nationality' => 'Cook Islands' ],
        ['code' => 'CU','dial_code' => '+53','nationality' => 'Cuba'],
        ['code' => 'DJ','dial_code' => '+253','nationality' => 'Djibouti' ],
        ['code' => 'FK','dial_code' => '+500','nationality' => 'Falkland Islands (Malvinas)' ],
        ['code' => 'FO','dial_code' => '+298','nationality' => 'Faroe Islands'],
        ['code' => 'FX','dial_code' => '+33','nationality' => 'France, Metropolitan' ],
        ['code' => 'HM','dial_code' => '+672','nationality' => 'Heard and Mc Donald Islands' ],
		['code' => 'IR','dial_code' => '+98','nationality' => 'Iran (Islamic Republic of)' ],
		['code' => 'KI','dial_code' => '+686','nationality' => 'Kiribati' ],
		['code' => 'KP','dial_code' => '+850','nationality' => 'Korea, Democratic People\'s Republic of' ],
		['code' => 'KR','dial_code' => '+82','nationality' => 'Korea, Republic of' ],
		['code' => 'XK','dial_code' => '+383','nationality' => 'Kosovo' ],
		['code' => 'MM','dial_code' => '+95','nationality' => 'Myanmar' ],
		['code' => 'NR','dial_code' => '+674','nationality' => 'Nauru'],
		['code' => 'NE','dial_code' => '+227','nationality' => 'Niger' ],
		['code' => 'NF','dial_code' => '+672','nationality' => 'Norfork Island' ],
		['code' => 'QA','dial_code' => '+974','nationality' => 'Qatar' ],
		['code' => 'RW','dial_code' => '+250','nationality' => 'Rwanda' ],
		['code' => 'ST','dial_code' => '+239','nationality' => 'Sao Tome and Principe' ],
		['code' => 'SB','dial_code' => '+677','nationality' => 'Solomon Islands'],
		['code' => 'GS','dial_code' => '+500','nationality' => 'South Georgia South Sandwich Islands' ],
		['code' => 'SH','dial_code' => '+290','nationality' => 'St. Helena' ],
		['code' => 'SJ','dial_code' => '+47','nationality' => 'Svalbarn and Jan Mayen Islands' ],
		['code' => 'SY','dial_code' => '+963','nationality' => 'Syrian Arab Republic' ],
		['code' => 'TK','dial_code' => '+690','nationality' => 'Tokelau' ],
		['code' => 'TO','dial_code' => '+676','nationality' => 'Tonga' ],
		['code' => 'UA','dial_code' => '+380','nationality' => 'Ukraine'],
		['code' => 'UM','dial_code' => '+1','nationality' => 'United States minor outlying islands' ],
		['code' => 'VA','dial_code' => '+379','nationality' => 'Vatican City State' ],
		['code' => 'WF','dial_code' => '+681','nationality' => 'Wallis and Futuna Islands' ],
		['code' => 'EH','dial_code' => '+212','nationality' => 'Western Sahara' ],
		['code' => 'YU','dial_code' => '+38','nationality' => 'Yugoslavia' ],
		['code' => 'PS','dial_code' => '+970','nationality' => 'Palestine' ],
		['code' => 'IL','dial_code' => '+972','nationality' => 'Israel' ],
		['code' => 'AX','dial_code' => '+358','nationality' => 'Aaland Islands' ],
		['code' => 'GG','dial_code' => '+44','nationality' => 'Guernsey'],
		['code' => 'IM','dial_code' => '+44','nationality' => 'Isle of Man' ],
		['code' => 'JE','dial_code' => '+44','nationality' => 'Jersey' ],
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $countries = [
    			['country_code' => 'US','country_name' => 'United States'],
			  	['country_code' => 'CA','country_name' => 'Canada'],
			  	['country_code' => 'AF','country_name' => 'Afghanistan'],
			  	['country_code' => 'AL','country_name' => 'Albania'],
			  	['country_code' => 'DZ','country_name' => 'Algeria'],
			  	['country_code' => 'AS','country_name' => 'American Samoa'],
			  	['country_code' => 'AD','country_name' => 'Andorra'],
			  	['country_code' => 'AO','country_name' => 'Angola'],
			  	['country_code' => 'AI','country_name' => 'Anguilla'],
			 	['country_code' => 'AQ','country_name' => 'Antarctica'],
			 	['country_code' => 'AG','country_name' => 'Antigua and/or Barbuda'],
			 	['country_code' => 'AR','country_name' => 'Argentina'],
			 	['country_code' => 'AM','country_name' => 'Armenia'],
			 	['country_code' => 'AW','country_name' => 'Aruba'],
			 	['country_code' => 'AU','country_name' => 'Australia'],
			 	['country_code' => 'AT','country_name' => 'Austria'],
			 	['country_code' => 'AZ','country_name' => 'Azerbaijan'],
			 	['country_code' => 'BS','country_name' => 'Bahamas'],
			 	['country_code' => 'BH','country_name' => 'Bahrain'],
			 	['country_code' => 'BD','country_name' => 'Bangladesh'],
			 	['country_code' => 'BB','country_name' => 'Barbados'],
			 	['country_code' => 'BY','country_name' => 'Belarus'],
			 	['country_code' => 'BE','country_name' => 'Belgium'],
			 	['country_code' => 'BZ','country_name' => 'Belize'],
			 	['country_code' => 'BJ','country_name' => 'Benin'],
			 	['country_code' => 'BM','country_name' => 'Bermuda'],
			 	['country_code' => 'BT','country_name' => 'Bhutan'],
			 	['country_code' => 'BO','country_name' => 'Bolivia'],
			 	['country_code' => 'BA','country_name' => 'Bosnia and Herzegovina'],
			 	['country_code' => 'BW','country_name' => 'Botswana'],
			 	['country_code' => 'BV','country_name' => 'Bouvet Island'],
			 	['country_code' => 'BR','country_name' => 'Brazil'],
			 	['country_code' => 'IO','country_name' => 'British lndian Ocean Territory'],
			 	['country_code' => 'BN','country_name' => 'Brunei Darussalam'],
			 	['country_code' => 'BG','country_name' => 'Bulgaria'],
			 	['country_code' => 'BF','country_name' => 'Burkina Faso'],
			 	['country_code' => 'BI','country_name' => 'Burundi'],
			 	['country_code' => 'KH','country_name' => 'Cambodia'],
			 	['country_code' => 'CM','country_name' => 'Cameroon'],
			 	['country_code' => 'CV','country_name' => 'Cape Verde'],
			 	['country_code' => 'KY','country_name' => 'Cayman Islands'],
			 	['country_code' => 'CF','country_name' => 'Central African Republic'],
			 	['country_code' => 'TD','country_name' => 'Chad'],
			 	['country_code' => 'CL','country_name' => 'Chile'],
			 	['country_code' => 'CN','country_name' => 'China'],
			 	['country_code' => 'CX','country_name' => 'Christmas Island'],
			 	['country_code' => 'CC','country_name' => 'Cocos (Keeling) Islands'],
			 	['country_code' => 'CO','country_name' => 'Colombia'],
			 	['country_code' => 'KM','country_name' => 'Comoros'],
			 	['country_code' => 'CG','country_name' => 'Congo'],
			 	['country_code' => 'CK','country_name' => 'Cook Islands'],
			 	['country_code' => 'CR','country_name' => 'Costa Rica'],
			 	['country_code' => 'HR','country_name' => 'Croatia (Hrvatska)'],
			 	['country_code' => 'CU','country_name' => 'Cuba'],
			 	['country_code' => 'CY','country_name' => 'Cyprus'],
			 	['country_code' => 'CZ','country_name' => 'Czech Republic'],
			 	['country_code' => 'DK','country_name' => 'Denmark'],
			 	['country_code' => 'DJ','country_name' => 'Djibouti'],
			 	['country_code' => 'DM','country_name' => 'Dominica'],
			 	['country_code' => 'DO','country_name' => 'Dominican Republic'],
			 	['country_code' => 'TP','country_name' => 'East Timor'],
			 	['country_code' => 'EC','country_name' => 'Ecuador'],
			 	['country_code' => 'EG','country_name' => 'Egypt'],
			 	['country_code' => 'SV','country_name' => 'El Salvador'],
			 	['country_code' => 'GQ','country_name' => 'Equatorial Guinea'],
			 	['country_code' => 'ER','country_name' => 'Eritrea'],
			 	['country_code' => 'EE','country_name' => 'Estonia'],
			 	['country_code' => 'ET','country_name' => 'Ethiopia'],
			 	['country_code' => 'FK','country_name' => 'Falkland Islands (Malvinas)'],
			 	['country_code' => 'FO','country_name' => 'Faroe Islands'],
			 	['country_code' => 'FJ','country_name' => 'Fiji'],
			 	['country_code' => 'FI','country_name' => 'Finland'],
			 	['country_code' => 'FR','country_name' => 'France'],
			 	['country_code' => 'FX','country_name' => 'France, Metropolitan'],
			 	['country_code' => 'GF','country_name' => 'French Guiana'],
			 	['country_code' => 'PF','country_name' => 'French Polynesia'],
			 	['country_code' => 'TF','country_name' => 'French Southern Territories'],
			 	['country_code' => 'GA','country_name' => 'Gabon'],
			 	['country_code' => 'GM','country_name' => 'Gambia'],
			 	['country_code' => 'GE','country_name' => 'Georgia'],
			 	['country_code' => 'DE','country_name' => 'Germany'],
			 	['country_code' => 'GH','country_name' => 'Ghana'],
			 	['country_code' => 'GI','country_name' => 'Gibraltar'],
			 	['country_code' => 'GR','country_name' => 'Greece'],
			 	['country_code' => 'GL','country_name' => 'Greenland'],
			 	['country_code' => 'GD','country_name' => 'Grenada'],
			 	['country_code' => 'GP','country_name' => 'Guadeloupe'],
			 	['country_code' => 'GU','country_name' => 'Guam'],
			 	['country_code' => 'GT','country_name' => 'Guatemala'],
			 	['country_code' => 'GN','country_name' => 'Guinea'],
			 	['country_code' => 'GW','country_name' => 'Guinea-Bissau'],
			 	['country_code' => 'GY','country_name' => 'Guyana'],
			 	['country_code' => 'HT','country_name' => 'Haiti'],
			 	['country_code' => 'HM','country_name' => 'Heard and Mc Donald Islands'],
			 	['country_code' => 'HN','country_name' => 'Honduras'],
			 	['country_code' => 'HK','country_name' => 'Hong Kong'],
			 	['country_code' => 'HU','country_name' => 'Hungary'],
			 	['country_code' => 'IS','country_name' => 'Iceland'],
			 	['country_code' => 'IN','country_name' => 'India'],
			 	['country_code' => 'ID','country_name' => 'Indonesia'],
			 	['country_code' => 'IR','country_name' => 'Iran (Islamic Republic of)'],
			 	['country_code' => 'IQ','country_name' => 'Iraq'],
			 	['country_code' => 'IE','country_name' => 'Ireland'],
			 	['country_code' => 'IT','country_name' => 'Italy'],
			 	['country_code' => 'CI','country_name' => 'Ivory Coast'],
			 	['country_code' => 'JM','country_name' => 'Jamaica'],
			 	['country_code' => 'JP','country_name' => 'Japan'],
			 	['country_code' => 'JO','country_name' => 'Jordan'],
			 	['country_code' => 'KZ','country_name' => 'Kazakhstan'],
			 	['country_code' => 'KE','country_name' => 'Kenya'],
			 	['country_code' => 'KI','country_name' => 'Kiribati'],
			 	['country_code' => 'KP','country_name' => 'Korea, Democratic People\'s Republic of'],
			 	['country_code' => 'KR','country_name' => 'Korea, Republic of'],
			 	['country_code' => 'XK','country_name' => 'Kosovo'],
			 	['country_code' => 'KW','country_name' => 'Kuwait'],
			 	['country_code' => 'KG','country_name' => 'Kyrgyzstan'],
			 	['country_code' => 'LA','country_name' => 'Lao People\'s Democratic Republic'],
			 	['country_code' => 'LV','country_name' => 'Latvia'],
			 	['country_code' => 'LB','country_name' => 'Lebanon'],
			 	['country_code' => 'LS','country_name' => 'Lesotho'],
			 	['country_code' => 'LR','country_name' => 'Liberia'],
			 	['country_code' => 'LY','country_name' => 'Libyan Arab Jamahiriya'],
			 	['country_code' => 'LI','country_name' => 'Liechtenstein'],
			 	['country_code' => 'LT','country_name' => 'Lithuania'],
			 	['country_code' => 'LU','country_name' => 'Luxembourg'],
			 	['country_code' => 'MO','country_name' => 'Macau'],
			 	['country_code' => 'MK','country_name' => 'Macedonia'],
			 	['country_code' => 'MG','country_name' => 'Madagascar'],
			 	['country_code' => 'MW','country_name' => 'Malawi'],
			 	['country_code' => 'MY','country_name' => 'Malaysia'],
			 	['country_code' => 'MV','country_name' => 'Maldives'],
			 	['country_code' => 'ML','country_name' => 'Mali'],
			 	['country_code' => 'MT','country_name' => 'Malta'],
			 	['country_code' => 'MH','country_name' => 'Marshall Islands'],
			 	['country_code' => 'MQ','country_name' => 'Martinique'],
			 	['country_code' => 'MR','country_name' => 'Mauritania'],
			 	['country_code' => 'MU','country_name' => 'Mauritius'],
			 	['country_code' => 'TY','country_name' => 'Mayotte'],
			 	['country_code' => 'MX','country_name' => 'Mexico'],
			 	['country_code' => 'FM','country_name' => 'Micronesia, Federated States of'],
			 	['country_code' => 'MD','country_name' => 'Moldova, Republic of'],
			 	['country_code' => 'MC','country_name' => 'Monaco'],
			 	['country_code' => 'MN','country_name' => 'Mongolia'],
			 	['country_code' => 'ME','country_name' => 'Montenegro'],
			 	['country_code' => 'MS','country_name' => 'Montserrat'],
			 	['country_code' => 'MA','country_name' => 'Morocco'],
			 	['country_code' => 'MZ','country_name' => 'Mozambique'],
			 	['country_code' => 'MM','country_name' => 'Myanmar'],
			 	['country_code' => 'NA','country_name' => 'Namibia'],
			 	['country_code' => 'NR','country_name' => 'Nauru'],
			 	['country_code' => 'NP','country_name' => 'Nepal'],
			 	['country_code' => 'NL','country_name' => 'Netherlands'],
			 	['country_code' => 'AN','country_name' => 'Netherlands Antilles'],
			 	['country_code' => 'NC','country_name' => 'New Caledonia'],
			 	['country_code' => 'NZ','country_name' => 'New Zealand'],
			 	['country_code' => 'NI','country_name' => 'Nicaragua'],
			 	['country_code' => 'NE','country_name' => 'Niger'],
			 	['country_code' => 'NG','country_name' => 'Nigeria'],
			 	['country_code' => 'NU','country_name' => 'Niue'],
			 	['country_code' => 'NF','country_name' => 'Norfork Island'],
			 	['country_code' => 'MP','country_name' => 'Northern Mariana Islands'],
			 	['country_code' => 'NO','country_name' => 'Norway'],
			 	['country_code' => 'OM','country_name' => 'Oman'],
			 	['country_code' => 'PK','country_name' => 'Pakistan'],
			 	['country_code' => 'PW','country_name' => 'Palau'],
			 	['country_code' => 'PA','country_name' => 'Panama'],
			 	['country_code' => 'PG','country_name' => 'Papua New Guinea'],
			 	['country_code' => 'PY','country_name' => 'Paraguay'],
			 	['country_code' => 'PE','country_name' => 'Peru'],
			 	['country_code' => 'PH','country_name' => 'Philippines'],
			 	['country_code' => 'PN','country_name' => 'Pitcairn'],
			 	['country_code' => 'PL','country_name' => 'Poland'],
			 	['country_code' => 'PT','country_name' => 'Portugal'],
			 	['country_code' => 'PR','country_name' => 'Puerto Rico'],
			 	['country_code' => 'QA','country_name' => 'Qatar'],
			 	['country_code' => 'RE','country_name' => 'Reunion'],
			 	['country_code' => 'RO','country_name' => 'Romania'],
			 	['country_code' => 'RU','country_name' => 'Russian Federation'],
			 	['country_code' => 'RW','country_name' => 'Rwanda'],
			 	['country_code' => 'KN','country_name' => 'Saint Kitts and Nevis'],
			 	['country_code' => 'LC','country_name' => 'Saint Lucia'],
			 	['country_code' => 'VC','country_name' => 'Saint Vincent and the Grenadines'],
			 	['country_code' => 'WS','country_name' => 'Samoa'],
			 	['country_code' => 'SM','country_name' => 'San Marino'],
			 	['country_code' => 'ST','country_name' => 'Sao Tome and Principe'],
			 	['country_code' => 'SA','country_name' => 'Saudi Arabia'],
			 	['country_code' => 'SN','country_name' => 'Senegal'],
			 	['country_code' => 'RS','country_name' => 'Serbia'],
			 	['country_code' => 'SC','country_name' => 'Seychelles'],
			 	['country_code' => 'SL','country_name' => 'Sierra Leone'],
			 	['country_code' => 'SG','country_name' => 'Singapore'],
			 	['country_code' => 'SK','country_name' => 'Slovakia'],
			 	['country_code' => 'SI','country_name' => 'Slovenia'],
			 	['country_code' => 'SB','country_name' => 'Solomon Islands'],
			 	['country_code' => 'SO','country_name' => 'Somalia'],
			 	['country_code' => 'ZA','country_name' => 'South Africa'],
			 	['country_code' => 'GS','country_name' => 'South Georgia South Sandwich Islands'],
			 	['country_code' => 'ES','country_name' => 'Spain'],
			 	['country_code' => 'LK','country_name' => 'Sri Lanka'],
			 	['country_code' => 'SH','country_name' => 'St. Helena'],
			 	['country_code' => 'PM','country_name' => 'St. Pierre and Miquelon'],
			 	['country_code' => 'SD','country_name' => 'Sudan'],
			 	['country_code' => 'SR','country_name' => 'Suriname'],
			 	['country_code' => 'SJ','country_name' => 'Svalbarn and Jan Mayen Islands'],
			 	['country_code' => 'SZ','country_name' => 'Swaziland'],
			 	['country_code' => 'SE','country_name' => 'Sweden'],
			 	['country_code' => 'CH','country_name' => 'Switzerland'],
			 	['country_code' => 'SY','country_name' => 'Syrian Arab Republic'],
			 	['country_code' => 'TW','country_name' => 'Taiwan'],
			 	['country_code' => 'TJ','country_name' => 'Tajikistan'],
			 	['country_code' => 'TZ','country_name' => 'Tanzania, United Republic of'],
			 	['country_code' => 'TH','country_name' => 'Thailand'],
			 	['country_code' => 'TG','country_name' => 'Togo'],
			 	['country_code' => 'TK','country_name' => 'Tokelau'],
			 	['country_code' => 'TO','country_name' => 'Tonga'],
			 	['country_code' => 'TT','country_name' => 'Trinidad and Tobago'],
			 	['country_code' => 'TN','country_name' => 'Tunisia'],
			 	['country_code' => 'TR','country_name' => 'Turkey'],
			 	['country_code' => 'TM','country_name' => 'Turkmenistan'],
			 	['country_code' => 'TC','country_name' => 'Turks and Caicos Islands'],
			 	['country_code' => 'TV','country_name' => 'Tuvalu'],
			 	['country_code' => 'UG','country_name' => 'Uganda'],
			 	['country_code' => 'UA','country_name' => 'Ukraine'],
			 	['country_code' => 'AE','country_name' => 'United Arab Emirates'],
			 	['country_code' => 'GB','country_name' => 'United Kingdom'],
			 	['country_code' => 'UM','country_name' => 'United States minor outlying islands'],
			 	['country_code' => 'UY','country_name' => 'Uruguay'],
			 	['country_code' => 'UZ','country_name' => 'Uzbekistan'],
			 	['country_code' => 'VU','country_name' => 'Vanuatu'],
			 	['country_code' => 'VA','country_name' => 'Vatican City State'],
			 	['country_code' => 'VE','country_name' => 'Venezuela'],
			 	['country_code' => 'VN','country_name' => 'Vietnam'],
			 	['country_code' => 'VG','country_name' => 'Virgin Islands (British)'],
			 	['country_code' => 'VI','country_name' => 'Virgin Islands (U.S.)'],
			 	['country_code' => 'WF','country_name' => 'Wallis and Futuna Islands'],
			 	['country_code' => 'EH','country_name' => 'Western Sahara'],
			 	['country_code' => 'YE','country_name' => 'Yemen'],
			 	['country_code' => 'YU','country_name' => 'Yugoslavia'],
			 	['country_code' => 'ZR','country_name' => 'Zaire'],
			 	['country_code' => 'ZM','country_name' => 'Zambia'],
			 	['country_code' => 'ZW','country_name' => 'Zimbabwe'],
			 	['country_code' => 'PS','country_name' => 'Palestine']
    ];
   
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  
        foreach ($this->countries as $country) {
			if (!Country::where('country_code', $country['country_code'])->orWhere('country_name', $country['country_name'])->first()) {
				Country::insert($country);
			}
        }

		$countries = Country::all();
		foreach ($countries as $country) {
			if (in_array($country->country_code, collect($this->countries_with_dial_code)->pluck('code')->toArray())) {
				// Update Dial Code
				$data = collect($this->countries_with_dial_code)->where('code', $country->country_code)->where('nationality', $country->country_name)->first();
				if ($data) {
					$country->dial_code = $data['dial_code'];
					$country->save();
				} else {
					$data = collect($this->countries_with_dial_code)->where('code', $country->country_code)->first();
					$country->country_name = $data['nationality'];
					$country->dial_code = $data['dial_code'];
					$country->save();
				}
			} else {
				if (in_array($country->country_name, collect($this->countries_with_dial_code)->pluck('nationality')->toArray())) {
					// Update Dial Code & Country Code
					$data = collect($this->countries_with_dial_code)->where('nationality', $country->country_name)->first();
					if ($data) {
						$country->country_code = $data['code'];
						$country->dial_code = $data['dial_code'];
						$country->save();
					} else {
						dd($country->country_code, 'code change error');
					}
				} else {
					// Data Not Found
					dd($country->country_code, 'not found in array error');
				}
			}
			if (!(file_exists(public_path('img/flags/all/'.strtoupper($country->country_code).'.png')) || file_exists(public_path('img/flags/all/'.strtolower($country->country_code).'.png')))) {
				dd($country->country_code, 'image error');
			}
		}
    }
}
