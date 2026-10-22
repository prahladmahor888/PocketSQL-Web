@echo off
:: PocketSQL - Local Domain Setup Helper
echo ===================================================
echo Setting up local domain: http://pocketsql.local
echo ===================================================
echo.

findstr /C:"pocketsql.local" "%WINDIR%\System32\drivers\etc\hosts" >nul 2>&1
if %errorlevel% equ 0 (
    echo [OK] pocketsql.local is already in your hosts file!
) else (
    echo Adding pocketsql.local to hosts file...
    echo. >> "%WINDIR%\System32\drivers\etc\hosts"
    echo 127.0.0.1 pocketsql.local >> "%WINDIR%\System32\drivers\etc\hosts"
    echo ::1 pocketsql.local >> "%WINDIR%\System32\drivers\etc\hosts"
    if %errorlevel% equ 0 (
        echo [SUCCESS] Domain added successfully!
    ) else (
        echo [ERROR] Failed to write. Please right click this file and select "Run as Administrator".
    )
)

echo.
echo Now restart Apache in XAMPP and open: http://pocketsql.local
echo.
pause
