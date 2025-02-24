@echo off

SET datetimef=%date:~-4%%date:~3,2%%date:~0,2%%time:~0,2%%time:~3,2%%time:~6,2%%time:~9,2%

cd C:\xampp\htdocs\restapi\imsistatus
c:

setlocal ENABLEDELAYEDEXPANSION

SET datetimef=%datetimef: =%

echo Creation des fichiers TMP
set filetmp=%datetimef%_imsistatus_requests.txt

echo Execution du %DATE%%" "%%TIME% > %filetmp%

call execphp.bat >> %filetmp%

echo  >> %filetmp%
echo --- --- ---  >> %filetmp%

type imsistatus_requests.log >> %filetmp%

type %filetmp% > imsistatus_requests.log 

echo Suppression des fichiers TMP
DEL %filetmp% /f /q
rem DEL %filetmp2% /f /q

endlocal
