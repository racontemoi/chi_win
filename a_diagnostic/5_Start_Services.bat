TITLE UNIFORM SERVER - Install Run Services test
COLOR B0
@echo off
cls
rem ###################################################
rem # Name: 5_Start_Services.bat
rem # Created By: The Uniform Server Development Team
rem # Edited Last By: Mike Gleaves (ric)
rem # V 1.0 11-12-2009
rem ###################################################

rem ### working directory current folder 
pushd %~dp0

echo.
echo === 1) INSTALL RUN MYSQL SERVICE =========================================
echo.
echo  Expected results:
echo.
echo  You may be challenged by your firewall ALLOW access 
echo  Run 1_port_check.bat confirm port 3306 is now in use
echo.
echo  Press any key to run MySQL Service   
echo.
pause
echo.
echo === Error Report =========================================================
echo.
..\usr\local\mysql\bin\mysqld-opt.exe --install MySQLS1
net start MySQLS1
echo.
echo ===================================================== END Error Report ===

pause
echo.
echo  === 2) MySQL SERVER CHECK ===============================================
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
echo === 3) INSTALL RUN APACHE SERVICE ========================================
echo.
echo  Expected results:
echo.
echo  You may be challenged twice by your firewall ALLOW access 
echo  Run 1_port_check.bat confirm port 80 is now in use
echo.
echo  Press any key to run Apache Service   
echo.
pause
echo.
echo === Error Report =========================================================
echo.
..\usr\local\apache2\bin\Apache.exe -k install -n "ApacheS1"
net start  ApacheS1
echo.
echo ===================================================== END Error Report ===
echo.
pause

rem ### restore original working directory
pop

