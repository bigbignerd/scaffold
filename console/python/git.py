#!/usr/bin/env python
# -*- coding: utf-8 -*-  
import os

foler_list = []

baseFolder = '/alidata/www/technology'
exe_command = 'git pull origin master'
folders = os.listdir(baseFolder)

for name in folders:
        if(os.path.isdir(baseFolder+'/'+name)):
                foler_list.append(name)
        else:
                continue

for link in foler_list:
        print '\033[1;31;40m'
        print 'Updating:'+link
        print '\033[0m'
        res = os.system('cd '+os.path.join(baseFolder,link,'www')+';'+exe_command)
        # res = os.popen('cd '+os.path.join(baseFolder,link)+'; ls -a').read();
        print res
