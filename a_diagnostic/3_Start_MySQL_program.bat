TITLE UNIFORM SERVER - Start MySQL as a program
COLOR B0
@echo off
cls
rem ###################################################
rem # Name: 3_Start_MySQL_program.bat
rem # Created By: The Uniform Server Development Team
rem # Edited Last By: Mike Gleaves (ric)
rem # V 1.0 10-12-2009
rem ##################################################

rem ### working directory current folder 
pushd %~dp0

echo.
rem ### Run MySQL

echo.
echo  1) START MySQL 
echo.
echo  Expected results:
echo.
echo  A blank command window opens and remains
echo  You may be challenged by your firewall ALLOW access 
echo  After allowing access the command window closes 
echo.
echo  Note: If you are not challenged by your firewall
echo        the command window apears to flash once.
echo.
echo  Press any key to run MySQL   
echo.
pause
start ..\usr\local\mysql\bin\mysqld-opt.exe 

echo.
echo  2) PORT CHECK
echo. 
echo  Running 1_port_check.bat will show port 3306 is now in use
echo.
pause

echo.
echo  3) SERVER CHECK
echo. 
echo  The following test runs a SQL query on the MySQL server
echo.
echo.
echo === Epected results similar to this ======================================
echo.
echo Connection id:          12
echo SSL:                    Not in use
echo Using delimiter:        ;
echo Server version:         5.1.41-community MySQL Community Server (GPL)
echo Protocol version:       10
echo Connection:             localhost via TCP/IP
echo Client characterset:    utf8
echo Server characterset:    utf8
echo TCP port:               3306
echo Uptime:                 39 min 10 sec
echo Threads: 1  Questions: 43  Slow queries: 0  Opens: 15  Flush tables: 1  Open tables: 0  Queries per second avg: 0.18
echo --------------
echo Database
echo information_schema
echo mysql
echo phpmyadmin
echo.
echo ==========================================================================
echo.
echo  To run test Press any key
echo  Note: You may be challenged by your firewall ALLOW access 
echo.

pause
echo.
echo === Actual results =======================================================
..\usr\local\mysql\bin\mysql -uroot -proot < test.sql
echo ==========================================================================
echo.

pause
echo.
echo  4) FAILS TO START 
echo.
echo     1) Check ports 3306 is not being blocked
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
pop
