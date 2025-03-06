@Echo Off

set currentfolder=%~dp0
set rawfolder=D:\WorkPersoData\PersoData\VMs\ubuntu_20_lamp\www\arissimapi01\
set queuesfolder=%currentfolder%


CD %rawfolder%
c:

php artisan queue:work --queue=batchservice --stop-when-empty

exit
