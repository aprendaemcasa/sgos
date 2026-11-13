@echo off
title Preparando SGOS
cd /d "%~dp0"
echo Preparando o SGOS para Windows 64 bits...
dotnet publish SGOS.csproj -c Release -r win-x64 --self-contained true -p:PublishSingleFile=true -p:IncludeNativeLibrariesForSelfExtract=true -o "%~dp0Aplicativo"
if errorlevel 1 (
  echo.
  echo Falha ao preparar o SGOS. Verifique se o SDK .NET 8 esta instalado.
  pause
  exit /b 1
)
echo.
echo Preparacao concluida. Abrindo SGOS...
start "" "%~dp0Aplicativo\SGOS.exe"
