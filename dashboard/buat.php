<?php
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

// Array email => password
$passwords = [
    'muliaabdullahidn@kamponginggrispare.com' => 'mulia8652',
    'mabdulfathiridn@kamponginggrispare.com' => 'muhammad2908',
    'altopsidn@kamponginggrispare.com' => 'althaf9575',
    'izzuhuzainazzam@kamponginggrispare.com' => 'azzam2313',
    'tsabitmumtazidn@kamponginggrispare.com' => 'tsabit3401',
    'purnamaaghnafath@kamponginggrispare.com' => 'ahza2971',
    'yugifarsyaidn@kamponginggrispare.com' => 'yugi8982',
    'mhaidarfr.idn@kamponginggrispare.com' => 'muhammad6775',
    'qoryrezaidn@kamponginggrispare.com' => 'abqory7083',
    'mandisamuhammadrayyan505@kamponginggrispare.com' => 'muhammad2006',
    'alvino051109@kamponginggrispare.com' => 'alvino6294',
    'roisulhikamidn@kamponginggrispare.com' => 'roisul3158',
    'mreyhanidn@kamponginggrispare.com' => 'muhammad9047',
    'gilangkhalf.a@kamponginggrispare.com' => 'gilang7436',
    'ibnulivo1903@kamponginggrispare.com' => 'antar5829',
    'ibnuformal@kamponginggrispare.com' => 'ibnu1620',
    'zhofranahmad@kamponginggrispare.com' => 'ahmad4913',
    'khalilpuribawa80@kamponginggrispare.com' => 'khalil7805',
    'anekeandra@kamponginggrispare.com' => 'keandra2497',
    'muhammadzahirassajjad@kamponginggrispare.com' => 'muhammad3186',
    'morenoibrahim606@kamponginggrispare.com' => 'maulana8574',
    'valdimirirawan@kamponginggrispare.com' => 'valdimir6368',
    'athifmuz@kamponginggrispare.com' => 'mathif1951',
    'alvinzfp@kamponginggrispare.com' => 'alvin7240',
    'syafrilkeydo2009@kamponginggrispare.com' => 'muhammad5632',
    'ahmadrf921@kamponginggrispare.com' => 'ahmad9024',
    'fadliprasetya08@kamponginggrispare.com' => 'muhammad4417',
    'auliaazmialfarisy@kamponginggrispare.com' => 'aulia8906',
    'fahryan.rahim@kamponginggrispare.com' => 'rahim3599',
    'wizlylutfi05@kamponginggrispare.com' => 'lutfi1782',
    'yogayoshio6190@kamponginggrispare.com' => 'yoga5173',
    'mannmarpaung@kamponginggrispare.com' => 'zaid9466',
    'fawwazmiftahunnaim@kamponginggrispare.com' => 'fawwaz7358',
    'saidihanif3@kamponginggrispare.com' => 'hanif3941',
    'idnhanifibrahim@kamponginggrispare.com' => 'hanif6135',
    '2009.andromeda@kamponginggrispare.com' => 'muhammad8027',
    'battleship2952@kamponginggrispare.com' => 'muhammad9719',
    'tamaginting52@kamponginggrispare.com' => 'wahyu4310',
    'celvanraffaaldiano26@kamponginggrispare.com' => 'celvan2503',
    'silmioldodu@kamponginggrispare.com' => 'muhammad8796',
    'ghaniyyuathallah@kamponginggrispare.com' => 'athallah5688',
    'mirzaabdulhafizh@kamponginggrispare.com' => 'mirza1274',
    'barrazakiy@kamponginggrispare.com' => 'emir9461',
    'deanmuhammadrazan@kamponginggrispare.com' => 'dean6853',
    'mdj.faheem6@kamponginggrispare.com' => 'mohammed2145',
    'afkar013541@kamponginggrispare.com' => 'higen7630',
    'akbaraldhiyaa@kamponginggrispare.com' => 'muhammad9324',
    'rezkyazharsuryaputra@kamponginggrispare.com' => 'rezky5017',
    'fatihalakram55@kamponginggrispare.com' => 'fatih8409',
    'ahmadfatiridn@kamponginggrispare.com' => 'ahmad6201',
    'fadhillahnaufalazka@kamponginggrispare.com' => 'naufal7986',
    'mariskathasyaalzena@kamponginggrispare.com' => 'mariska3572',
    'farazilhan@kamponginggrispare.com' => 'shafaraz4765',
    'kayyasa.az@gamil.com' => 'kayyasa9158',
    'dinnarafizaaz310@kamponginggrispare.com' => 'dinna6347',
    'm.haidarhaq09@kamponginggrispare.com' => 'muhammad1933',
    'yassersungkar888@kamponginggrispare.com' => 'yasser8520',
    'naufalnafi34@kamponginggrispare.com' => 'muhammad7314',
    'faeyzayudistira07@kamponginggrispare.com' => 'faeyza6905',
    'aziz.nugroho.clever@kamponginggrispare.com' => 'aziz4098',
    'yazid234g@kamponginggrispare.com' => 'yazid7582',
];

header('Content-Type: text/plain');
echo "-- =============================================\n";
echo "-- SQL UPDATE PASSWORD DENGAN HASH BCRYPT\n";
echo "-- Generated: " . date('Y-m-d H:i:s') . "\n";
echo "-- =============================================\n\n";

foreach ($passwords as $email => $password) {
    $hash = hashPassword($password);
    echo "UPDATE users SET password = '$hash' WHERE email = '$email'; -- password: $password\n";
}

echo "\n-- Done! Copy SQL di atas dan jalankan di phpMyAdmin\n";
?>