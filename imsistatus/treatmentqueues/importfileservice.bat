@Echo Off

set rawfolder=C:\xampp\htdocs\arissimapi\
set queuesfolder=C:\xampp\htdocs\arissimapi\imsistatus\treatmentqueues\


CD %rawfolder%
c:

php artisan queue:work --queue=importfileservice --stop-when-empty

exit
