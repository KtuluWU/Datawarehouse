# Datawarehouse
### Datainfogreffe

You should create first of all a folder ``config``, and then create the config file ``config.php``  for the infomations of your datebase.  
The format like this:  
 
    <?php
    $pg_pdo_conn_string = "pgsql:host=;port=;dbname=;user=;password=";
    $pg_pdo_conn_string_histo = 'pgsql:host=;port=;dbname=;user=;password=';

    $token_test = "";
 
I used two datebases in this project: MySQL and PostgreSQL.  
``$token_test`` is your key of Datainfogreffe.  
And, you need also create two folders: ``csv`` and ``upload`` for the files export and upload, as well as, ``python``and``python_zip`` for the generated files by python program, and export.
 
* * *
 
首先创建一个``config``文件夹，在里面再创建``config.php``的配置文件，用来存储你的数据库信息。  
格式如下：  
 
    <?php
    $pg_pdo_conn_string = "pgsql:host=;port=;dbname=;user=;password=";
    $pg_pdo_conn_string_histo = 'pgsql:host=;port=;dbname=;user=;password=';

    $token_test = "";
 
这里我使用了两个数据库，分别是MySQL和PostgreSQL。  
``$token_test``是你的Datainfogreffe的密钥。  
然后，你需要创建两个空的文件夹：``csv``和``upload``用来存储导出和上传的文件, 并且创建``python``和``python_zip``文件夹用来存储``python``程序生成的文件并导出。