@echo off

rem ----------------------------------------------------------------------------
rem Clipper command line bootstrap script for Windows
rem @author Sergei Nazarenko @nazares <nazares@icloud.com>
rem @copyleft Copyleft (ɔ) 2023 </nazareS> Software
rem @license https://www.mit.edu/~amini/LICENSE.md
rem ----------------------------------------------------------------------------

@setlocal

set CLIPPER_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%CLIPPER_PATH%clipper" %*

@endlocal

