@Echo Off

set rawfolder=D:\WorkPersoData\PersoData\VMs\ubuntu_20_lamp\www\arissimapi01\
set queuesfolder=D:\WorkPersoData\PersoData\VMs\ubuntu_20_lamp\www\arissimapi01\imsistatus\treatmentqueues\

CD %rawfolder%
c:

php artisan schedule:run 1>> NUL 2>&1


timeout /t 5
