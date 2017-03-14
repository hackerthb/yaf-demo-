接触yaf一个星期，没用过zend，查资料然后写了个小例子...鄙人运行环境为LNMP

nginx 配置
server {
  listen 80;
  server_name  yaf.demo.com;
  index  index.php index.html index.htm;
  root   /data0/htdocs/yaf.demo.com/public;
       location ~ .*\.(php|php5)?$
   {
     #fastcgi_pass  unix:/tmp/php-cgi.sock;
     fastcgi_pass  127.0.0.1:9000;
     fastcgi_index index.php;
     include fcgi.conf;
   }
   if (!-e $request_filename) {
        rewrite ^/(.*\.(js|ico|gif|jpg|png|css|bmp|html|xls)$) /$1 last;
        rewrite ^/(.*) /index.php?$1 last;
    }

}

apache vhost

    <VirtualHost *:80>
        DocumentRoot [project dir]/public
        ServerName yaf.dev #or whatever
    </VirtualHost>


仅仅实现了
1 用户登录
2 用户增删改查

默认账户：admin 密码：12345678

左侧目录为数据库中取出的数据，查看数据库结构便能进行修改（人员管理--管理员管理可用，其他栏目跳转为inddex）；
memcache 链接不知道是否合适，便注释了部分内容；
