# task-app
PROJEKT APLIKACJE BACK-ENDOWE
Uruchamianie aplikacji:
1.	Pobranie i zainstalowanie aplikacji XAMPP
2.	Pobranie dwóch repozytoriów github:
 https://github.com/aTomczyk113/task-app
https://github.com/aTomczyk113/task-app-front
3.	Przeniesienie ich do tej ścieżki C:/xampp/htdocs
4.	Uruchomienie w XAMPP dwóch serwisów:
Apache,
Mysql.
5.	Pobrać https://getcomposer.org/ i odpalić composer install w konsoli.
6.	W phpMyAdmin dodać bazę o nazwie: task_app.
7.	W folderze C:\xampp\htdocs\task-app-master otworzyć konsolę i wpisać: php bin/console doctrine:schema:update --force
8.	Odpalenie strony front-endowej C:\xampp\htdocs\task-app-front-master\index.html
