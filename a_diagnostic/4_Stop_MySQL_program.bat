TITLE UNIFORM SERVER - Stop MySQL as a program
COLOR B0
@echo off
cls
rem ###################################################
rem # Name: $_Stop_MySQL_program.bat
rem # Created By: The Uniform Server Development Team
rem # Edited Last By: Mike Gleaves (ric)
rem # V 1.0 11-12-2009
rem ##################################################

rem ### working directory current folder 
pushd %~dp0

echo.

echo.
echo  1) STOP MySQL 
echo.
echo  Expected results:
echo.
echo  This command window will close
echo  You may be challenged by your firewall ALLOW access 
echo  After allowing access this command window closes 
echo.
echo. 
echo  After command window closes run 1_port_check.bat confirm port 3306 is free to use
echo.
echo Press any key to run test 
echo.
pause

..\usr\local\mysql\bin\mysqladmin -uroot -proot shutdown


rem ### restore original working directory
pop
