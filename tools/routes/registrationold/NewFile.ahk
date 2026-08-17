#Requires AutoHotkey v2.0

^!n::  ; Ctrl + Alt + N
{
    ; Get the active Explorer window
    hwnd := WinActive("A")
    for window in ComObject("Shell.Application").Windows
    {
        try
        {
            if (window.HWND = hwnd)
            {
                path := window.Document.Folder.Self.Path
                break
            }
        }
    }

    if !IsSet(path)
    {
        MsgBox "Please open a File Explorer window."
        return
    }

    result := InputBox("Enter file name (e.g. test.py, index.php, notes.txt):", "Create New File")

    if (result.Result != "OK")
        return

    file := path "\" result.Value

    if FileExist(file)
    {
        MsgBox "File already exists."
        return
    }

    FileAppend("", file)
    Run('explorer.exe /select,"' file '"')
}