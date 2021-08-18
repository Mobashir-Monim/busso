#! /bin/bash

sed -i -e "s/\(APP_DEBUG=\).*/\1false/" .env
zip ../eauth-deployment-$1.zip -r * .[^.]*
sed -i -e "s/\(APP_DEBUG=\).*/\1true/" .env