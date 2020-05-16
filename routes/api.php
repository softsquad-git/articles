<?php

include 'api/auth.api.php';
include 'api/front.api.php';
include 'api/user.api.php';

Route::post('categories', 'Categories\CategoryController@items');

/**TODO
 *  - Usuwanie konta (weryfikacja)
 *  - Zmiana hasła
 *  - Przypomnienie hasła
 *  - Zabezpieczenie akcji użytkowników
 *  - Usuwanie powiązanych elementów
 *  - Zapisywanie logów
 *  - Mail potwierdzający weryfikację adresu email
 *  - Uproszeczenie poszczególnych fukcji / poprawa wybrancyh
 *  - powiększanie zdjęć z albumów w panelu
 *  - viewer - profil użytkownika
 *  - STATUSY
 *  - zaawansowane ustawienia
 */
