 Aplikacja została wykonana przy użyciu **php: 7.4** oraz **symfony: 4.4**

- Aby uruchomić należy zainstalować bibliteki php wskazane w dokumentacji symfony:
   - https://symfony.com/doc/4.4/setup.html
 - Dodatkowo trzeba doinstalować bibliotekę GD do php:
   - https://www.php.net/manual/en/image.installation.php
#
Po zainstalowaniu wymaganych bibliotek należy uruchomić komendę:
 - composer install
#

W pliku .env znajdują się dwie pozycje do skonfigurowania:
  - DROPBOX_SECRET=<APP_SECRET> - tutaj <APP_SECRET> należy zamienić na wygenerowany token w aplikacji Dropbox aby nawiązać połączenie
  - DROPBOX_FOLDER=/ - tutaj należy wpisać ścieżkę folderu w usłudze Dropbox, w którym będą zapisywać się przeskalowane zdjęcia

Po wykonaniu tych kroków aplikację można wywołać komendą:
   - bin/console app:resize **<szerokość_obrazka_po_przeskalowaniu_w_px>** **<wysokość_obrazka_po_przeskalowaniu_w_px>**
   
Zdjęcia do przeskalowania wrzucamy do folderu **documents/images**, skrypt po uruchomieniu komendy je wyszuka, przeskaluje i zapisze w chmurze oraz na lokalnym dysku w folderze **documents/resized_images**
