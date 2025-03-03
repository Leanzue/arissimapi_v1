@Echo Off

set rawfolder=C:\xampp\htdocs\arissimapi\
set queuesfolder=C:\xampp\htdocs\arissimapi\imsistatus\treatmentqueues\

CD %rawfolder%
c:

php artisan schedule:run 1>> NUL 2>&1

timeout /t 5
