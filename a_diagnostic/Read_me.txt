 ###############################################################################
 # File name: Read_me.txt
 # Created By: The Uniform Server Development Team
 # V 1.0 11-12-2009
 ###############################################################################

 When Uniform Server fails to start you need to determine an underlying cause.
 Diagnostics is all about gathering information hopefully pin pointing a cause
 and a possible solution.

 If the servers unexpectedly crash or fail to start no error logs are produced
 making diagnostics difficult. Added to this are system variations the cause
 of a failure may be hidden and the resulting error messages masking a real
 cause?

 -----------
 Diagnostics
 -----------

 This folder contains several batch files that are intended to isolate specific
 problem areas and gather as much information as possible to aid diagnostics.

 1) Always start with a fresh install of Uniform Server
 2) Before performing tests restart the PC this provides a know state.
 3) Run server_status.bat before performing any tests
 4) Tests should be run in the following order:

    1_port_check.bat
    2_Apache_program.bat
    3_Start_MySQL_program.bat
    4_Stop_MySQL_program.bat
    5_Start_Services.bat
    6_Stop_Services.bat  

 -------
 General
 -------

 Fails to start general causes: 
  1) Check ports are not in use - Run first test
  2) Check ports are not being blocked by some other progam such as a firewall
  3) Always login as Admin
  4) Disable the User Account Control (UAC)

 Disable UAC on Windows Vista 
  a) Open up Control Panel, type in “UAC” into the search box.
  b) You will see a link for “Turn User Account Control (UAC)
      on or off” click this link:
  c) A new screen opens uncheck the box for “Use User Account Control (UAC)”,
     click the OK button.
  d) You must restart Windows.

 Disable UAC on Windows 7
  a) Type UAC into the start menu or Control Panel search box.
  b) Drag the slider up or down, defines how often you want to be alerted.
  c) Drag it all the way down to the bottom, this disables UAC entirely.

 Tests:
  Tests directly run servers as a standard program or service bypassing Uniform
  Server’s control architecture. This allows you to determine if a problem is
  specific to either Apache or MySQL.

 ----------------
 1_port_check.bat
 ----------------

 Uniform Server will not start if one of the following ports is in use
 by another program.

  80   - Apache standard port
  443  - Apache standard SLL port
  3306 - (MySQL standard port

 Run 1_port_check.bat and confirm ports are free to use.

 This batch file is a continuous loop, click in window and press any key to
 refresh. You can close it by clicking on cross top right.

 --------------------
 2_Apache_program.bat
 --------------------
 
 This test allows you to start and stop Apache as a standard program.
 The script contains detailed instructions follow these.    
 
 -------------------------
 3_Start_MySQL_program.bat
 4_Stop_MySQL_program.bat
 -------------------------

 This test allows you to start and stop MySQL as a standard program.
 The scripts contains detailed instructions follow these. 

 --------------------
 5_Start_Services.bat
 6_Stop_Services.bat 
 --------------------

 These scripts allow you to install/run and stop/uninstall both servers
 as a service. The script contains detailed instructions follow these.

 Note: If the servers failed to run as a standard program there is no
       point in running this service test. 

 ---------- 
 Forum Help
 ----------

 If you cannot resole an issue from the information gathered post on Uniform
 Servers’s forum.

 Please provide constructive inform, comments like “it does not work” reminds
 me of a crystal ball I took back to a shop because it did not function.

 My point we do not have a crystal ball hence we need to know the following
 information:

 1) What is the Windows operating system and version?
 2) What version of Uniform Server are you using?
 3) What error messages are produced?
 4) Have you checked the error log: UniServer\usr\local\apache2\logs\error.log
 5) Have you checked the error log: UniServer\usr\local\mysql\data\mysql.err

 Note: At step 3 you can capture text displayed in a command window (batch files)
       see file  Grab_screen_text.txt for details.
 
 Don’t be put off posting on the forum just supply as much information as
 possible. It’s a large and friendly community that is willing to help
 and resolve issues.

                               --- End ---



