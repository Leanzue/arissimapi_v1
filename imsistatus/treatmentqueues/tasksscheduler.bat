@Echo Off

set currentfolder=%~dp0
set rawfolder=C:\xampp\htdocs\arissimapi\
set queuesfolder=%currentfolder%imsistatus\treatmentqueues\

CD %rawfolder%
c:

php artisan schedule:run 1>> NUL 2>&1

pause
timeout /t 5

