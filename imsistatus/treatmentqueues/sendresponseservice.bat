@Echo Off

set currentfolder=%~dp0
set rawfolder=D:\WorkPersoData\PersoData\VMs\ubuntu_20_lamp\www\arissimapi01\
set queuesfolder=%currentfolder%


CD %rawfolder%
D:

php artisan queue:work --queue=sendresponseservice --stop-when-empty

exit
