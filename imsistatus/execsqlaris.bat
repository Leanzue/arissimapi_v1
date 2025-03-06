@Echo Off

set currentfolder=%~dp0
set rawfolder=D:\WorkPersoData\PersoData\VMs\ubuntu_20_lamp\www\arissimapi01\
set responsefolder=%currentfolder%respfiles\

set username=esim
set userpwd="#Mdp#Moovgt321!"
set iccparam_old=892410100102500003
set fileprefix_old=kkkloplmmm
set iccparam=%1
set fileprefix=%2
set fileextension=%3

set filerequest=%fileprefix%_req.%fileextension%
set fileresponse=%fileprefix%_res.csv
set reportfilefolder=report.csv

CD %responsefolder%
D:

sqlcmd -E -Q "EXEC OSS360.dbo._STATUTS_SIM @ICC='%iccparam_old%'" -o %fileresponse% -S "192.168.7.50,1433" -t 65534 -s "|"

rem -U "%username%" -P "%userpwd%"
pause
exit
