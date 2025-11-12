@echo off
REM Script to update DataTables and Lucide libraries locally
REM Usage: update_datatables.bat

echo Updating DataTables and Lucide libraries...

REM Create directory if it doesn't exist
if not exist "public\vendor\datatables" mkdir "public\vendor\datatables"
if not exist "public\vendor\lucide" mkdir "public\vendor\lucide"

echo Downloading jQuery 3.7.1...
curl -o "public\vendor\datatables\jquery-3.7.1.min.js" "https://code.jquery.com/jquery-3.7.1.min.js"

echo Downloading DataTables 1.13.8 (Bootstrap 5)...
curl -o "public\vendor\datatables\datatables.min.js" "https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"
curl -o "public\vendor\datatables\datatables.min.css" "https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.css"

echo Downloading SweetAlert2 11.10.1...
curl -o "public\vendor\datatables\sweetalert2.min.js" "https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"

echo Downloading Lucide Icons...
curl -o "public/vendor/lucide/lucide.umd.min.js" "https://unpkg.com/lucide@latest/dist/umd/lucide.js"

echo.
echo All libraries updated successfully!
echo.
echo File sizes:
dir "public\vendor\datatables\" /b
dir "public\vendor\lucide\" /b
echo.
echo Press any key to exit...
pause >nul
