# docker/apache/Dockerfile
FROM httpd:2.4.51

COPY file.apache.conf /usr/local/apache2/conf/file.apache.conf



RUN echo "Include /usr/local/apache2/conf/file.apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf