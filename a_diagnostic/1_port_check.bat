TITLE UNIFORM SERVER - Port Check
COLOR B0
@echo off
cls
rem ###################################################
rem # Name: 1__port_check.bat
rem # Created By: The Uniform Server Development Team
rem # Edited Last By: Mike Gleaves (ric)
rem # V 1.0 40-12-2009
rem ###################################################

rem ### working directory current folder 
pushd %~dp0

:AGAIN
echo.
netstat -anp tcp
echo.
echo  This test checks ports are free to use.
echo  Scan down Local Address column
echo  Look for any address ending with the following:
echo.
echo  :80   (Apache standard port)
echo  :443  (Apache standard SLL port)
echo  :3306 (MySQL standard port)
echo.
echo  Any entries found will prevent Uniform Server running
echo.
echo  Disable any program using the above ports.
echo  Generally Skype and IIS occupy port 80. Move Skype to another port, stop IIS server.
echo.
echo  Rerun test to ensure the ports are free (not listed)
echo.
echo  Note 1: Press any key to rerun.
echo  Note 2: To close this window click top right cross 
echo.
pause

cls
goto AGAIN

rem ### restore original working directory
pop

