TITLE UNIFORM SERVER - Start Apache as a program
COLOR B0
@echo off
cls
rem ###################################################
rem # Name: 2_Apache_program.bat
rem # Created By: The Uniform Server Development Team
rem # Edited Last By: Mike Gleaves (ric)
rem # V 1.0 3-12-2009
rem ##################################################

rem ### working directory current folder 
pushd %~dp0

rem ### Check Apache Syntax
echo.
echo  1) SYNTAX CHECK 
echo.
echo  The following test checks Apache configuration file syntax
echo  Any errors reported must be corrected. 
echo  If syntax check is OK you will see step 2)
echo.

..\usr\local\apache2\bin\Apache.exe -t
if errorlevel 0 goto CONTINUE 
echo.
pause
exit

rem ### Run Apache
:CONTINUE 
echo.
echo  2) START APACHE 
echo.
echo  Expected results:
echo.
echo  A blank command window opens with a flashing cursor.
echo  This window remains open indicating the Apache server is running.
echo  Note: You may be challenged by your firewall ALLOW access  
echo.
echo   Do not close windows. Perform the following:
echo.
echo  Running 1_port_check.bat will show port 80 is now in use
echo  Check server is accessible. Type the following into a browser http://localhost/
echo  Uniform Server's index page is displayed
echo.
echo  Run test by pressing any key. Perform above tests.
echo.
pause

cd ..
start usr\local\apache2\bin\Apache.exe -f conf/httpd.conf  -d usr/local/apache2

echo.
echo  3) STOP APACHE 
echo.
echo  In the blank command windows click cross top right.
echo.
echo  This closes the Apache program confirm this as follows:
echo.
echo   Running 1_port_check.bat port 80 is not displayed hence port is free to use
echo   Check server is not accessible type the following into a browser http://localhost/
echo.
echo  Close this command window by pressing any key.
echo.
echo.

echo  4) FAILS TO START 
echo.
echo     1) Check ports 80 is not being blocked
echo     2) Always login as Admin
echo     3) Disable the User Account Control (UAC)
echo.
echo  Disable UAC on Windows Vista 
echo.
echo   a) Open up Control Panel, type in “UAC” into the search box.
echo   b) You will see a link for “Turn User Account Control (UAC) on or off” click this link:
echo   c) A new screen opens uncheck the box for “Use User Account Control (UAC)”, click the OK button.
echo   d) You must restart Windows.
echo.
echo  Disable UAC on Windows 7
echo.
echo   a) Type UAC into the start menu or Control Panel search box.
echo   b) Drag the slider up or down, defines how often you want to be alerted.
echo   c) Drag it all the way down to the bottom, this disables UAC entirely.
echo.

pause
rem ### restore original working directory
popd
