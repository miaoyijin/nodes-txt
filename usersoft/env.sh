#!/bin/sh
JAVA_HOME=/opt/case/usersoft/jdk1.8.0_221
DATAX_HOME=/opt/case/usersoft/datax
JRE_HOME=$JAVA_HOME/jre
CLASS_PATH=.:$JAVA_HOME/lib/dt.jar:$JAVA_HOME/lib/tools.jar:$JRE_HOME/lib;
DATAXHOME=$DATAX_HOME
PATH=$PATH:$HOME/bin:$JAVA_HOME/bin:$JRE_HOME/bin:/opt/app/php7/bin/:/opt/case/usersoft/scala-2.11.7/bin
export PATH JAVA_HOME CLASS_PATH JRE_HOME
echo 'ok'
