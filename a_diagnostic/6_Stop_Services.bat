TITLE UNIFORM SERVER - Stop Uniinstall  Services test
COLOR B0
@echo off
cls
rem ###################################################
rem # Name: 6_Stop_Services.bat
rem # Created By: The Uniform Server Development Team
rem # Edited Last By: Mike Gleaves (ric)
rem # V 1.0 11-12-2009
rem ###################################################

rem ### working directory current folder 
pushd %~dp0


echo.
echo === 1) STOP UNINSTALL MYSQL SERVICE ======================================
echo.
echo  Expected results:
echo.
echo  Servive is stopped 
echo  Service is uninstalled
echo  Run 1_port_check.bat confirm port 3306 is now free to use
echo.
echo  Press any key to stop/uninstall MySQL Service   
echo.
pause
echo.
echo === Error Report =========================================================
echo.
net stop MySQLS1
..\usr\local\mysql\bin\mysqld-opt.exe --remove MySQLS1
echo.
echo ===================================================== END Error Report ===

pause
echo.
echo === 2) STOP UNINSTALL APACHE SERVICE =====================================
echo.
echo  Servive is stopped 
echo  Service is uninstalled
echo  Run 1_port_check.bat confirm port 80 is now free to use
echo.
echo  Press any key to stop/uninstall Apache Service   
echo.
pause
echo.
echo === Error Report =========================================================
echo.

net stop ApacheS1
..\usr\local\apache2\bin\Apache.exe -k uninstall -n "ApacheS1"
echo.
echo ===================================================== END Error Report ===

echo.
pause

rem ### restore original working directory
popd
