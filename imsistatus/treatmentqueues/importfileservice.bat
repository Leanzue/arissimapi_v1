@Echo Off

set currentfolder=%~dp0
set rawfolder=C:\xampp\htdocs\arissimapi01\
set queuesfolder=%currentfolder%


CD %rawfolder%
c:

php artisan queue:work --queue=importfileservice --stop-when-empty

exit
