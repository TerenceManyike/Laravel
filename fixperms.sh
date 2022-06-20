#!/bin/bash

set -x
user=dev

chown -R www-data:$user .

find . -type f -exec chmod 664 {} +
find . -type f -exec chown www-data:$user {} +
find . -type d -exec chmod 775 {} +

chmod 770 $0
