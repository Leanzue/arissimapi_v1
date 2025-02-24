@Echo Off


set rawfolder=C:\xampp\htdocs\restapi\imsistatus\

CD %rawfolder%
c:

php -f "execrequests.php"

