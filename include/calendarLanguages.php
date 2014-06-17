<?php 
function wpbsMonth($month,$language){
    $translatedMonths = array(
		'ca' => array( /*Catalan*/
            'January' => 'Gener',
            'February' => 'Febrer',
            'March' => 'Març',
            'April' => 'Abril',
            'May' => 'Maig',
            'June' => 'Juny',
            'July' => 'Juliol',
            'August' => 'Agost',
            'September' => 'Setembre',
            'October' => 'Octubre',
            'November' => 'Novembre',
            'December' => 'Desembre'
        ),
		'hr' => array( /*Croatian*/
            'January' => 'Siječanj',
            'February' => 'Veljača',
            'March' => 'Ožujak',
            'April' => 'Travanj',
            'May' => 'Svibanj',
            'June' => 'Lipanj',
            'July' => 'Srpanj',
            'August' => 'Kolovoz',
            'September' => 'Rujan',
            'October' => 'Listopad',
            'November' => 'Studeni',
            'December' => 'Prosinac'
        ),
		'cz' => array( /*Czech*/
            'January' => 'Leden',
            'February' => 'Únor',
            'March' => 'Březen',
            'April' => 'Duben',
            'May' => 'Květen',
            'June' => 'Červen',
            'July' => 'Červenec',
            'August' => 'Srpen',
            'September' => 'Září',
            'October' => 'Říjen',
            'November' => 'Listopad',
            'December' => 'Prosinec'
        ),
		'da' => array( /*Danish*/
            'January' => 'Januar',
            'February' => 'Februar',
            'March' => 'Marts',
            'April' => 'April',
            'May' => 'Maj',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'August',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'December'
        ),		
		'nl' => array( /*Dutch*/
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maart',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Augustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'December'
        ),		
        'en' => array( /*English*/
            'January' => 'January',
            'February' => 'February',
            'March' => 'March',
            'April' => 'April',
            'May' => 'May',
            'June' => 'June',
            'July' => 'July',
            'August' => 'August',
            'September' => 'September',
            'October' => 'October',
            'November' => 'November',
            'December' => 'December'
        ),		
		'et' => array( /*Estonian*/
            'January' => 'Jaanuar',
            'February' => 'Veebruar',
            'March' => 'Märts',
            'April' => 'Aprill',
            'May' => 'Mai',
            'June' => 'Juuni',
            'July' => 'Juuli',
            'August' => 'August',
            'September' => 'September',
            'October' => 'Oktoober',
            'November' => 'November',
            'December' => 'Detsember'
        ),		
		'fi' => array( /*Finnish*/
            'January' => 'Tammikuu',
            'February' => 'Helmikuu',
            'March' => 'Maaliskuu',
            'April' => 'Huhtikuu',
            'May' => 'Toukokuu',
            'June' => 'Kesäkuu',
            'July' => 'Heinäkuu',
            'August' => 'Elokuu',
            'September' => 'Syyskuu',
            'October' => 'Lokakuu',
            'November' => 'Marraskuu',
            'December' => 'Joulukuu'
        ),		
		'fr' => array( /*French*/
            'January' => 'Janvier',
            'February' => 'Février',
            'March' => 'Mars',
            'April' => 'Avril',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juillet',
            'August' => 'Août',
            'September' => 'Septembre',
            'October' => 'Octobre',
            'November' => 'Novembre',
            'December' => 'Décembre'
        ),		
		'de' => array( /*German*/
            'January' => 'Januar',
            'February' => 'Februar',
            'March' => 'März',
            'April' => 'April',
            'May' => 'Mai',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'August',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Dezember'
        ),		
		'el' => array( /*Greek*/
            'January' => 'Ιανουάριος',
            'February' => 'Φεβρουάριος',
            'March' => 'Μάρτιος',
            'April' => 'Απρίλιος',
            'May' => 'Μάιος',
            'June' => 'Ιούνιος',
            'July' => 'Ιούλιος',
            'August' => 'Αύγουστος',
            'September' => 'Σεπτέμβριος',
            'October' => 'Οκτώβριος',
            'November' => 'Νοέμβριος',
            'December' => 'Δεκέμβριος'
        ),		
        'hu' => array( /*Hungarian*/
            'January' => 'Január',
            'February' => 'Február',
            'March' => 'Március',
            'April' => 'Április',
            'May' => 'Május',
            'June' => 'Június',
            'July' => 'Július',
            'August' => 'Augusztus',
            'September' => 'Szeptember',
            'October' => 'Október',
            'November' => 'November',
            'December' => 'December'
        ),		
		'it' => array( /*Italian*/
            'January' => 'Gennaio',
            'February' => 'Febbraio',
            'March' => 'Marzo',
            'April' => 'Aprile',
            'May' => 'Maggio',
            'June' => 'Giugno',
            'July' => 'Luglio',
            'August' => 'Agosto',
            'September' => 'Settembre',
            'October' => 'Ottobre',
            'November' => 'Novembre',
            'December' => 'Dicembre'
        ),
		'no' => array( /*Norwegian*/
            'January' => 'Januar',
            'February' => 'Februar',
            'March' => 'Mars',
            'April' => 'April',
            'May' => 'Mai',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'August',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ),	
		'pl' => array( /*Polish*/
            'January' => 'Styczen',
            'February' => 'Luty',
            'March' => 'Marzec',
            'April' => 'Kwiecien',
            'May' => 'Maj',
            'June' => 'Czerwiec',
            'July' => 'Lipiec',
            'August' => 'Sierpien',
            'September' => 'Wrzesien',
            'October' => 'Pazdziemik',
            'November' => 'Listopad',
            'December' => 'Grudzien'
        ),	
		'pt' => array( /*Portugese*/
            'January' => 'Janeiro',
            'February' => 'Fevereiro',
            'March' => 'Março',
            'April' => 'Abril',
            'May' => 'Maio',
            'June' => 'Junho',
            'July' => 'Julho',
            'August' => 'Agosto',
            'September' => 'Septembro',
            'October' => 'Outubro',
            'November' => 'Novembro',
            'December' => 'Dezembro'
        ),		
        'ro' => array( /*Romanian*/
            'January' => 'Ianuarie',
            'February' => 'Februarie',
            'March' => 'Martie',
            'April' => 'Aprilie',
            'May' => 'Mai',
            'June' => 'Iunie',
            'July' => 'Iulie',
            'August' => 'August',
            'September' => 'Septembrie',
            'October' => 'Octombrie',
            'November' => 'Noiembrie',
            'December' => 'Decembrie'
        ),  
		'ru' => array( /*Russian*/
            'January' => 'Январь',
            'February' => 'Февраль',
            'March' => 'Март',
            'April' => 'Апрель',
            'May' => 'Май',
            'June' => 'Июнь',
            'July' => 'Июль',
            'August' => 'Август',
            'September' => 'Сентябрь',
            'October' => 'Октябрь',
            'November' => 'Ноябрь',
            'December' => 'Декабрь'
        ),		
		'sk' => array( /*Slovak*/
            'January' => 'Január',
            'February' => 'Február',
            'March' => 'Marec',
            'April' => 'Apríl',
            'May' => 'Máj',
            'June' => 'Jún',
            'July' => 'Júl',
            'August' => 'August',
            'September' => 'September',
            'October' => 'Október',
            'November' => 'November',
            'December' => 'December'
        ),				
		'sl' => array( /*Slovenian*/
            'January' => 'Január',
            'February' => 'Február',
            'March' => 'Marec',
            'April' => 'Apríl',
            'May' => 'Máj',
            'June' => 'Jún',
            'July' => 'Júl',
            'August' => 'August',
            'September' => 'September',
            'October' => 'Október',
            'November' => 'November',
            'December' => 'December'
        ),
		'es' => array( /*Spanish*/
            'January' => 'Enero',
            'February' => 'Febrero',
            'March' => 'Marzo',
            'April' => 'Abril',
            'May' => 'Mayo',
            'June' => 'Junio',
            'July' => 'Julio',
            'August' => 'Agosto',
            'September' => 'Septiembre',
            'October' => 'Octubre',
            'November' => 'Noviembre',
            'December' => 'Diciembre'
        ),		
		'sv' => array( /*Swedish*/
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Mars',
            'April' => 'April',
            'May' => 'Maj',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Augusti',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'December'
        ),						
		'tr' => array( /*Turkish*/
            'January' => 'Ocak',
            'February' => 'Şubat',
            'March' => 'Mart',
            'April' => 'Nisan',
            'May' => 'Mayıs',
            'June' => 'Haziran',
            'July' => 'Temmuz',
            'August' => 'Ağustos',
            'September' => 'Eylül',
            'October' => 'Ekim',
            'November' => 'Kasım',
            'December' => 'Aralık'
        ),		
		'uk' => array( /*Ukrainian*/
            'January' => 'Січень',
            'February' => 'Лютий',
            'March' => 'Березень',
            'April' => 'Квітень',
            'May' => 'Травень',
            'June' => 'Червень',
            'July' => 'Липень',
            'August' => 'Серпень',
            'September' => 'Вересень',
            'October' => 'Жовтень',
            'November' => 'Листопад',
            'December' => 'Грудень'
        )      

    );
    return $translatedMonths[$language][$month];
}

function wpbsShortMonth($month,$language){
    $translatedMonths = array(
		'ca' => array( /*Catalan*/
            'January' => 'Gen',
            'February' => 'Feb',
            'March' => 'Mar',
            'April' => 'Abr',
            'May' => 'Mai',
            'June' => 'Jun',
            'July' => 'Jul',
            'August' => 'Ago',
            'September' => 'Set',
            'October' => 'Octe',
            'November' => 'Nov',
            'December' => 'Des'
        ),
		'hr' => array( /*Croatian*/
            'January' => 'Sij',
            'February' => 'Velj',
            'March' => 'Ožu',
            'April' => 'Tra',
            'May' => 'Svi',
            'June' => 'Lip',
            'July' => 'Srp',
            'August' => 'Kol',
            'September' => 'Ruj',
            'October' => 'Lis',
            'November' => 'Stu',
            'December' => 'Pro'
        ),
		'cz' => array( /*Czech*/
            'January' => 'Led',
            'February' => 'Úno',
            'March' => 'Bře',
            'April' => 'Dub',
            'May' => 'Kvě',
            'June' => 'Čer',
            'July' => 'Čec',
            'August' => 'Srp',
            'September' => 'Zář',
            'October' => 'Říj',
            'November' => 'Lis',
            'December' => 'Pro'
        ),
		'da' => array( /*Danish*/
            'January' => 'Jan',
            'February' => 'Feb',
            'March' => 'Mar',
            'April' => 'Apr',
            'May' => 'Maj',
            'June' => 'Jun',
            'July' => 'Jul',
            'August' => 'Aug',
            'September' => 'Sep',
            'October' => 'Okt',
            'November' => 'Nov',
            'December' => 'Dec'
        ),		
		'nl' => array( /*Dutch*/
            'January' => 'Jan',
            'February' => 'Feb',
            'March' => 'Mrt',
            'April' => 'Apr',
            'May' => 'Mei',
            'June' => 'Jun',
            'July' => 'Jul',
            'August' => 'Aug',
            'September' => 'Sep',
            'October' => 'Okt',
            'November' => 'Nov',
            'December' => 'Dec'
        ),		
        'en' => array( /*English*/
            'January' => 'Jan',
            'February' => 'Feb',
            'March' => 'Mar',
            'April' => 'Apr',
            'May' => 'May',
            'June' => 'June',
            'July' => 'July',
            'August' => 'Aug',
            'September' => 'Sept',
            'October' => 'Oct',
            'November' => 'Nov',
            'December' => 'Dec'
        ),		
		'et' => array( /*Estonian*/
            'January' => 'Jaan',
            'February' => 'Veebr',
            'March' => 'Märts',
            'April' => 'Apr',
            'May' => 'Mai',
            'June' => 'Juuni',
            'July' => 'Juuli',
            'August' => 'Aug',
            'September' => 'Sept',
            'October' => 'Okt',
            'November' => 'Nov',
            'December' => 'Dets'
        ),		
		'fi' => array( /*Finnish*/
            'January' => 'Tam',
            'February' => 'Hel',
            'March' => 'Maa',
            'April' => 'Huh',
            'May' => 'Tou',
            'June' => 'Kes',
            'July' => 'Hei',
            'August' => 'Elo',
            'September' => 'Syy',
            'October' => 'Lok',
            'November' => 'Mar',
            'December' => 'Jou'
        ),		
		'fr' => array( /*French*/
            'January' => 'Jan',
            'February' => 'Fév',
            'March' => 'Mar',
            'April' => 'Avr',
            'May' => 'Mai',
            'June' => 'Juin',
            'July' => 'Juil',
            'August' => 'Août',
            'September' => 'Sept',
            'October' => 'Oct',
            'November' => 'Nov',
            'December' => 'Déc'
        ),		
		'de' => array( /*German*/
            'January' => 'Jan',
            'February' => 'Feb',
            'March' => 'März',
            'April' => 'Apr',
            'May' => 'Mai',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Aug',
            'September' => 'Sept',
            'October' => 'Okt',
            'November' => 'Nov',
            'December' => 'Dez'
        ),		
		'el' => array( /*Greek*/
            'January' => 'Ιαν',
            'February' => 'Φεβ',
            'March' => 'Μαρ',
            'April' => 'Απρ',
            'May' => 'Μάι',
            'June' => 'Ιουν',
            'July' => 'Ιουλ',
            'August' => 'Αυγ',
            'September' => 'Σεπ',
            'October' => 'Οκτ',
            'November' => 'Νοε',
            'December' => 'Δεκ'
        ),		
        'hu' => array( /*Hungarian*/
            'January' => 'Jan',
            'February' => 'Feb',
            'March' => 'Márc',
            'April' => 'Ápr',
            'May' => 'Máj',
            'June' => 'Jún',
            'July' => 'Júl',
            'August' => 'Aug',
            'September' => 'Szept',
            'October' => 'Okt',
            'November' => 'Nov',
            'December' => 'Dec'
        ),		
		'it' => array( /*Italian*/
            'January' => 'Genn',
            'February' => 'Febbr',
            'March' => 'Marz',
            'April' => 'Apr',
            'May' => 'Magg',
            'June' => 'Giugno',
            'July' => 'Luglio',
            'August' => 'Ag',
            'September' => 'Sett',
            'October' => 'Ott',
            'November' => 'Nov',
            'December' => 'Dic'
        ),
		'no' => array( /*Norwegian*/
            'January' => 'Jan',
            'February' => 'Febr',
            'March' => 'Mars',
            'April' => 'April',
            'May' => 'Mai',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Aug',
            'September' => 'Sept',
            'October' => 'Okt',
            'November' => 'Nov',
            'December' => 'Des'
        ),	
		'pl' => array( /*Polish*/
            'January' => 'Stycz',
            'February' => 'Luty',
            'March' => 'Mar',
            'April' => 'Kwiec',
            'May' => 'Maj',
            'June' => 'Czerw',
            'July' => 'Lip',
            'August' => 'Sierp',
            'September' => 'Wrzes',
            'October' => 'Pazdz',
            'November' => 'Listop',
            'December' => 'Grudz'
        ),	
		'pt' => array( /*Portugese*/
            'January' => 'Jan',
            'February' => 'Fev',
            'March' => 'Março',
            'April' => 'Abril',
            'May' => 'Maio',
            'June' => 'Junho',
            'July' => 'Julho',
            'August' => 'Agosto',
            'September' => 'Set',
            'October' => 'Out',
            'November' => 'Nov',
            'December' => 'Dez'
        ),		
        'ro' => array( /*Romanian*/
            'January' => 'Ian',
            'February' => 'Feb',
            'March' => 'Mar',
            'April' => 'Apr',
            'May' => 'Mai',
            'June' => 'Iun',
            'July' => 'Iul',
            'August' => 'Aug',
            'September' => 'Sept',
            'October' => 'Oct',
            'November' => 'Nov',
            'December' => 'Dec'
        ),  
		'ru' => array( /*Russian*/
            'January' => 'Янв',
            'February' => 'Фев',
            'March' => 'Мар',
            'April' => 'Апр',
            'May' => 'Май',
            'June' => 'Июн',
            'July' => 'Июл',
            'August' => 'Авг',
            'September' => 'Сен',
            'October' => 'Окт',
            'November' => 'Ноя',
            'December' => 'Дек'
        ),		
		'sk' => array( /*Slovak*/
            'January' => 'Jan',
            'February' => 'Feb',
            'March' => 'Mar',
            'April' => 'Apr',
            'May' => 'Máj',
            'June' => 'Jún',
            'July' => 'Júl',
            'August' => 'Aug',
            'September' => 'Sept',
            'October' => 'Okt',
            'November' => 'Nov',
            'December' => 'Dec'
        ),				
		'sl' => array( /*Slovenian*/
            'January' => 'Jan',
            'February' => 'Feb',
            'March' => 'Mar',
            'April' => 'Apr',
            'May' => 'Máj',
            'June' => 'Jún',
            'July' => 'Júl',
            'August' => 'Avg',
            'September' => 'Sept',
            'October' => 'Okt',
            'November' => 'Nov',
            'December' => 'Dec'
        ),
		'es' => array( /*Spanish*/
            'January' => 'Enero',
            'February' => 'Feb',
            'March' => 'Marzo',
            'April' => 'Abr',
            'May' => 'Mayo',
            'June' => 'Jun',
            'July' => 'Jul',
            'August' => 'Agosto',
            'September' => 'Sept',
            'October' => 'Oct',
            'November' => 'Nov',
            'December' => 'Dic'
        ),		
		'sv' => array( /*Swedish*/
            'January' => 'Jan',
            'February' => 'Febr',
            'March' => 'Mars',
            'April' => 'April',
            'May' => 'Maj',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Aug',
            'September' => 'Sept',
            'October' => 'Okt',
            'November' => 'Nov',
            'December' => 'Dec'
        ),						
		'tr' => array( /*Turkish*/
            'January' => 'Ocak',
            'February' => 'Şubat',
            'March' => 'Mart',
            'April' => 'Nisan',
            'May' => 'Mayıs',
            'June' => 'Haziran',
            'July' => 'Temmuz',
            'August' => 'Ağustos',
            'September' => 'Eylül',
            'October' => 'Ekim',
            'November' => 'Kasım',
            'December' => 'Aralık'
        ),		
		'uk' => array( /*Ukrainian*/
            'January' => 'Січ',
            'February' => 'Лют',
            'March' => 'Бер',
            'April' => 'Кві',
            'May' => 'Тра',
            'June' => 'Чер',
            'July' => 'Лип',
            'August' => 'Сер',
            'September' => 'Вер',
            'October' => 'Жов',
            'November' => 'Лис',
            'December' => 'Гру'
        )      

    );
    return $translatedMonths[$language][$month];
}


function wpbsDoW($language){
    $translatedMonths = array(
        // days have to be repeated, it's a simpler way to make start day work
        // starts with Sunday, Monday...
		// langauges are in same order as they appear in /manage/languages/
		
		'ca' => array('D','D','D','D','D','D','D','D','D','D','D','D','D'), /*Catalan*/
		'hr' => array('N','P','U','S','Č','P','S','N','P','U','S','Č','P'), /*Croatian*/
		'cz' => array('N','P','Ú','S','Č','P','S','N','P','Ú','S','Č','P'), /*Czech*/
		'da' => array('S','M','T','O','T','F','L','S','M','T','O','T','F'), /*Danish*/
		'nl' => array('Z','M','D','W','D','V','Z','Z','M','D','W','D','V'), /*Dutch*/
        'en' => array('S','M','T','W','T','F','S','S','M','T','W','T','F'), /*English*/
		'et' => array('P','E','T','K','N','R','L','P','E','T','K','N','R'), /*Estonian*/
		'fi' => array('S','M','T','K','T','P','L','S','M','T','K','T','P'),	/*Finnish*/
		'fr' => array('D','L','M','M','J','V','S','D','L','M','M','J','V'), /*French*/
		'de' => array('S','M','D','M','D','F','S','S','M','D','M','D','F'), /*German*/
		'el' => array('Κ','Δ','Τ','Τ','Π','Π','Σ','Κ','Δ','Τ','Τ','Π','Π'), /*Greek*/
        'hu' => array('V','H','K','S','C','P','S','V','H','K','S','C','P'), /*Hungarian*/
		'it' => array('D','L','M','M','G','V','S','D','L','M','M','G','V'), /*Italian*/
		'no' => array('S','M','T','O','T','F','L','S','M','T','O','T','F'), /*Norwegian*/
		'pl' => array('N','P','W','S','C','P','S','N','P','W','S','C','P'), /*Polish*/
		'pt' => array('D','S','T','Q','Q','S','S','D','S','T','Q','Q','S'), /*Portugese*/
        'ro' => array('D','L','M','M','J','V','S','D','L','M','M','J','V'), /*Romanian*/
		'ru' => array('В','П','В','С','Ч','П','С','В','П','В','С','Ч','П'), /*Russian*/
		'sk' => array('N','P','U','S','Š','P','S','N','P','U','S','Š','P'), /*Slovak*/
		'sl' => array('N','P','U','S','Š','P','S','N','P','U','S','Š','P'), /*Slovenian*/
		'es' => array('D','L','M','M','J','V','S','D','L','M','M','J','V'), /*Spanish*/
		'sv' => array('S','M','T','O','T','F','L','S','M','T','O','T','F'), /*Swedish*/
		'tr' => array('P','P','S','Ç','P','C','C','P','P','S','Ç','P','C'), /*Turkish*/
		'uk' => array('Н','П','В','С','Ч','П','С','Н','П','В','С','Ч','П') /*Ukrainian*/
    );
    return $translatedMonths[$language];
}

?>