aKanban
=======

A simple kanban tool holding in one PHP file.

You can rename the file to whatever you want to create multiple boards.

Data will be stored in a .txt file sharing the same name as the .php file. For example, `index.php` will create a `index.txt` file.

Make sure that this file is writable by the webserver. If it cannot automatically created, go to the script's directory and do:

    touch index.txt
    chmod 777 index.txt

