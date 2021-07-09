# LatitudeLongitudeStamper
**Note: Processed images are sent to the "Uploaded" directory.**

Extensions required to run the program: gd, mbstring, exif

-- For UNIX-based Operating Systems, run the following on a terminal: 

      sudo apt-get install php7.4-{bcmath,bz2,intl,gd,mbstring,mysql,zip,exif}
      
-- For Windows 10:

     Locate php.ini in your PHP directory [In most cases, this will be in your C: Drive] then find and uncomment (remove the semicolons ;) the following: ";extension=gd", ";extension=mbstring", and ";extension=exif".

To run the program, use an IDE that runs PHP code or type the following command into your terminal while in the right directory:
-- php AddInfoStamp.php
